<?php

namespace App\Services;

use App\Models\Review;
use App\Models\User;
use App\Models\UserPlatform;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleBusinessService
{
    private string $token;
    private UserPlatform $platform;

    public function __construct(private User $user)
    {
        $platform = $user->platforms()->where('platform', 'google')->first();

        if (!$platform) {
            throw new \RuntimeException('Google platform nincs csatlakoztatva.');
        }

        $this->platform = $platform;
        $this->token    = $this->getFreshToken();
    }

    // ── Token management ──────────────────────────────────────────────────────

    private function getFreshToken(): string
    {
        if (!$this->platform->isTokenExpired()) {
            return $this->platform->access_token;
        }

        if (!$this->platform->refresh_token) {
            throw new \RuntimeException('Nincs refresh token — csatlakoztasd újra a Google fiókot.');
        }

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id'     => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'refresh_token' => $this->platform->refresh_token,
            'grant_type'    => 'refresh_token',
        ]);

        if ($response->failed()) {
            throw new \RuntimeException('Token frissítés sikertelen: ' . $response->body());
        }

        $data = $response->json();

        $this->platform->update([
            'access_token'     => $data['access_token'],
            'token_expires_at' => now()->addSeconds($data['expires_in'] ?? 3600),
        ]);

        return $data['access_token'];
    }

    // ── Raw HTTP helper ───────────────────────────────────────────────────────

    private function get(string $url, array $query = []): array
    {
        $response = Http::withToken($this->token)->get($url, $query);

        if ($response->failed()) {
            Log::warning('Google Business API hiba', [
                'url'    => $url,
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return [];
        }

        return $response->json() ?? [];
    }

    // ── API calls ─────────────────────────────────────────────────────────────

    public function getAccounts(): array
    {
        $data = $this->get('https://mybusinessaccountmanagement.googleapis.com/v1/accounts');
        return $data['accounts'] ?? [];
    }

    public function getLocations(string $accountName): array
    {
        $data = $this->get(
            "https://mybusinessbusinessinformation.googleapis.com/v1/{$accountName}/locations",
            ['readMask' => 'name,title,storefrontAddress,websiteUri']
        );
        return $data['locations'] ?? [];
    }

    public function getReviews(string $locationName, int $pageSize = 50): array
    {
        // locationName: "accounts/{accountId}/locations/{locationId}"
        $data = $this->get(
            "https://mybusiness.googleapis.com/v4/{$locationName}/reviews",
            ['pageSize' => $pageSize]
        );
        return $data['reviews'] ?? [];
    }

    // ── Main sync ─────────────────────────────────────────────────────────────

    public function syncReviews(): array
    {
        $accounts      = $this->getAccounts();
        $synced        = 0;
        $locationCount = 0;
        $errors        = [];

        foreach ($accounts as $account) {
            $accountName = $account['name']; // "accounts/123456789"
            $locations   = $this->getLocations($accountName);
            $locationCount += count($locations);

            foreach ($locations as $location) {
                $locationName = $location['name']; // "accounts/xxx/locations/yyy"

                try {
                    $reviews = $this->getReviews($locationName);
                } catch (\Exception $e) {
                    $errors[] = $locationName . ': ' . $e->getMessage();
                    continue;
                }

                foreach ($reviews as $review) {
                    $this->user->reviews()->updateOrCreate(
                        ['platform_review_id' => $review['reviewId']],
                        [
                            'platform'      => 'google',
                            'reviewer_name' => $review['reviewer']['displayName'] ?? 'Névtelen',
                            'stars'         => $this->starsToInt($review['starRating'] ?? 'ZERO'),
                            'content'       => $review['comment'] ?? null,
                            'reviewed_at'   => isset($review['createTime'])
                                ? \Carbon\Carbon::parse($review['createTime'])
                                : now(),
                        ]
                    );
                    $synced++;
                }
            }
        }

        $this->platform->update(['locations_count' => $locationCount]);

        return [
            'synced'    => $synced,
            'locations' => $locationCount,
            'accounts'  => count($accounts),
            'errors'    => $errors,
        ];
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function starsToInt(string $rating): int
    {
        return match ($rating) {
            'ONE'   => 1,
            'TWO'   => 2,
            'THREE' => 3,
            'FOUR'  => 4,
            'FIVE'  => 5,
            default => 0,
        };
    }
}

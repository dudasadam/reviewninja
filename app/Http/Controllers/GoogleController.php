<?php

namespace App\Http\Controllers;

use App\Models\UserPlatform;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to Google's OAuth page.
     * Requests offline access so we get a refresh_token.
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')
            ->scopes([
                'openid',
                'email',
                'profile',
                'https://www.googleapis.com/auth/business.manage',
            ])
            ->with([
                'access_type' => 'offline',
                'prompt'      => 'consent select_account',
            ])
            ->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.platforms')
                ->with('error', 'Google csatlakozás sikertelen: ' . $e->getMessage());
        }

        $user = Auth::user();

        $user->platforms()->updateOrCreate(
            ['platform' => 'google'],
            [
                'google_account_id' => $googleUser->getEmail(),
                'business_id'       => $googleUser->getId(),
                'profile_url'       => $googleUser->user['link'] ?? null,
                'access_token'      => $googleUser->token,
                'refresh_token'     => $googleUser->refreshToken ?? null,
                'token_expires_at'  => $googleUser->expiresIn
                    ? now()->addSeconds($googleUser->expiresIn)
                    : null,
                'active'            => true,
                'connected_at'      => now(),
            ]
        );

        return redirect()->route('admin.settings.platforms')
            ->with('success', '✓ Google Business fiók sikeresen csatlakoztatva! (' . $googleUser->getEmail() . ')');
    }

    /**
     * Disconnect the Google platform.
     */
    public function disconnect(): RedirectResponse
    {
        Auth::user()->platforms()->where('platform', 'google')->delete();

        return redirect()->route('admin.settings.platforms')
            ->with('success', 'Google fiók sikeresen leválasztva.');
    }
}

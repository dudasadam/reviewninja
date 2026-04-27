<?php

namespace App\Http\Controllers;

use App\Services\GoogleBusinessService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();

        $query = $user->reviews()->latest('reviewed_at');

        if ($stars = $request->integer('stars')) {
            $query->where('stars', $stars);
        }

        if ($platform = $request->input('platform')) {
            $query->where('platform', $platform);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reviewer_name', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $reviews = $query->paginate(20)->withQueryString();

        $stats = [
            'total'   => $user->reviews()->count(),
            'average' => round($user->reviews()->avg('stars') ?? 0, 1),
            'google'  => $user->reviews()->where('platform', 'google')->count(),
            'replied' => $user->reviews()->where('replied', true)->count(),
        ];

        $platforms = $user->reviews()->select('platform')->distinct()->pluck('platform');

        return view('admin.reviews.index', compact('reviews', 'stats', 'platforms'));
    }

    public function sync(): RedirectResponse
    {
        try {
            $service = new GoogleBusinessService(Auth::user());
            $result  = $service->syncReviews();

            $msg = "✓ Szinkronizálás kész: {$result['synced']} értékelés, {$result['locations']} helyszín";

            if (!empty($result['errors'])) {
                $msg .= ' (néhány hiba: ' . implode(', ', $result['errors']) . ')';
            }

            return redirect()->route('admin.reviews.index')->with('success', $msg);

        } catch (\Exception $e) {
            return redirect()->route('admin.reviews.index')
                ->with('error', 'Szinkronizálás sikertelen: ' . $e->getMessage());
        }
    }
}

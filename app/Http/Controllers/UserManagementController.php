<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(): View
    {
        $users = User::orderByDesc('created_at')->paginate(25);
        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'company_name'      => 'nullable|string|max:255',
            'phone'             => 'nullable|string|max:30',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|string|min:8|confirmed',
            'role'              => 'required|in:superadmin,admin,user',
            'status'            => 'required|in:active,trial,suspended',
            'subscription_plan' => 'nullable|string|max:30',
            'trial_ends_at'     => 'nullable|date',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        // Create default settings row
        $user->settings()->create([
            'company_display_name' => $data['company_name'] ?? $data['name'],
        ]);

        // Create default automation rule
        $user->automationRule()->create([
            'channels'  => ['sms', 'email'],
            'reminders' => [
                ['delay_value' => 3, 'delay_unit' => 'day', 'channel' => 'sms'],
                ['delay_value' => 7, 'delay_unit' => 'day', 'channel' => 'email'],
            ],
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Felhasználó ({$user->email}) sikeresen létrehozva.");
    }

    public function show(User $user): View
    {
        $user->load(['settings', 'platforms', 'integrations', 'templates', 'automationRule']);
        $stats = [
            'customers'       => $user->customers()->count(),
            'review_requests' => $user->reviewRequests()->count(),
            'reviews'         => $user->reviews()->count(),
            'avg_stars'       => round($user->reviews()->avg('stars') ?? 0, 1),
        ];
        return view('admin.users.show', compact('user', 'stats'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'company_name'      => 'nullable|string|max:255',
            'phone'             => 'nullable|string|max:30',
            'email'             => "required|email|unique:users,email,{$user->id}",
            'role'              => 'required|in:superadmin,admin,user',
            'status'            => 'required|in:active,trial,suspended',
            'subscription_plan' => 'nullable|string|max:30',
            'trial_ends_at'     => 'nullable|date',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Felhasználó adatai frissítve.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Felhasználó törölve.');
    }

    public function impersonate(User $user): RedirectResponse
    {
        // Store original admin ID in session, then login as user
        session(['impersonating_admin' => auth()->id()]);
        auth()->login($user);
        return redirect()->route('admin.dashboard')
            ->with('info', "Most {$user->name} nevében navigálsz.");
    }

    public function stopImpersonating(): RedirectResponse
    {
        $adminId = session('impersonating_admin');
        session()->forget('impersonating_admin');
        if ($adminId) {
            auth()->loginUsingId($adminId);
        }
        return redirect()->route('admin.users.index');
    }
}

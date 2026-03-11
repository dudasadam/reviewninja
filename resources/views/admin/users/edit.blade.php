@extends('admin.layout')

@section('title', $user->name . ' szerkesztése')
@section('page-title', 'Felhasználó szerkesztése')
@section('breadcrumb', 'Felhasználók › ' . $user->name)

@section('content')

@if (session('success'))
    <div class="rn-alert rn-alert--success mb-4">{{ session('success') }}</div>
@endif

<div class="row justify-content-center">
<div class="col-xl-8">
<form method="POST" action="{{ route('admin.users.update', $user) }}">
    @csrf @method('PUT')

    <div class="rn-admin-card mb-4">
        <h2 class="rn-card-title mb-4">Alapadatok</h2>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="rn-form-group">
                    <label class="rn-label">Teljes név *</label>
                    <input type="text" name="name" class="rn-input" value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="rn-field-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="rn-form-group">
                    <label class="rn-label">Cégnév</label>
                    <input type="text" name="company_name" class="rn-input" value="{{ old('company_name', $user->company_name) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="rn-form-group">
                    <label class="rn-label">Email *</label>
                    <input type="email" name="email" class="rn-input" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="rn-field-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="rn-form-group">
                    <label class="rn-label">Telefonszám</label>
                    <input type="tel" name="phone" class="rn-input" value="{{ old('phone', $user->phone) }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="rn-form-group">
                    <label class="rn-label">Új jelszó (hagyd üresen, ha nem változtatod)</label>
                    <input type="password" name="password" class="rn-input">
                    @error('password') <div class="rn-field-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="rn-form-group">
                    <label class="rn-label">Jelszó megerősítése</label>
                    <input type="password" name="password_confirmation" class="rn-input">
                </div>
            </div>
        </div>
    </div>

    <div class="rn-admin-card mb-4">
        <h2 class="rn-card-title mb-4">Jogosultság & Státusz</h2>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="rn-form-group">
                    <label class="rn-label">Szerepkör *</label>
                    <select name="role" class="rn-input" required>
                        <option value="user"       {{ old('role', $user->role) === 'user'       ? 'selected' : '' }}>user</option>
                        <option value="admin"      {{ old('role', $user->role) === 'admin'      ? 'selected' : '' }}>admin</option>
                        <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>superadmin</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="rn-form-group">
                    <label class="rn-label">Státusz *</label>
                    <select name="status" class="rn-input" required>
                        <option value="trial"     {{ old('status', $user->status) === 'trial'     ? 'selected' : '' }}>trial</option>
                        <option value="active"    {{ old('status', $user->status) === 'active'    ? 'selected' : '' }}>active</option>
                        <option value="suspended" {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}>suspended</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="rn-form-group">
                    <label class="rn-label">Csomag</label>
                    <select name="subscription_plan" class="rn-input">
                        @foreach (['trial','starter','pro','enterprise'] as $plan)
                        <option value="{{ $plan }}" {{ old('subscription_plan', $user->subscription_plan) === $plan ? 'selected' : '' }}>{{ $plan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="rn-form-group">
                    <label class="rn-label">Trial lejárat</label>
                    <input type="datetime-local" name="trial_ends_at" class="rn-input"
                           value="{{ old('trial_ends_at', $user->trial_ends_at?->format('Y-m-d\TH:i')) }}">
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-3">
        <a href="{{ route('admin.users.show', $user) }}" class="btn rn-btn rn-btn-ghost">Mégse</a>
        <button type="submit" class="btn rn-btn rn-btn-primary px-5">Mentés</button>
    </div>
</form>
</div>
</div>

@endsection

@extends('admin.layout')

@section('title', 'Új felhasználó')
@section('page-title', 'Új felhasználó')
@section('breadcrumb', 'Felhasználók › Új')

@section('content')

<div class="row justify-content-center">
<div class="col-xl-8">
<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf

    <div class="rn-admin-card mb-4">
        <h2 class="rn-card-title mb-4">Alapadatok</h2>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="rn-form-group">
                    <label class="rn-label">Teljes név *</label>
                    <input type="text" name="name" class="rn-input @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required>
                    @error('name') <div class="rn-field-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="rn-form-group">
                    <label class="rn-label">Cégnév</label>
                    <input type="text" name="company_name" class="rn-input"
                           value="{{ old('company_name') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="rn-form-group">
                    <label class="rn-label">Email *</label>
                    <input type="email" name="email" class="rn-input @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required>
                    @error('email') <div class="rn-field-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="rn-form-group">
                    <label class="rn-label">Telefonszám</label>
                    <input type="tel" name="phone" class="rn-input" value="{{ old('phone') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="rn-form-group">
                    <label class="rn-label">Jelszó *</label>
                    <input type="password" name="password" class="rn-input @error('password') is-invalid @enderror" required>
                    @error('password') <div class="rn-field-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="rn-form-group">
                    <label class="rn-label">Jelszó megerősítése *</label>
                    <input type="password" name="password_confirmation" class="rn-input" required>
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
                        <option value="user"       {{ old('role') === 'user'       ? 'selected' : '' }}>user</option>
                        <option value="admin"      {{ old('role') === 'admin'      ? 'selected' : '' }}>admin</option>
                        <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>superadmin</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="rn-form-group">
                    <label class="rn-label">Státusz *</label>
                    <select name="status" class="rn-input" required>
                        <option value="trial"     {{ old('status', 'trial') === 'trial'     ? 'selected' : '' }}>trial</option>
                        <option value="active"    {{ old('status') === 'active'    ? 'selected' : '' }}>active</option>
                        <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>suspended</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="rn-form-group">
                    <label class="rn-label">Csomag</label>
                    <select name="subscription_plan" class="rn-input">
                        <option value="trial">trial</option>
                        <option value="starter">starter</option>
                        <option value="pro">pro</option>
                        <option value="enterprise">enterprise</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="rn-form-group">
                    <label class="rn-label">Trial lejárat</label>
                    <input type="datetime-local" name="trial_ends_at" class="rn-input" value="{{ old('trial_ends_at') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-3">
        <a href="{{ route('admin.users.index') }}" class="btn rn-btn rn-btn-ghost">Mégse</a>
        <button type="submit" class="btn rn-btn rn-btn-primary px-5">Létrehozás</button>
    </div>
</form>
</div>
</div>

@endsection

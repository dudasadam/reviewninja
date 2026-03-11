@extends('admin.layout')

@section('title', 'Felhasználók')
@section('page-title', 'Felhasználók')

@section('content')

@if (session('success'))
    <div class="rn-alert rn-alert--success mb-4">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div class="d-flex gap-2 flex-wrap">
        {{-- Search --}}
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="q" class="rn-input" style="min-width:220px"
                   placeholder="Keresés (név, email, cég)…" value="{{ request('q') }}">
            <button class="btn rn-btn rn-btn-ghost">Keresés</button>
        </form>
        {{-- Status filter --}}
        <select class="rn-input" style="width:auto" onchange="this.form.submit()" form="filterForm">
            <option value="">Minden státusz</option>
            <option value="active"    {{ request('status') === 'active'    ? 'selected' : '' }}>Aktív</option>
            <option value="trial"     {{ request('status') === 'trial'     ? 'selected' : '' }}>Trial</option>
            <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Felfüggesztett</option>
        </select>
        <form id="filterForm" method="GET">
            <input type="hidden" name="q" value="{{ request('q') }}">
        </form>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn rn-btn rn-btn-primary">+ Új felhasználó</a>
</div>

<div class="rn-admin-card p-0 overflow-hidden">
    <div class="rn-table-wrap">
        <table class="rn-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Felhasználó</th>
                    <th>Szerepkör</th>
                    <th>Státusz</th>
                    <th>Csomag</th>
                    <th>Regisztráció</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td class="rn-td-id">{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rn-user-avatar rn-user-avatar--sm">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            <div>
                                <div class="fw-semibold">{{ $user->name }}</div>
                                <small class="rn-muted-text">{{ $user->email }}</small>
                                @if ($user->company_name)
                                    <small class="rn-muted-text d-block">{{ $user->company_name }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td><span class="rn-role-badge rn-role-badge--{{ $user->role }}">{{ $user->role }}</span></td>
                    <td><span class="rn-status-badge rn-status-badge--{{ $user->status }}">{{ $user->status }}</span></td>
                    <td><span class="rn-muted-text">{{ $user->subscription_plan ?? 'trial' }}</span></td>
                    <td><small class="rn-muted-text">{{ $user->created_at->format('Y.m.d') }}</small></td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.show', $user) }}" class="rn-icon-btn" title="Részletek">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="rn-icon-btn" title="Szerkesztés">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.users.impersonate', $user) }}" style="display:inline">
                                @csrf
                                <button type="submit" class="rn-icon-btn" title="Belépés felhasználóként">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline"
                                  onsubmit="return confirm('Biztosan törlöd ezt a felhasználót?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="rn-icon-btn rn-icon-btn--danger" title="Törlés">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center rn-muted-text py-5">Nincs felhasználó.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($users->hasPages())
    <div class="rn-pagination">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection

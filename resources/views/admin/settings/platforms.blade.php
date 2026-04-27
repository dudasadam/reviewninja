@extends('admin.layout')

@section('title', 'Platformok')
@section('page-title', 'Platformok')
@section('breadcrumb', 'Beállítások › Platformok')

@section('content')

<p class="rn-page-desc mb-4">Kösd össze a review platformokat, ahol az ügyfeleid értékelhetnek. Minden aktív platform értékeléseit összegyűjtjük és kezeljük.</p>

{{-- Szinkronizálás gomb ha van csatlakoztatott platform --}}
@if(collect($platforms)->where('connected', true)->isNotEmpty())
<div class="d-flex align-items-center gap-3 mb-4">
    <form method="POST" action="{{ route('admin.reviews.sync') }}" class="m-0">
        @csrf
        <button type="submit" class="btn rn-btn rn-btn-primary btn-sm">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right:.3rem;vertical-align:middle"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
            Értékelések szinkronizálása
        </button>
    </form>
    <small class="rn-muted-text">Lehúzza a legfrissebb értékeléseket a csatlakoztatott platformokról</small>
</div>
@endif

{{-- Flash üzenetek --}}
@if(session('success'))
<div class="rn-alert rn-alert--success mb-4">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="rn-alert rn-alert--danger mb-4">
    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    {{ session('error') }}
</div>
@endif

<div class="row g-4">
    @foreach ($platforms as $p)
    <div class="col-md-6 col-xl-4">
        <div class="rn-admin-card rn-platform-card {{ $p['connected'] ? 'rn-platform-card--connected' : '' }}">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="rn-platform-logo" style="--p-color: {{ $p['color'] }}">
                    @if ($p['key'] === 'google')
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.1c-.22-.66-.35-1.36-.35-2.1s.13-1.44.35-2.1V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.83z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.83C6.71 7.31 9.14 5.38 12 5.38z" fill="#EA4335"/></svg>
                    @elseif ($p['key'] === 'facebook')
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    @elseif ($p['key'] === 'tripadvisor')
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#34E0A1"><circle cx="12" cy="12" r="11"/><text x="6" y="16" font-size="10" fill="#000" font-weight="bold">TA</text></svg>
                    @elseif ($p['key'] === 'trustpilot')
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#00B67A"><path d="m12 1 3.09 6.26L22 8.27l-5 4.87 1.18 6.88L12 16.77l-6.18 3.25L7 13.14 2 8.27l6.91-1.01L12 1z"/></svg>
                    @else
                        <svg width="24" height="24" fill="none" stroke="{{ $p['color'] }}" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/></svg>
                    @endif
                </div>
                <div class="flex-grow-1">
                    <div class="rn-platform-name fw-semibold">{{ $p['name'] }}</div>
                    @if ($p['connected'])
                        <small class="rn-badge-connected">
                            ● Csatlakoztatva
                            @if($p['key'] === 'google' && $p['google_account'])
                                – {{ $p['google_account'] }}
                            @elseif($p['locations'])
                                ({{ $p['locations'] }} helyszín)
                            @endif
                        </small>
                    @else
                        <small class="rn-muted-text">Nincs csatlakoztatva</small>
                    @endif
                </div>
            </div>
            @if ($p['connected'])
                <div class="d-flex gap-2">
                    <button class="btn rn-btn rn-btn-ghost btn-sm flex-grow-1">Beállítás</button>
                    @if($p['key'] === 'google')
                        <form method="POST" action="{{ route('admin.google.disconnect') }}" class="m-0"
                              onsubmit="return confirm('Biztosan leválasztod a Google fiókot?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn rn-btn-danger btn-sm">Leválasztás</button>
                        </form>
                    @else
                        <button class="btn rn-btn-danger btn-sm">Leválasztás</button>
                    @endif
                </div>
            @else
                @if($p['key'] === 'google')
                    <a href="{{ route('admin.google.redirect') }}" class="btn rn-btn rn-btn-primary btn-sm w-100">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="margin-right:.35rem;vertical-align:middle"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.1c-.22-.66-.35-1.36-.35-2.1s.13-1.44.35-2.1V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.83z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.83C6.71 7.31 9.14 5.38 12 5.38z" fill="#EA4335"/></svg>
                        Csatlakoztatás Google-lel
                    </a>
                @else
                    <button class="btn rn-btn rn-btn-primary btn-sm w-100 rn-connect-btn" data-platform="{{ $p['key'] }}">
                        + Csatlakoztatás
                    </button>
                @endif
            @endif
        </div>
    </div>
    @endforeach
</div>

{{-- Csatlakoztatás modal --}}
<div class="rn-modal-overlay" id="connectModal" style="display:none">
    <div class="rn-modal">
        <div class="rn-modal-header">
            <h3 class="rn-modal-title" id="modalTitle">Platform csatlakoztatása</h3>
            <button class="rn-modal-close" id="modalClose">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="rn-modal-body">
            <p class="rn-muted-text mb-4">Add meg a szükséges hozzáférési adatokat a platform összekötéséhez.</p>
            <div class="rn-form-group">
                <label class="rn-label">Business ID / Profil URL</label>
                <input type="text" class="rn-input" placeholder="pl. https://g.page/...">
            </div>
            <div class="rn-form-group">
                <label class="rn-label">API kulcs (opcionális)</label>
                <input type="password" class="rn-input" placeholder="••••••••••••">
            </div>
        </div>
        <div class="rn-modal-footer">
            <button class="btn rn-btn rn-btn-ghost" id="modalCancel">Mégse</button>
            <button class="btn rn-btn rn-btn-primary">Csatlakoztatás</button>
        </div>
    </div>
</div>

@endsection

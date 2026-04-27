@extends('admin.layout')

@section('title', 'Értékelések')
@section('page-title', 'Értékelések')
@section('breadcrumb', 'Értékelések')

@section('content')

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

{{-- KPI sor --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="rn-admin-card rn-kpi-card">
            <div class="rn-kpi-label">Összes értékelés</div>
            <div class="rn-kpi-value">{{ number_format($stats['total']) }}</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="rn-admin-card rn-kpi-card">
            <div class="rn-kpi-label">Átlagos értékelés</div>
            <div class="rn-kpi-value">
                {{ $stats['average'] > 0 ? $stats['average'] : '–' }}
                @if($stats['average'] > 0)<span style="font-size:.9rem;color:#FBBF24">★</span>@endif
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="rn-admin-card rn-kpi-card">
            <div class="rn-kpi-label">Google értékelés</div>
            <div class="rn-kpi-value">{{ number_format($stats['google']) }}</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="rn-admin-card rn-kpi-card">
            <div class="rn-kpi-label">Megválaszolva</div>
            <div class="rn-kpi-value">{{ number_format($stats['replied']) }}</div>
        </div>
    </div>
</div>

{{-- Szűrő + sync --}}
<div class="rn-admin-card mb-4">
    <form method="GET" action="{{ route('admin.reviews.index') }}" class="d-flex flex-wrap gap-2 align-items-end">
        <div>
            <label class="rn-label">Keresés</label>
            <input type="text" name="search" class="rn-input" placeholder="Értékelő neve vagy szöveg…" value="{{ request('search') }}" style="width:220px">
        </div>
        <div>
            <label class="rn-label">Csillag</label>
            <select name="stars" class="rn-input" style="width:120px">
                <option value="">Mind</option>
                @for($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ request('stars') == $i ? 'selected' : '' }}>{{ $i }}★</option>
                @endfor
            </select>
        </div>
        @if($platforms->count() > 1)
        <div>
            <label class="rn-label">Platform</label>
            <select name="platform" class="rn-input" style="width:140px">
                <option value="">Mind</option>
                @foreach($platforms as $p)
                    <option value="{{ $p }}" {{ request('platform') == $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <button type="submit" class="btn rn-btn rn-btn-primary btn-sm">Szűrés</button>
        @if(request()->hasAny(['search', 'stars', 'platform']))
            <a href="{{ route('admin.reviews.index') }}" class="btn rn-btn rn-btn-ghost btn-sm">Törlés</a>
        @endif
        <div class="ms-auto">
            <form method="POST" action="{{ route('admin.reviews.sync') }}" class="m-0">
                @csrf
                <button type="submit" class="btn rn-btn rn-btn-primary btn-sm">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:.25rem"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                    Szinkronizálás
                </button>
            </form>
        </div>
    </form>
</div>

{{-- Értékelések lista --}}
<div class="rn-admin-card p-0">
    @if($reviews->isEmpty())
        <div class="rn-empty-state">
            <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            <p>Még nincs értékelés szinkronizálva.<br>
            Csatlakoztasd a Google fiókodat, majd kattints a <strong>Szinkronizálás</strong> gombra.</p>
            <a href="{{ route('admin.settings.platforms') }}" class="btn rn-btn rn-btn-primary btn-sm mt-2">Platformok beállítása</a>
        </div>
    @else
        <div class="rn-table-wrap">
            <table class="rn-table">
                <thead>
                    <tr>
                        <th style="width:40px"></th>
                        <th>Értékelő</th>
                        <th>Értékelés</th>
                        <th>Platform</th>
                        <th>Dátum</th>
                        <th>Válasz</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                    <tr>
                        <td>
                            <div class="rn-user-initials rn-user-avatar--sm">
                                {{ strtoupper(substr($review->reviewer_name ?? '?', 0, 1)) }}
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:500;font-size:.875rem">{{ $review->reviewer_name ?? 'Névtelen' }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-start gap-2">
                                <div style="white-space:nowrap;color:#FBBF24;letter-spacing:.05em">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= $review->stars ? '★' : '☆' }}
                                    @endfor
                                </div>
                                @if($review->content)
                                <div style="font-size:.78rem;color:var(--rn-muted);max-width:320px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical">
                                    {{ $review->content }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td>
                            @php
                                $colors = ['google'=>'#4285F4','facebook'=>'#1877F2','tripadvisor'=>'#34E0A1','trustpilot'=>'#00B67A'];
                                $color = $colors[$review->platform] ?? 'var(--rn-muted)';
                            @endphp
                            <span style="font-size:.75rem;font-weight:600;color:{{ $color }}">
                                {{ ucfirst($review->platform) }}
                            </span>
                        </td>
                        <td>
                            <span style="font-size:.78rem;color:var(--rn-muted)">
                                {{ $review->reviewed_at?->format('Y.m.d') ?? '–' }}
                            </span>
                        </td>
                        <td>
                            @if($review->replied)
                                <span class="rn-status-badge rn-status-badge--active" style="font-size:.65rem">Megválaszolva</span>
                            @else
                                <span class="rn-status-badge rn-status-badge--trial" style="font-size:.65rem">Válasz nélkül</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($reviews->hasPages())
        <div class="p-3 border-top d-flex justify-content-between align-items-center" style="border-color:rgba(255,255,255,.06)!important">
            <small class="rn-muted-text">{{ $reviews->firstItem() }}–{{ $reviews->lastItem() }} / {{ $reviews->total() }} értékelés</small>
            <div class="rn-pagination">
                {{ $reviews->links('pagination::simple-bootstrap-5') }}
            </div>
        </div>
        @endif
    @endif
</div>

@endsection

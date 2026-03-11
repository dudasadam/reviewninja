@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- KPI kártyák --}}
<div class="row g-4 mb-4">
    @foreach ($stats as $stat)
    <div class="col-sm-6 col-xl-3">
        <div class="rn-admin-card rn-kpi-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="rn-kpi-label">{{ $stat['label'] }}</p>
                    <div class="rn-kpi-value">{{ $stat['value'] }}</div>
                </div>
                <div class="rn-kpi-icon rn-kpi-icon--{{ $stat['icon'] }}">
                    @if ($stat['icon'] === 'star')
                        <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @elseif ($stat['icon'] === 'users')
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    @elseif ($stat['icon'] === 'send')
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                    @else
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    @endif
                </div>
            </div>
            <div class="rn-kpi-change rn-kpi-change--{{ $stat['trend'] }}">
                @if ($stat['trend'] === 'up') ↑ @else ↓ @endif
                {{ $stat['change'] }} az előző hónaphoz képest
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4">

    {{-- Értékelések – fake mini chart + lista --}}
    <div class="col-xl-8">
        <div class="rn-admin-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="rn-card-title mb-0">Értékelések trendje</h2>
                <div class="d-flex gap-2">
                    <button class="rn-chip-btn active" data-range="30">30 nap</button>
                    <button class="rn-chip-btn" data-range="90">90 nap</button>
                    <button class="rn-chip-btn" data-range="365">1 év</button>
                </div>
            </div>
            <div class="rn-chart-area" id="reviewChart">
                {{-- Placeholder bars --}}
                <div class="rn-fake-chart">
                    @php $bars = [28,40,35,52,47,60,55,72,68,80,75,90,85,100,88,95,70,82,91,98,75,60,85,92,100,88,72,95,87,100]; @endphp
                    @foreach ($bars as $h)
                    <div class="rn-chart-bar" style="height: {{ $h }}%" data-value="{{ $h }}"></div>
                    @endforeach
                </div>
                <div class="rn-chart-labels">
                    <span>Febr. 10</span><span>Febr. 20</span><span>Márc. 1</span><span>Márc. 11</span>
                </div>
            </div>
            <div class="d-flex gap-4 mt-3">
                <div class="rn-legend-item"><span class="rn-legend-dot rn-legend-dot--google"></span> Google</div>
                <div class="rn-legend-item"><span class="rn-legend-dot rn-legend-dot--facebook"></span> Facebook</div>
                <div class="rn-legend-item"><span class="rn-legend-dot rn-legend-dot--other"></span> Egyéb</div>
            </div>
        </div>
    </div>

    {{-- Platform bontás --}}
    <div class="col-xl-4">
        <div class="rn-admin-card h-100">
            <h2 class="rn-card-title mb-4">Platform bontás</h2>
            <div class="d-grid gap-3">
                @php
                $platforms = [
                    ['name' => 'Google', 'count' => 892, 'pct' => 69, 'color' => '#4285F4'],
                    ['name' => 'Facebook', 'count' => 243, 'pct' => 19, 'color' => '#1877F2'],
                    ['name' => 'Tripadvisor', 'count' => 97, 'pct' => 8, 'color' => '#34E0A1'],
                    ['name' => 'Egyéb', 'count' => 52, 'pct' => 4, 'color' => '#9db0d0'],
                ];
                @endphp
                @foreach ($platforms as $p)
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="rn-platform-name">{{ $p['name'] }}</span>
                        <span class="rn-platform-count">{{ $p['count'] }} ({{ $p['pct'] }}%)</span>
                    </div>
                    <div class="rn-progress">
                        <div class="rn-progress-bar" style="width: {{ $p['pct'] }}%; background: {{ $p['color'] }}"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Legutóbbi aktivitás --}}
    <div class="col-xl-6">
        <div class="rn-admin-card">
            <h2 class="rn-card-title mb-4">Legutóbbi aktivitás</h2>
            <div class="rn-activity-list">
                @foreach ($recentActivity as $item)
                <div class="rn-activity-item">
                    <div class="rn-activity-dot rn-activity-dot--{{ $item['type'] }}">
                        @if ($item['type'] === 'review')
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        @elseif ($item['type'] === 'sent')
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m22 2-7 20-4-9-9-4Z"/></svg>
                        @else
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/></svg>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="rn-activity-text">
                            <strong>{{ $item['client'] }}</strong>
                            @if ($item['type'] === 'review') – {{ $item['stars'] }}★ értékelés ({{ $item['platform'] }})
                            @elseif ($item['type'] === 'sent') – kérés elküldve ({{ $item['platform'] }})
                            @else – emlékeztető ({{ $item['platform'] }})
                            @endif
                        </div>
                    </div>
                    <small class="rn-activity-time">{{ $item['time'] }}</small>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Gyors műveletek --}}
    <div class="col-xl-6">
        <div class="rn-admin-card">
            <h2 class="rn-card-title mb-4">Gyors műveletek</h2>
            <div class="d-grid gap-3">
                <a href="{{ route('admin.settings.platforms') }}" class="rn-quick-action">
                    <div class="rn-qa-icon" style="--qa-color: #4285F4">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    </div>
                    <div>
                        <div class="rn-qa-title">Platform összekötése</div>
                        <small class="rn-qa-desc">Google, Facebook, Tripadvisor és más platformok</small>
                    </div>
                    <svg class="ms-auto" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                </a>
                <a href="{{ route('admin.settings.templates') }}" class="rn-quick-action">
                    <div class="rn-qa-icon" style="--qa-color: #35d0ff">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <div>
                        <div class="rn-qa-title">Sablon szerkesztése</div>
                        <small class="rn-qa-desc">SMS és email üzenetsablonok testreszabása</small>
                    </div>
                    <svg class="ms-auto" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                </a>
                <a href="{{ route('admin.settings.integrations') }}" class="rn-quick-action">
                    <div class="rn-qa-icon" style="--qa-color: #6C5CE7">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="8" height="10" rx="1"/><rect x="14" y="7" width="8" height="10" rx="1"/><path d="M10 12h4"/></svg>
                    </div>
                    <div>
                        <div class="rn-qa-title">Integráció beállítása</div>
                        <small class="rn-qa-desc">Billingo, MiniCRM, Zapier és más rendszerek</small>
                    </div>
                    <svg class="ms-auto" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                </a>
                <a href="{{ route('admin.settings.automation') }}" class="rn-quick-action">
                    <div class="rn-qa-icon" style="--qa-color: #00B67A">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div>
                        <div class="rn-qa-title">Automatizálási szabályok</div>
                        <small class="rn-qa-desc">Időzítők, feltételek, emlékeztetők konfigurálása</small>
                    </div>
                    <svg class="ms-auto" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

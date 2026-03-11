@extends('admin.layout')

@section('title', $user->name)
@section('page-title', $user->name)
@section('breadcrumb', 'Felhasználók › ' . $user->name)

@section('content')

@if (session('success'))
    <div class="rn-alert rn-alert--success mb-4">{{ session('success') }}</div>
@endif
@if (session('info'))
    <div class="rn-alert rn-alert--info mb-4">{{ session('info') }}</div>
@endif

{{-- Header --}}
<div class="rn-admin-card mb-4">
    <div class="d-flex align-items-center gap-4 flex-wrap">
        <div class="rn-user-avatar rn-user-avatar--lg">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
        <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <h2 class="mb-0 fw-bold">{{ $user->name }}</h2>
                <span class="rn-role-badge rn-role-badge--{{ $user->role }}">{{ $user->role }}</span>
                <span class="rn-status-badge rn-status-badge--{{ $user->status }}">{{ $user->status }}</span>
            </div>
            <div class="mt-1 d-flex gap-3 flex-wrap">
                <small class="rn-muted-text">{{ $user->email }}</small>
                @if ($user->company_name) <small class="rn-muted-text">{{ $user->company_name }}</small> @endif
                @if ($user->phone)        <small class="rn-muted-text">{{ $user->phone }}</small>        @endif
            </div>
            <small class="rn-muted-text">Regisztráció: {{ $user->created_at->format('Y. m. d.') }}
                @if ($user->trial_ends_at) • Trial lejárat: {{ $user->trial_ends_at->format('Y. m. d.') }} @endif
            </small>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn rn-btn rn-btn-ghost">Szerkesztés</a>
            <form method="POST" action="{{ route('admin.users.impersonate', $user) }}">
                @csrf
                <button class="btn rn-btn rn-btn-primary">Belépés mint ő</button>
            </form>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    @php $kpis = [
        ['label' => 'Ügyfelek',        'value' => $stats['customers']],
        ['label' => 'Kiküldött kérések','value' => $stats['review_requests']],
        ['label' => 'Bejövő értékelések','value' => $stats['reviews']],
        ['label' => 'Átlag csillag',   'value' => $stats['avg_stars'] . ' ★'],
    ]; @endphp
    @foreach ($kpis as $k)
    <div class="col-6 col-xl-3">
        <div class="rn-admin-card text-center">
            <div class="rn-kpi-value">{{ $k['value'] }}</div>
            <p class="rn-kpi-label mb-0 mt-1">{{ $k['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4">

    {{-- Platformok --}}
    <div class="col-md-6">
        <div class="rn-admin-card h-100">
            <h2 class="rn-card-title mb-3">Csatlakoztatott platformok</h2>
            @forelse ($user->platforms as $p)
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="rn-badge-connected">● </span>
                    <span class="fw-semibold text-capitalize">{{ $p->platform }}</span>
                    <small class="rn-muted-text ms-auto">{{ $p->locations_count }} helyszín</small>
                </div>
            @empty
                <p class="rn-muted-text">Nincs csatlakoztatott platform.</p>
            @endforelse
        </div>
    </div>

    {{-- Integrációk --}}
    <div class="col-md-6">
        <div class="rn-admin-card h-100">
            <h2 class="rn-card-title mb-3">Integrációk</h2>
            @forelse ($user->integrations as $i)
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="rn-badge-connected">● </span>
                    <span class="fw-semibold text-capitalize">{{ $i->integration_key }}</span>
                    <small class="rn-muted-text ms-auto">{{ $i->trigger_event }}</small>
                </div>
            @empty
                <p class="rn-muted-text">Nincs aktív integráció.</p>
            @endforelse
        </div>
    </div>

    {{-- Sablonok --}}
    <div class="col-md-6">
        <div class="rn-admin-card h-100">
            <h2 class="rn-card-title mb-3">Üzenetsablonok</h2>
            @forelse ($user->templates as $t)
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="rn-template-channel rn-template-channel--{{ $t->channel }}">{{ strtoupper($t->channel) }}</span>
                    <span>{{ $t->name }}</span>
                    <small class="rn-muted-text ms-auto">{{ $t->is_active ? 'aktív' : 'inaktív' }}</small>
                </div>
            @empty
                <p class="rn-muted-text">Nincs sablon.</p>
            @endforelse
        </div>
    </div>

    {{-- Automatizálás összefoglaló --}}
    <div class="col-md-6">
        <div class="rn-admin-card h-100">
            <h2 class="rn-card-title mb-3">Automatizálás</h2>
            @if ($user->automationRule)
                @php $ar = $user->automationRule; @endphp
                <div class="d-grid gap-2">
                    <div class="d-flex justify-content-between">
                        <small class="rn-muted-text">Első kérés:</small>
                        <small>{{ $ar->first_request_delay_value }} {{ $ar->first_request_delay_unit }} után</small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <small class="rn-muted-text">Csatornák:</small>
                        <small>{{ implode(', ', $ar->channels ?? []) }}</small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <small class="rn-muted-text">Max emlékeztető:</small>
                        <small>{{ $ar->max_reminders }}</small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <small class="rn-muted-text">AI válasz:</small>
                        <small>{{ $ar->ai_replies_enabled ? 'Bekapcsolva' : 'Kikapcsolva' }}</small>
                    </div>
                </div>
            @else
                <p class="rn-muted-text">Nincs automatizálási szabály.</p>
            @endif
        </div>
    </div>

</div>

{{-- Danger zone --}}
<div class="rn-admin-card mt-4" style="border-color: rgba(248,113,113,.25)">
    <h2 class="rn-card-title mb-3" style="color:#F87171">Veszélyes műveletek</h2>
    <div class="d-flex gap-3 flex-wrap">
        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
              onsubmit="return confirm('Biztosan törlöd {{ $user->name }} felhasználót? Ez visszafordíthatatlan!')">
            @csrf @method('DELETE')
            <button class="btn rn-btn-danger">Felhasználó végleges törlése</button>
        </form>
    </div>
</div>

@endsection

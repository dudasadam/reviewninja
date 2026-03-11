@extends('admin.layout')

@section('title', 'Integrációk')
@section('page-title', 'Integrációk')
@section('breadcrumb', 'Beállítások › Integrációk')

@section('content')

<p class="rn-page-desc mb-4">Kösd össze a számlázó, CRM és egyéb rendszereket. Az integráció után automatikusan elindulnak az értékeléskérések minden befejezett tranzakció után.</p>

<div class="row g-4">
    @foreach ($integrations as $i)
    <div class="col-md-6 col-xl-4">
        <div class="rn-admin-card rn-integration-card {{ $i['connected'] ? 'rn-integration-card--connected' : '' }}">
            <div class="d-flex align-items-start gap-3 mb-3">
                <div class="rn-integration-logo" style="background: {{ $i['color'] }}22; color: {{ $i['color'] }}">
                    {{ strtoupper(substr($i['name'], 0, 2)) }}
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold">{{ $i['name'] }}</div>
                    <small class="rn-muted-text">{{ $i['desc'] }}</small>
                </div>
                @if ($i['connected'])
                    <span class="rn-badge-connected">● Aktív</span>
                @endif
            </div>
            @if ($i['connected'])
                <div class="d-flex gap-2">
                    <button class="btn rn-btn rn-btn-ghost btn-sm flex-grow-1">Konfiguráció</button>
                    <button class="btn rn-btn-danger btn-sm">Leválasztás</button>
                </div>
            @else
                <button class="btn rn-btn rn-btn-primary btn-sm w-100 rn-connect-integration-btn" data-key="{{ $i['key'] }}" data-name="{{ $i['name'] }}">
                    + Integrálás
                </button>
            @endif
        </div>
    </div>
    @endforeach
</div>

{{-- Webhook API szekció --}}
<div class="rn-admin-card mt-4">
    <h2 class="rn-card-title mb-3">Webhook API</h2>
    <p class="rn-muted-text mb-4">Ha a rendszered nem szerepel a listán, POST kéréssel is indíthatod az értékeléskérési folyamatot.</p>
    <div class="row g-3 align-items-end">
        <div class="col-md-8">
            <label class="rn-label">Webhook URL (bejövő)</label>
            <div class="rn-input-copy-group">
                <input type="text" class="rn-input" id="webhookUrl" value="https://app.reviewninja.hu/webhook/abc123xyz" readonly>
                <button class="rn-copy-btn" onclick="copyWebhook()">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    Másolás
                </button>
            </div>
        </div>
        <div class="col-md-4">
            <button class="btn rn-btn rn-btn-ghost w-100">API dokumentáció →</button>
        </div>
    </div>
    <div class="rn-form-group mt-3">
        <label class="rn-label">Szükséges mezők (JSON példa)</label>
        <pre class="rn-code-block">{
  "customer_name": "Kovács Péter",
  "customer_phone": "+36301234567",
  "customer_email": "peter@example.com",
  "service": "Fogszabályozás",
  "completed_at": "2026-03-11T14:00:00Z"
}</pre>
    </div>
</div>

{{-- Integráció modal --}}
<div class="rn-modal-overlay" id="integrationModal" style="display:none">
    <div class="rn-modal">
        <div class="rn-modal-header">
            <h3 class="rn-modal-title" id="integrationModalTitle">Integráció beállítása</h3>
            <button class="rn-modal-close" id="integrationModalClose">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="rn-modal-body">
            <div class="rn-form-group">
                <label class="rn-label">API kulcs</label>
                <input type="password" class="rn-input" placeholder="Illeszd be az API kulcsodat">
            </div>
            <div class="rn-form-group">
                <label class="rn-label">Trigger esemény</label>
                <select class="rn-input">
                    <option>Számla kiállításakor</option>
                    <option>Ügyfél lezárva (CRM)</option>
                    <option>Manuális indítás</option>
                </select>
            </div>
            <div class="rn-form-group">
                <label class="rn-label">Várakozás az értékeléskérés előtt</label>
                <div class="d-flex gap-2 align-items-center">
                    <input type="number" class="rn-input" value="2" style="width:80px">
                    <select class="rn-input">
                        <option>óra</option>
                        <option>nap</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="rn-modal-footer">
            <button class="btn rn-btn rn-btn-ghost" id="integrationModalCancel">Mégse</button>
            <button class="btn rn-btn rn-btn-primary">Mentés</button>
        </div>
    </div>
</div>

@endsection

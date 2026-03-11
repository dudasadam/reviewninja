@extends('admin.layout')

@section('title', 'Sablonok')
@section('page-title', 'Üzenetsablonok')
@section('breadcrumb', 'Beállítások › Sablonok')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="rn-page-desc mb-0">Testreszabhatod az SMS és email üzenetsablonokat, amelyeket a rendszer automatikusan küld ki az ügyfeleknek.</p>
    <button class="btn rn-btn rn-btn-primary" id="newTemplateBtn">+ Új sablon</button>
</div>

<div class="row g-4">
    @foreach ($templates as $t)
    <div class="col-12">
        <div class="rn-admin-card rn-template-card">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="rn-template-channel rn-template-channel--{{ $t['channel'] }}">
                    @if ($t['channel'] === 'sms')
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        SMS
                    @else
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Email
                    @endif
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold">{{ $t['name'] }}</div>
                    <small class="rn-muted-text">Magyar • {{ $t['active'] ? 'Aktív' : 'Inaktív' }}</small>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="rn-toggle {{ $t['active'] ? 'rn-toggle--on' : '' }}" data-id="{{ $t['id'] }}">
                        <div class="rn-toggle-thumb"></div>
                    </div>
                    <button class="btn rn-btn rn-btn-ghost btn-sm rn-edit-template-btn" data-id="{{ $t['id'] }}" data-name="{{ $t['name'] }}">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Szerkesztés
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Sablon szerkesztő panel --}}
<div class="rn-modal-overlay" id="templateModal" style="display:none">
    <div class="rn-modal rn-modal--lg">
        <div class="rn-modal-header">
            <h3 class="rn-modal-title" id="templateModalTitle">Sablon szerkesztése</h3>
            <button class="rn-modal-close" id="templateModalClose">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="rn-modal-body">
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="rn-form-group">
                        <label class="rn-label">Sablon neve</label>
                        <input type="text" class="rn-input" id="tplName" value="Alapértelmezett SMS kérés">
                    </div>
                    <div class="rn-form-group">
                        <label class="rn-label">Tárgy (email esetén)</label>
                        <input type="text" class="rn-input" id="tplSubject" placeholder="pl. Kérünk egy percet – értékelj minket!">
                    </div>
                    <div class="rn-form-group">
                        <label class="rn-label">Üzenet tartalma</label>
                        <textarea class="rn-input rn-textarea" id="tplBody" rows="6">Szia {{name}}! Köszönjük, hogy igénybe vetted a szolgáltatásunkat. Kérnénk, hogy ha elégedett voltál, írj nekünk egy rövid értékelést: {{review_link}} – Köszönjük! 🙏</textarea>
                    </div>
                    <div class="rn-template-vars">
                        <p class="rn-label mb-2">Elérhető változók:</p>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="rn-var-chip" onclick="insertVar('{{name}}')">{{name}}</button>
                            <button class="rn-var-chip" onclick="insertVar('{{review_link}}')">{{review_link}}</button>
                            <button class="rn-var-chip" onclick="insertVar('{{company_name}}')">{{company_name}}</button>
                            <button class="rn-var-chip" onclick="insertVar('{{service}}')">{{service}}</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <p class="rn-label mb-2">Előnézet (SMS)</p>
                    <div class="rn-sms-preview">
                        <div class="rn-sms-bubble" id="smsPreview">Szia Kovács Péter! Köszönjük, hogy igénybe vetted a szolgáltatásunkat. Kérnénk, hogy ha elégedett voltál, írj nekünk egy rövid értékelést: https://g.page/r/... – Köszönjük! 🙏</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rn-modal-footer">
            <button class="btn rn-btn rn-btn-ghost" id="templateModalCancel">Mégse</button>
            <button class="btn rn-btn rn-btn-primary">Mentés</button>
        </div>
    </div>
</div>

@endsection

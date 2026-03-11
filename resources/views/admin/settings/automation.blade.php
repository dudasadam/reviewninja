@extends('admin.layout')

@section('title', 'Automatizálás')
@section('page-title', 'Automatizálási szabályok')
@section('breadcrumb', 'Beállítások › Automatizálás')

@section('content')

<p class="rn-page-desc mb-4">Állítsd be, hogy mikor, milyen csatornán és hányszor kérjen értékelést a rendszer. Az emlékeztetők és feltételek is itt konfigurálhatók.</p>

<div class="row g-4">

    {{-- Értékeléskérés időzítése --}}
    <div class="col-xl-6">
        <div class="rn-admin-card">
            <h2 class="rn-card-title mb-4">Értékeléskérés időzítése</h2>
            <div class="rn-form-group">
                <label class="rn-label">Első kérés küldése</label>
                <div class="d-flex gap-2 align-items-center">
                    <input type="number" class="rn-input" value="2" style="width:90px">
                    <select class="rn-input">
                        <option>órával a trigger után</option>
                        <option>nappal a trigger után</option>
                    </select>
                </div>
                <small class="rn-muted-text">A trigger a CRM/számlázó integrációból érkezik.</small>
            </div>
            <div class="rn-form-group">
                <label class="rn-label">Küldési csatorna (prioritási sorrendben)</label>
                <div class="d-grid gap-2 mt-1">
                    <label class="rn-check-label"><input type="checkbox" checked> SMS</label>
                    <label class="rn-check-label"><input type="checkbox" checked> Email</label>
                    <label class="rn-check-label"><input type="checkbox"> Push értesítés (hamarosan)</label>
                </div>
            </div>
            <div class="rn-form-group">
                <label class="rn-label">Küldés időablaka</label>
                <div class="d-flex gap-2">
                    <input type="time" class="rn-input" value="09:00">
                    <span class="rn-muted-text align-self-center">–</span>
                    <input type="time" class="rn-input" value="20:00">
                </div>
                <small class="rn-muted-text">Ezen kívül eső esetén a következő napon, az ablak elején küldjük.</small>
            </div>
        </div>
    </div>

    {{-- Emlékeztetők --}}
    <div class="col-xl-6">
        <div class="rn-admin-card">
            <h2 class="rn-card-title mb-4">Emlékeztetők</h2>
            <div id="reminderList">
                <div class="rn-reminder-row">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="rn-muted-text">Ha nem reagál:</span>
                        <input type="number" class="rn-input" value="3" style="width:70px">
                        <select class="rn-input" style="width:auto">
                            <option>nappal később</option>
                            <option>héttel később</option>
                        </select>
                        <select class="rn-input" style="width:auto">
                            <option>SMS</option>
                            <option>Email</option>
                        </select>
                        <button class="btn rn-btn-icon rn-btn-danger-icon" onclick="this.closest('.rn-reminder-row').remove()">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </div>
                <div class="rn-reminder-row">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <span class="rn-muted-text">Ha nem reagál:</span>
                        <input type="number" class="rn-input" value="7" style="width:70px">
                        <select class="rn-input" style="width:auto">
                            <option>nappal később</option>
                            <option>héttel később</option>
                        </select>
                        <select class="rn-input" style="width:auto">
                            <option>Email</option>
                            <option>SMS</option>
                        </select>
                        <button class="btn rn-btn-icon rn-btn-danger-icon" onclick="this.closest('.rn-reminder-row').remove()">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            <button class="btn rn-btn rn-btn-ghost btn-sm mt-3" id="addReminder">+ Emlékeztető hozzáadása</button>
            <div class="rn-form-group mt-3">
                <label class="rn-label">Max emlékeztetők száma ügyfelenként</label>
                <input type="number" class="rn-input" value="2" style="max-width:100px">
            </div>
        </div>
    </div>

    {{-- AI válaszok --}}
    <div class="col-xl-6">
        <div class="rn-admin-card">
            <h2 class="rn-card-title mb-4">AI válaszüzenetek</h2>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span>Automatikus AI válasz bekapcsolva</span>
                <div class="rn-toggle rn-toggle--on" id="aiToggle"><div class="rn-toggle-thumb"></div></div>
            </div>
            <div class="rn-form-group">
                <label class="rn-label">Cégre szabott hangnem / instrukció (AI prompt)</label>
                <textarea class="rn-input rn-textarea" rows="4">Barátságos, professzionális hangnemben válaszolj. Mindig köszönd meg az értékelést. 5 csillagos értékelés esetén ajánlj fel referencia-kedvezményt is.</textarea>
            </div>
            <div class="rn-form-group">
                <label class="rn-label">Válaszolj automatikusan, ha a csillag</label>
                <select class="rn-input">
                    <option>4 vagy 5 csillag</option>
                    <option>5 csillag</option>
                    <option>Minden értékelés</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Szűrők / feltételek --}}
    <div class="col-xl-6">
        <div class="rn-admin-card">
            <h2 class="rn-card-title mb-4">Szűrők és feltételek</h2>
            <div class="rn-form-group">
                <label class="rn-label">Kérés küldése CSAK akkor, ha</label>
                <div class="d-grid gap-2 mt-1">
                    <label class="rn-check-label"><input type="checkbox" checked> Az ügyfél legalább egyszer visszajárt</label>
                    <label class="rn-check-label"><input type="checkbox"> A számla összege meghaladja az 5 000 Ft-ot</label>
                    <label class="rn-check-label"><input type="checkbox" checked> Az ügyfél még nem kapott kérést az elmúlt 90 napban</label>
                </div>
            </div>
            <div class="rn-form-group">
                <label class="rn-label">Kizárási lista (e-mail domain / telefonszám)</label>
                <textarea class="rn-input rn-textarea" rows="3" placeholder="pl. @versenytars.hu, +36201234567"></textarea>
                <small class="rn-muted-text">Soronként egy bejegyzés.</small>
            </div>
        </div>
    </div>

</div>

<div class="d-flex justify-content-end mt-4">
    <button class="btn rn-btn rn-btn-primary px-5">Beállítások mentése</button>
</div>

@endsection

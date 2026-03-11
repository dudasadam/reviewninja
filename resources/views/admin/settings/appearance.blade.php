@extends('admin.layout')

@section('title', 'Megjelenés')
@section('page-title', 'Megjelenés & Branding')
@section('breadcrumb', 'Beállítások › Megjelenés')

@section('content')

<p class="rn-page-desc mb-4">Szabd testre a review kérő oldalakat és az ügyfeleknek küldött kommunikáció megjelenését.</p>

<div class="row g-4">

    {{-- Céges arculat --}}
    <div class="col-xl-6">
        <div class="rn-admin-card">
            <h2 class="rn-card-title mb-4">Céges arculat</h2>
            <div class="rn-form-group">
                <label class="rn-label">Cég neve</label>
                <input type="text" class="rn-input" value="ReviewNinja Demo">
            </div>
            <div class="rn-form-group">
                <label class="rn-label">Logó feltöltése</label>
                <div class="rn-upload-zone" id="logoUpload">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <p class="mt-2 mb-0">Húzd ide a logót, vagy <span class="rn-link">kattints a tallózáshoz</span></p>
                    <small class="rn-muted-text">PNG, JPG, SVG – max. 2 MB</small>
                </div>
            </div>
            <div class="rn-form-group">
                <label class="rn-label">Elsődleges szín</label>
                <div class="d-flex gap-2 align-items-center">
                    <input type="color" class="rn-color-input" value="#35d0ff">
                    <input type="text" class="rn-input" value="#35d0ff" style="max-width:120px">
                    <span class="rn-muted-text">– Gomb, kiemelések</span>
                </div>
            </div>
            <div class="rn-form-group">
                <label class="rn-label">Másodlagos szín</label>
                <div class="d-flex gap-2 align-items-center">
                    <input type="color" class="rn-color-input" value="#5a78ff">
                    <input type="text" class="rn-input" value="#5a78ff" style="max-width:120px">
                </div>
            </div>
        </div>
    </div>

    {{-- Review landing oldal --}}
    <div class="col-xl-6">
        <div class="rn-admin-card">
            <h2 class="rn-card-title mb-4">Review landing oldal előnézete</h2>
            <div class="rn-landing-preview">
                <div class="rn-preview-device">
                    <div class="rn-preview-screen">
                        <div class="rn-preview-header">
                            <div class="rn-preview-logo">RN</div>
                            <div class="rn-preview-company">ReviewNinja Demo</div>
                        </div>
                        <div class="rn-preview-body">
                            <p class="rn-preview-msg">Szia Kovács Péter! 👋<br>Elégedett voltál a szolgáltatásunkkal?</p>
                            <div class="rn-preview-stars">⭐⭐⭐⭐⭐</div>
                            <button class="rn-preview-btn">Értékelés írása</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Feladó beállítások --}}
    <div class="col-xl-6">
        <div class="rn-admin-card">
            <h2 class="rn-card-title mb-4">Email feladó beállítások</h2>
            <div class="rn-form-group">
                <label class="rn-label">Feladó neve</label>
                <input type="text" class="rn-input" value="ReviewNinja Demo csapata">
            </div>
            <div class="rn-form-group">
                <label class="rn-label">Feladó email cím</label>
                <input type="email" class="rn-input" value="noreply@reviewninja.hu">
            </div>
            <div class="rn-form-group">
                <label class="rn-label">SMS feladó név (max. 11 karakter)</label>
                <input type="text" class="rn-input" value="ReviewNinja" maxlength="11">
            </div>
        </div>
    </div>

    {{-- GDPR / Leiratkozás --}}
    <div class="col-xl-6">
        <div class="rn-admin-card">
            <h2 class="rn-card-title mb-4">GDPR & Leiratkozás</h2>
            <div class="rn-form-group">
                <label class="rn-label">Adatvédelmi nyilatkozat URL</label>
                <input type="url" class="rn-input" placeholder="https://cegem.hu/adatvedelem">
            </div>
            <div class="rn-form-group">
                <label class="rn-label">Leiratkozási szöveg (SMS)</label>
                <input type="text" class="rn-input" value="Leiratkozás: STOP küldése erre a számra">
            </div>
            <div class="d-grid gap-2 mt-2">
                <label class="rn-check-label"><input type="checkbox" checked> GDPR szöveg megjelenítése az emailekben</label>
                <label class="rn-check-label"><input type="checkbox" checked> Leiratkozási link az email láblécébe</label>
            </div>
        </div>
    </div>

</div>

<div class="d-flex justify-content-end mt-4">
    <button class="btn rn-btn rn-btn-primary px-5">Változtatások mentése</button>
</div>

@endsection

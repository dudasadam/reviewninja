<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') – ReviewNinja Admin</title>
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js', 'resources/js/admin/admin.js'])
</head>
<body class="rn-admin-body">

{{-- ===== SIDEBAR ===== --}}
<aside class="rn-sidebar" id="rnSidebar">
    <div class="rn-sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="rn-sidebar-brand">
            <span class="rn-logo">R</span>
            <div>
                <div class="rn-brand">ReviewNinja</div>
                <small class="rn-brand-sub">admin panel</small>
            </div>
        </a>
        <button class="rn-sidebar-toggle d-lg-none" id="sidebarClose">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>
    </div>

    <nav class="rn-sidebar-nav">
        <div class="rn-nav-group">
            <span class="rn-nav-group-label">Áttekintés</span>
            <a href="{{ route('admin.dashboard') }}" class="rn-sidebar-link @if(request()->routeIs('admin.dashboard')) active @endif">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                Dashboard
            </a>
            <a href="#" class="rn-sidebar-link">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20V10m0 0-3 3m3-3 3 3M4 4h16"/></svg>
                Értékelések
                <span class="rn-badge ms-auto">24</span>
            </a>
            <a href="#" class="rn-sidebar-link">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 20h20M6 20V10l6-6 6 6v10"/></svg>
                Ügyfelek
            </a>
            <a href="#" class="rn-sidebar-link">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                Analitika
            </a>
        </div>

        <div class="rn-nav-group">
            <span class="rn-nav-group-label">Felhasználók</span>
            <a href="{{ route('admin.users.index') }}" class="rn-sidebar-link @if(request()->routeIs('admin.users.*')) active @endif">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Felhasználók
            </a>
        </div>

        <div class="rn-nav-group">
            <span class="rn-nav-group-label">Kampányok</span>
            <a href="#" class="rn-sidebar-link">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                Kiküldések
            </a>
            <a href="#" class="rn-sidebar-link">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>
                Automatizálás
            </a>
        </div>

        <div class="rn-nav-group">
            <span class="rn-nav-group-label">Beállítások</span>
            <a href="{{ route('admin.settings.platforms') }}" class="rn-sidebar-link @if(request()->routeIs('admin.settings.platforms')) active @endif">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                Platformok
            </a>
            <a href="{{ route('admin.settings.templates') }}" class="rn-sidebar-link @if(request()->routeIs('admin.settings.templates')) active @endif">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                Sablonok
            </a>
            <a href="{{ route('admin.settings.integrations') }}" class="rn-sidebar-link @if(request()->routeIs('admin.settings.integrations')) active @endif">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="8" height="10" rx="1"/><rect x="14" y="7" width="8" height="10" rx="1"/><path d="M10 12h4"/></svg>
                Integrációk
            </a>
            <a href="{{ route('admin.settings.automation') }}" class="rn-sidebar-link @if(request()->routeIs('admin.settings.automation')) active @endif">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m12 2 3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Automatizálás
            </a>
            <a href="{{ route('admin.settings.appearance') }}" class="rn-sidebar-link @if(request()->routeIs('admin.settings.appearance')) active @endif">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 1 1-14.14 0"/></svg>
                Megjelenés
            </a>
        </div>
    </nav>

    <div class="rn-sidebar-footer">
        <div class="rn-sidebar-user">
            <div class="rn-user-initials rn-user-avatar--sm me-2" style="width:32px;height:32px;font-size:.75rem;">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
            </div>
            <div>
                <div class="rn-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="rn-user-email">{{ auth()->user()->email ?? '' }}</div>
            </div>
        </div>
    </div>
</aside>

{{-- ===== OVERLAY (mobile) ===== --}}
<div class="rn-sidebar-overlay" id="sidebarOverlay"></div>

{{-- ===== MAIN CONTENT ===== --}}
<div class="rn-admin-main">

    {{-- Impersonation banner --}}
    @if(session('impersonating_admin'))
    <div class="rn-impersonate-bar">
        <span>
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align:middle;margin-right:.35rem"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            Jelenleg <strong>{{ auth()->user()->name }}</strong> felhasználóként vagy belépve (impersonation)
        </span>
        <form method="POST" action="{{ route('admin.users.stop-impersonating') }}">
            @csrf
            <button type="submit">← Vissza az admin fiókhoz</button>
        </form>
    </div>
    @endif

    {{-- TOPBAR --}}
    <header class="rn-topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="rn-topbar-toggle d-lg-none" id="sidebarOpen">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div>
                <h1 class="rn-page-title mb-0">@yield('page-title', 'Dashboard')</h1>
                @hasSection('breadcrumb')
                <small class="rn-page-breadcrumb">@yield('breadcrumb')</small>
                @endif
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <button class="rn-topbar-btn" title="Értesítések">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span class="rn-topbar-badge">3</span>
            </button>
            <a href="{{ route('main.index') }}" class="rn-topbar-btn" title="Főoldal megtekintése" target="_blank">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </a>
            <form method="POST" action="{{ route('auth.logout') }}" class="m-0">
                @csrf
                <button type="submit" class="rn-topbar-btn" title="Kijelentkezés">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </button>
            </form>
        </div>
    </header>

    {{-- PAGE CONTENT --}}
    <div class="rn-admin-content">
        @yield('content')
    </div>

</div>

</body>
</html>

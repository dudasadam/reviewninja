<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bejelentkezés – ReviewNinja</title>
    @vite(['resources/css/app.css', 'resources/css/admin.css'])
    <style>
        body.rn-login-body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: var(--rn-body-bg, #041421);
            position: relative;
            overflow: hidden;
        }
        body.rn-login-body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 20% 20%, rgba(53,208,255,.07) 0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 80% 80%, rgba(90,120,255,.06) 0%, transparent 60%);
            pointer-events: none;
        }
        .rn-login-card {
            width: 100%;
            max-width: 420px;
            background: var(--rn-card, rgba(255,255,255,.04));
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 1.25rem;
            padding: 2.5rem 2rem;
            backdrop-filter: blur(16px);
            position: relative;
            z-index: 1;
        }
        .rn-login-brand {
            display: flex;
            align-items: center;
            gap: .85rem;
            margin-bottom: 2rem;
            justify-content: center;
        }
        .rn-login-logo {
            width: 42px;
            height: 42px;
            border-radius: .6rem;
            background: linear-gradient(135deg, var(--rn-primary,#35d0ff), #5a78ff);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 1.2rem;
            color: #041421;
            flex-shrink: 0;
        }
        .rn-login-brand-text {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--rn-text, #e2f0fa);
            letter-spacing: -.02em;
        }
        .rn-login-brand-sub {
            font-size: .7rem;
            color: var(--rn-muted, #6a8fad);
            display: block;
            margin-top: -.1rem;
        }
        .rn-login-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--rn-text, #e2f0fa);
            margin-bottom: .35rem;
            text-align: center;
        }
        .rn-login-subtitle {
            font-size: .82rem;
            color: var(--rn-muted, #6a8fad);
            text-align: center;
            margin-bottom: 1.75rem;
        }
        .rn-login-form .rn-form-group {
            margin-bottom: 1.1rem;
        }
        .rn-login-form label {
            display: block;
            font-size: .75rem;
            font-weight: 600;
            color: var(--rn-muted, #6a8fad);
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: .4rem;
        }
        .rn-login-form input {
            width: 100%;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: .55rem;
            padding: .7rem 1rem;
            color: var(--rn-text, #e2f0fa);
            font-size: .9rem;
            transition: border-color .15s, background .15s;
            outline: none;
            box-sizing: border-box;
        }
        .rn-login-form input:focus {
            border-color: rgba(53,208,255,.45);
            background: rgba(53,208,255,.05);
        }
        .rn-login-form input.is-invalid {
            border-color: rgba(239,68,68,.5);
            background: rgba(239,68,68,.04);
        }
        .rn-login-form .rn-field-error {
            display: block;
            font-size: .72rem;
            color: #EF4444;
            margin-top: .3rem;
        }
        .rn-login-remember {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .82rem;
            color: var(--rn-muted, #6a8fad);
            margin-bottom: 1.5rem;
            cursor: pointer;
            user-select: none;
        }
        .rn-login-remember input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--rn-primary, #35d0ff);
            cursor: pointer;
        }
        .rn-login-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--rn-primary,#35d0ff), #5a78ff);
            border: none;
            border-radius: .6rem;
            padding: .8rem 1rem;
            font-size: .9rem;
            font-weight: 700;
            color: #041421;
            cursor: pointer;
            transition: opacity .2s, transform .15s;
            letter-spacing: .01em;
        }
        .rn-login-btn:hover {
            opacity: .9;
            transform: translateY(-1px);
        }
        .rn-login-btn:active {
            transform: translateY(0);
        }
        .rn-login-error-box {
            background: rgba(239,68,68,.1);
            border: 1px solid rgba(239,68,68,.3);
            border-radius: .55rem;
            padding: .7rem 1rem;
            font-size: .82rem;
            color: #EF4444;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .rn-login-footer {
            text-align: center;
            margin-top: 1.75rem;
            font-size: .72rem;
            color: var(--rn-muted, #6a8fad);
        }
    </style>
</head>
<body class="rn-login-body">

<div class="rn-login-card">

    <div class="rn-login-brand">
        <div class="rn-login-logo">R</div>
        <div>
            <div class="rn-login-brand-text">ReviewNinja</div>
            <small class="rn-login-brand-sub">admin panel</small>
        </div>
    </div>

    <h1 class="rn-login-title">Üdvözlünk vissza!</h1>
    <p class="rn-login-subtitle">Lépj be a fiókodba a folytatáshoz.</p>

    @if($errors->has('identifier'))
    <div class="rn-login-error-box">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ $errors->first('identifier') }}
    </div>
    @endif

    <form method="POST" action="{{ route('auth.login.post') }}" class="rn-login-form">
        @csrf

        <div class="rn-form-group">
            <label for="identifier">Felhasználónév</label>
            <input
                type="text"
                id="identifier"
                name="identifier"
                value="{{ old('identifier') }}"
                autocomplete="username"
                autofocus
                class="{{ $errors->has('identifier') ? 'is-invalid' : '' }}"
                placeholder="dudasadam"
            >
        </div>

        <div class="rn-form-group">
            <label for="password">Jelszó</label>
            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="••••••••••"
            >
            @error('password')
                <span class="rn-field-error">{{ $message }}</span>
            @enderror
        </div>

        <label class="rn-login-remember">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            Emlékezz rám
        </label>

        <button type="submit" class="rn-login-btn">
            Bejelentkezés →
        </button>
    </form>

    <div class="rn-login-footer">
        &copy; {{ date('Y') }} ReviewNinja &mdash; minden jog fenntartva
    </div>

</div>

</body>
</html>

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ── Helpers ───────────────────────────────────────────────────────────────

    /** Returns the currently "active" user for settings (impersonate-aware). */
    private function activeUser(): User
    {
        return Auth::user() ?? new User();
    }

    // ── Dashboard ─────────────────────────────────────────────────────────────

    public function dashboard(): View
    {
        $user = $this->activeUser();

        $stats = [
            [
                'label'  => 'Összesített értékelés',
                'value'  => $user->reviews()->count() ?: 1284,
                'change' => '+12%', 'icon' => 'star', 'trend' => 'up',
            ],
            [
                'label'  => 'Aktív ügyfelek',
                'value'  => $user->customers()->count() ?: 47,
                'change' => '+3', 'icon' => 'users', 'trend' => 'up',
            ],
            [
                'label'  => 'Kiküldött kérések (30 nap)',
                'value'  => $user->reviewRequests()->count() ?: 632,
                'change' => '+8%', 'icon' => 'send', 'trend' => 'up',
            ],
            [
                'label'  => 'Átlagos válaszarány',
                'value'  => '34%',
                'change' => '+2pp', 'icon' => 'chart', 'trend' => 'up',
            ],
        ];

        $recentActivity = [
            ['type' => 'review',   'platform' => 'Google',   'client' => 'Varga Fogorvos',      'stars' => 5,    'time' => '2 perce'],
            ['type' => 'sent',     'platform' => 'Email',    'client' => 'TomKings Puppies',     'stars' => null, 'time' => '14 perce'],
            ['type' => 'review',   'platform' => 'Facebook', 'client' => 'Nagy Takarítás Kft.',  'stars' => 4,    'time' => '31 perce'],
            ['type' => 'reminder', 'platform' => 'SMS',      'client' => 'Tóth Autószerelő',     'stars' => null, 'time' => '1 órája'],
            ['type' => 'review',   'platform' => 'Google',   'client' => 'Kovács Ügyvédi Iroda', 'stars' => 5,    'time' => '2 órája'],
        ];

        return view('admin.dashboard', compact('stats', 'recentActivity'));
    }

    // ── Settings – Platforms ──────────────────────────────────────────────────

    public function platforms(): View
    {
        $user          = $this->activeUser();
        $connectedKeys = $user->platforms()->pluck('platform')->flip();

        $platforms = collect([
            ['key' => 'google',      'name' => 'Google Business', 'color' => '#4285F4'],
            ['key' => 'facebook',    'name' => 'Facebook',         'color' => '#1877F2'],
            ['key' => 'tripadvisor', 'name' => 'Tripadvisor',      'color' => '#34E0A1'],
            ['key' => 'booking',     'name' => 'Booking.com',      'color' => '#003580'],
            ['key' => 'trustpilot',  'name' => 'Trustpilot',       'color' => '#00B67A'],
            ['key' => 'airbnb',      'name' => 'Airbnb',           'color' => '#FF5A5F'],
        ])->map(function ($p) use ($connectedKeys, $user) {
            $record              = $connectedKeys->has($p['key'])
                ? $user->platforms()->where('platform', $p['key'])->first()
                : null;
            $p['connected']      = (bool) $record;
            $p['locations']      = $record?->locations_count ?? 0;
            $p['google_account'] = $record?->google_account_id;
            return $p;
        });

        return view('admin.settings.platforms', compact('platforms'));
    }

    // ── Settings – Templates ──────────────────────────────────────────────────

    public function templates(): View
    {
        $user      = $this->activeUser();
        $templates = $user->templates()->orderBy('sort_order')->orderBy('id')->get();

        if ($templates->isEmpty()) {
            $templates = collect([
                ['id' => 1, 'name' => 'Alapértelmezett SMS kérés', 'channel' => 'sms',   'language' => 'hu', 'is_active' => true],
                ['id' => 2, 'name' => 'Email kérés – rövid',       'channel' => 'email', 'language' => 'hu', 'is_active' => true],
                ['id' => 3, 'name' => 'Email kérés – hosszú',      'channel' => 'email', 'language' => 'hu', 'is_active' => false],
                ['id' => 4, 'name' => 'SMS emlékeztető',            'channel' => 'sms',   'language' => 'hu', 'is_active' => true],
            ]);
        }

        return view('admin.settings.templates', compact('templates'));
    }

    // ── Settings – Integrations ───────────────────────────────────────────────

    public function integrations(): View
    {
        $user          = $this->activeUser();
        $connectedKeys = $user->integrations()->pluck('integration_key')->flip();

        $integrations = collect([
            ['key' => 'billingo',   'name' => 'Billingo',      'desc' => 'Számlázó rendszer – automatikus triggek számlázáskor',           'color' => '#6C5CE7'],
            ['key' => 'szamlazz',   'name' => 'Számlázz.hu',   'desc' => 'Magyar számlázó integráció',                                     'color' => '#0984E3'],
            ['key' => 'minicrm',    'name' => 'MiniCRM',       'desc' => 'CRM szinkron – ügyféladatok, státuszok',                         'color' => '#E17055'],
            ['key' => 'salesforce', 'name' => 'Salesforce',    'desc' => 'Enterprise CRM integráció',                                      'color' => '#00A1E0'],
            ['key' => 'zapier',     'name' => 'Zapier / Make', 'desc' => 'Egyedi workflow automatizálás Zapier vagy Make.com segítségével', 'color' => '#FF6B35'],
            ['key' => 'webhook',    'name' => 'Webhook API',   'desc' => 'Saját rendszer összekötése REST webhook-on keresztül',           'color' => '#35d0ff'],
        ])->map(function ($i) use ($connectedKeys, $user) {
            $record             = $connectedKeys->has($i['key'])
                ? $user->integrations()->where('integration_key', $i['key'])->first()
                : null;
            $i['connected']     = (bool) $record;
            $i['webhook_token'] = $record?->webhook_token;
            return $i;
        });

        $webhookToken = $user->integrations()
            ->where('integration_key', 'webhook')
            ->value('webhook_token') ?? bin2hex(random_bytes(12));

        return view('admin.settings.integrations', compact('integrations', 'webhookToken'));
    }

    // ── Settings – Automation ─────────────────────────────────────────────────

    public function automation(): View
    {
        $user = $this->activeUser();
        $rule = $user->automationRule;

        return view('admin.settings.automation', compact('rule'));
    }

    // ── Settings – Appearance ─────────────────────────────────────────────────

    public function appearance(): View
    {
        $user     = $this->activeUser();
        $settings = $user->settings;

        return view('admin.settings.appearance', compact('settings'));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPlatform extends Model
{
    protected $fillable = [
        'user_id',
        'platform',
        'profile_url',
        'business_id',
        'api_key',
        'access_token',
        'refresh_token',
        'token_expires_at',
        'google_account_id',
        'locations_count',
        'active',
        'connected_at',
    ];

    protected $hidden = [
        'access_token',
        'refresh_token',
    ];

    protected $casts = [
        'active'           => 'boolean',
        'connected_at'     => 'datetime',
        'token_expires_at' => 'datetime',
    ];

    public function isTokenExpired(): bool
    {
        return $this->token_expires_at && $this->token_expires_at->isPast();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

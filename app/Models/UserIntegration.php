<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserIntegration extends Model
{
    protected $fillable = [
        'user_id',
        'integration_key',
        'api_key',
        'trigger_event',
        'delay_value',
        'delay_unit',
        'webhook_token',
        'active',
        'connected_at',
    ];

    protected $casts = [
        'active'       => 'boolean',
        'connected_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

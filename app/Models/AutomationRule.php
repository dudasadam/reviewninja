<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutomationRule extends Model
{
    protected $fillable = [
        'user_id',
        'first_request_delay_value',
        'first_request_delay_unit',
        'send_window_start',
        'send_window_end',
        'channels',
        'reminders',
        'max_reminders',
        'ai_replies_enabled',
        'ai_prompt',
        'ai_auto_reply_threshold',
        'filter_returning_only',
        'filter_min_invoice_amount',
        'filter_cooldown_days',
        'exclusion_list',
    ];

    protected $casts = [
        'channels'              => 'array',
        'reminders'             => 'array',
        'ai_replies_enabled'    => 'boolean',
        'filter_returning_only' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

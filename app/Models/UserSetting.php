<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'company_display_name',
        'logo_path',
        'primary_color',
        'secondary_color',
        'sender_name',
        'sender_email',
        'sms_sender_name',
        'privacy_url',
        'unsubscribe_sms_text',
        'gdpr_in_email',
        'unsubscribe_link_in_email',
    ];

    protected $casts = [
        'gdpr_in_email'             => 'boolean',
        'unsubscribe_link_in_email' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

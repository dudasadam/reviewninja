<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'platform',
        'stars',
        'content',
        'reviewer_name',
        'platform_review_id',
        'ai_reply',
        'manual_reply',
        'replied',
        'reviewed_at',
    ];

    protected $casts = [
        'replied'     => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Automation / campaign rules owned by each user.
 * Stores timing, channels, AI settings, filters.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('automation_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Timing
            $table->unsignedSmallInteger('first_request_delay_value')->default(2);
            $table->enum('first_request_delay_unit', ['hour', 'day'])->default('hour');
            $table->time('send_window_start')->default('09:00:00');
            $table->time('send_window_end')->default('20:00:00');

            // Channels (JSON array, e.g. ["sms","email"])
            $table->json('channels')->nullable();

            // Reminders (JSON array of {delay_value, delay_unit, channel})
            $table->json('reminders')->nullable();
            $table->unsignedTinyInteger('max_reminders')->default(2);

            // AI replies
            $table->boolean('ai_replies_enabled')->default(true);
            $table->text('ai_prompt')->nullable();
            $table->enum('ai_auto_reply_threshold', ['all', 'four_plus', 'five_only'])->default('four_plus');

            // Filters
            $table->boolean('filter_returning_only')->default(false);
            $table->unsignedSmallInteger('filter_min_invoice_amount')->nullable();
            $table->unsignedSmallInteger('filter_cooldown_days')->default(90);
            $table->text('exclusion_list')->nullable();   // newline-separated emails/phones

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('automation_rules');
    }
};

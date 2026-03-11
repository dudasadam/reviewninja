<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Branding / appearance settings – one row per user.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Branding
            $table->string('company_display_name')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('primary_color', 10)->default('#35d0ff');
            $table->string('secondary_color', 10)->default('#5a78ff');
            // Email sender
            $table->string('sender_name')->nullable();
            $table->string('sender_email')->nullable();
            // SMS sender
            $table->string('sms_sender_name', 11)->nullable();
            // GDPR
            $table->string('privacy_url')->nullable();
            $table->string('unsubscribe_sms_text')->nullable();
            $table->boolean('gdpr_in_email')->default(true);
            $table->boolean('unsubscribe_link_in_email')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};

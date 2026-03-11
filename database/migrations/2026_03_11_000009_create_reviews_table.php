<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Incoming reviews collected from connected platforms.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('platform', [
                'google', 'facebook', 'tripadvisor',
                'booking', 'trustpilot', 'airbnb', 'other',
            ]);
            $table->tinyInteger('stars')->nullable();           // 1-5
            $table->text('content')->nullable();
            $table->string('reviewer_name')->nullable();
            $table->string('platform_review_id')->nullable();  // external ID for dedup
            $table->text('ai_reply')->nullable();
            $table->text('manual_reply')->nullable();
            $table->boolean('replied')->default(false);
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'platform']);
            $table->index(['user_id', 'reviewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Review platforms connected by each user.
 * A user can have multiple locations per platform.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_platforms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('platform', [
                'google', 'facebook', 'tripadvisor',
                'booking', 'trustpilot', 'airbnb',
            ]);
            $table->string('profile_url')->nullable();
            $table->string('business_id')->nullable();
            $table->text('api_key')->nullable();          // encrypted at app level
            $table->unsignedSmallInteger('locations_count')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamp('connected_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'platform']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_platforms');
    }
};

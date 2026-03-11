<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * External system integrations per user (Billingo, CRM, Zapier, etc.)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('integration_key', [
                'billingo', 'szamlazz', 'minicrm',
                'salesforce', 'zapier', 'webhook',
            ]);
            $table->text('api_key')->nullable();              // encrypted at app level
            $table->enum('trigger_event', [
                'invoice_created', 'crm_closed', 'manual', 'webhook',
            ])->default('invoice_created');
            $table->unsignedSmallInteger('delay_value')->default(2);
            $table->enum('delay_unit', ['hour', 'day'])->default('hour');
            $table->string('webhook_token', 64)->nullable();  // incoming webhook URL token
            $table->boolean('active')->default(true);
            $table->timestamp('connected_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'integration_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_integrations');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Extend the users table with ReviewNinja-specific fields.
 * role: superadmin = platform owner, admin = account admin, user = regular user
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('name');
            $table->string('phone', 30)->nullable()->after('company_name');
            $table->enum('role', ['superadmin', 'admin', 'user'])->default('user')->after('phone');
            $table->enum('status', ['active', 'trial', 'suspended'])->default('trial')->after('role');
            $table->string('subscription_plan', 30)->default('trial')->after('status');
            $table->timestamp('trial_ends_at')->nullable()->after('subscription_plan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'company_name', 'phone', 'role', 'status',
                'subscription_plan', 'trial_ends_at',
            ]);
        });
    }
};

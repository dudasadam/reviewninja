<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_platforms', function (Blueprint $table) {
            $table->text('access_token')->nullable()->after('api_key');
            $table->text('refresh_token')->nullable()->after('access_token');
            $table->timestamp('token_expires_at')->nullable()->after('refresh_token');
            $table->string('google_account_id')->nullable()->after('token_expires_at'); // Google account email
        });
    }

    public function down(): void
    {
        Schema::table('user_platforms', function (Blueprint $table) {
            $table->dropColumn(['access_token', 'refresh_token', 'token_expires_at', 'google_account_id']);
        });
    }
};

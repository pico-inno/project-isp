<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotspot_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Profile name
            $table->string('address_pool')->nullable(); // IP pool
            $table->string('idle_timeout')->nullable(); // E.g., "5m"
            $table->string('keepalive_timeout')->nullable(); // E.g., "2m"
            $table->string('status_autorefresh')->nullable(); // E.g., "1m"
            $table->boolean('shared_users')->default(1); // Concurrent users
            $table->string('rate_limit')->nullable(); // Bandwidth limit, e.g., "512k/2M"
            $table->boolean('mac_cookie')->default(false); // MAC cookie support
            $table->boolean('http_cookie')->default(false); // HTTP cookie support
            $table->string('session_timeout')->nullable(); // E.g., "1h"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotspot_profiles');
    }
};

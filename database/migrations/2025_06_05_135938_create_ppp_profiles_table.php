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
        Schema::create('ppp_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('download_speed');
            $table->string('upload_speed');
            $table->decimal('price', 8, 2);
            $table->integer('validity_days')->default(30);
            $table->timestamps();
        });

//        $table->id();
//        $table->string('name'); // Profile name
//        $table->string('local_address')->nullable(); // Local IP address
//        $table->string('remote_address')->nullable(); // IP pool for remote users
//        $table->string('rate_limit')->nullable(); // Bandwidth limit: "512k/2M"
//        $table->string('dns_server')->nullable(); // DNS server override
//        $table->string('session_timeout')->nullable(); // Max session duration
//        $table->string('idle_timeout')->nullable(); // Disconnect if idle
//        $table->integer('shared_users')->default(1); // Concurrent logins allowed
//        $table->boolean('use_mpls')->default(false); // MPLS setting
//        $table->boolean('use_compression')->default(false); // Enable compression
//        $table->timestamps();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppp_profiles');
    }
};

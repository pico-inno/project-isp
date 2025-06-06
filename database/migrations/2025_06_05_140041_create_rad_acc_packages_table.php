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
        Schema::create('rad_acc_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('radcheck_id')->constrained('radcheck');
            $table->foreignId('ppp_profiles_id')->constrained('ppp_profiles');
            $table->dateTime('expires_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rad_acc_packages');
    }
};

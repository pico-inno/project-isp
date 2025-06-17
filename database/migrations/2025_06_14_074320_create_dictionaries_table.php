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
        Schema::create('dictionaries', function (Blueprint $table) {
            $table->id();
            $table->string('type', 30)->nullable();
            $table->string('attribute', 64)->nullable();
            $table->string('value', 64)->nullable();
            $table->string('format', 20)->nullable();
            $table->string('vendor', 32)->nullable();
            $table->string('recommended_OP', 32)->nullable();
            $table->string('recommended_table', 32)->nullable();
            $table->string('recommended_helper', 32)->nullable();
            $table->string('recommended_tooltip', 512)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictionaries');
    }
};

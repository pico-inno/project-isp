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
      Schema::create('batch_radcheck', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('batch_id');
          $table->unsignedBigInteger('radcheck_id');
          $table->timestamps();

          $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
          $table->foreign('radcheck_id')->references('id')->on('radcheck')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_radchecks');
    }
};

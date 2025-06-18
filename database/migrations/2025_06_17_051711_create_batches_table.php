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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_name', 64)->nullable()->index()->comment('an identifier name of the batch instance');
            $table->string('batch_description', 256)->nullable()->comment('general description of the entry');
            $table->integer('hotspot_id')->nullable()->default(0)->comment('the hotspot business id associated with this batch instance');
            $table->string('batch_status', 128)->default('Pending')->comment('the batch status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};

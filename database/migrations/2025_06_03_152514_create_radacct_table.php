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
        Schema::create('radacct', function (Blueprint $table) {
            $table->id('radacctid'); // Primary key

            $table->string('acctsessionid', 64)->index();
            $table->string('acctuniqueid', 32)->index();
            $table->string('username', 64)->index();
            $table->string('realm', 64)->nullable();
            $table->string('nasipaddress', 15)->index();
            $table->string('nasportid', 32)->nullable();
            $table->string('nasporttype', 32)->nullable();
            $table->dateTime('acctstarttime')->nullable()->index();
            $table->dateTime('acctupdatetime')->nullable();
            $table->dateTime('acctstoptime')->nullable()->index();
            $table->integer('acctinterval')->nullable()->index();
            $table->unsignedInteger('acctsessiontime')->nullable()->index();
            $table->string('acctauthentic', 32)->nullable();
            $table->string('connectinfo_start', 128)->nullable();
            $table->string('connectinfo_stop', 128)->nullable();
            $table->bigInteger('acctinputoctets')->nullable();
            $table->bigInteger('acctoutputoctets')->nullable();
            $table->string('calledstationid', 50);
            $table->string('callingstationid', 50);
            $table->string('acctterminatecause', 32);
            $table->string('servicetype', 32)->nullable();
            $table->string('framedprotocol', 32)->nullable();
            $table->string('framedipaddress', 15)->index();
            $table->string('framedipv6address', 45)->index();
            $table->string('framedipv6prefix', 45)->index();
            $table->string('framedinterfaceid', 44)->index();
            $table->string('delegatedipv6prefix', 45)->index();
            $table->string('class', 64)->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radacct');
    }
};

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mac_address',50)->nullable();
            $table->boolean('unit_is_active');
            $table->boolean('unit_is_inuse');
            $table->boolean('oximeter_is_active');
            $table->boolean('bp_is_active');
            $table->boolean('thermometer_is_active');
            $table->integer('oximeter_delay')->nullable();
            $table->integer('bp_delay')->nullable();
            $table->integer('thermometer_delay')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}

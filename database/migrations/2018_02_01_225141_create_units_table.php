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
            $table->boolean('unit_is_active')->nullable();;
            $table->boolean('unit_is_inuse')->nullable();;
            $table->boolean('oximeter_is_active')->nullable();;
            $table->boolean('bp_is_active')->nullable();;
            $table->boolean('thermometer_is_active')->nullable();;
            $table->time('oximeter_delay')->nullable();
            $table->time('bp_delay')->nullable();
            $table->time('thermometer_delay')->nullable();
            $table->text('comment')->nullable();
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

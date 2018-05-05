<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUnitsTable extends Migration
{
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
        $table->increments('id');
        $table->string('label',50);
        $table->string('mac_address',50);
        $table->boolean('unit_is_active')->nullable();
        $table->boolean('unit_is_inuse');
        $table->boolean('oximeter_is_active');
        $table->boolean('bp_is_active');
        $table->boolean('thermometer_is_active');
        $table->time('oximeter_delay')->nullable();
        $table->time('bp_delay')->nullable();
        $table->time('thermometer_delay')->nullable();
        $table->text('comment')->nullable();
        $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('units');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUnitsColsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
    Schema::table('units', function (Blueprint $table) {
            $table->string('oximeter_delay')->nullable()->change();
            $table->string('bp_delay')->nullable()->change();
            $table->string('thermometer_delay')->nullable()->change();
        });
}

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            //
        });
    }
}

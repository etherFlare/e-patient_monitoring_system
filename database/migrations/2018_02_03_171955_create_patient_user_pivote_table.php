<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientUserPivoteTable extends Migration
{
    public function up()
    {
        Schema::create('patient_obeserver', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned();
            $table->integer('user_id')->unsigned();
        });
    }
    public function down()
    {
        Schema::dropIfExists('patient_obeserver');
    }
}

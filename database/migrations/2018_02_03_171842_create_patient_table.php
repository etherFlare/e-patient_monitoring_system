<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientTable extends Migration
{
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_id')->unsigned();
            $table->string('first_name',20);
            $table->string('middle_name',20);
            $table->string('last_name',20);
            $table->string('gender',10);
            $table->integer('age');
            $table->integer('location_id')->unsigned();
            $table->string('home_address',50);    
            $table->string('contact_number',50);
            $table->string('contact_person',50);
            $table->boolean('is_active');
            $table->boolean('is_archive');
            $table->string('comment',255)->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}

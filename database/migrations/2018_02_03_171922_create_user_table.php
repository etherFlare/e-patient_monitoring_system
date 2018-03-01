<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',20);
            $table->string('middle_name',20);
            $table->string('last_name',20);
            $table->unsignedinteger('contact_number');
            $table->string('email',20)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            // add description
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}

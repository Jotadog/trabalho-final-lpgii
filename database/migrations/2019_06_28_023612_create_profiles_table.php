<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_FK')->unsigned();
            $table->foreign('user_FK')->references('id')->on('users');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('register')->nullable();
            $table->string('address')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->string('contact')->nullable();
            $table->string('photo')->nullable();
            $table->string('status');
            $table->bigInteger('role_FK')->unsigned();
            $table->foreign('role_FK')->references('id')->on('roles');
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
        Schema::dropIfExists('profiles');
    }
}

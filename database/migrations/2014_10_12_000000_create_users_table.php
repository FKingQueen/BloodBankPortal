<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('userType');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('middleInitial');
            $table->bigInteger('age');
            $table->date('birthDate');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('gender');
            $table->string('bloodType');
            $table->string('phoneNumber');
            $table->string('idPicName')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

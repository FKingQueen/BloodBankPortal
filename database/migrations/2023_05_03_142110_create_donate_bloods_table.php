<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonateBloodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donate_bloods', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('bloodType');
            $table->string('address');
            $table->string('phoneNumber');
            $table->string('expireDate');
            $table->string('donateDate');
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
        Schema::dropIfExists('donate_bloods');
    }
}

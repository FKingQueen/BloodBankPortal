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
            $table->boolean('hourSleep');
            $table->boolean('drugUser');
            $table->boolean('alcoholic');
            $table->string('expireDate');
            $table->string('donateDate');
            $table->boolean('db3');
            $table->boolean('cardHolder');
            $table->double('weight', 8, 2);
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRescueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rescue', function (Blueprint $table) {
          //  $table->id();
            $table->bigIncrements('id');
            $table->string('animalName');
            $table->string('category');
            $table->integer('year');
            $table->string('gender');
            $table->string('address');
            $table->string('phone');
            $table->string('postedBy');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('description');
          //   $table->rememberToken();
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
        Schema::dropIfExists('rescue');
    }
}

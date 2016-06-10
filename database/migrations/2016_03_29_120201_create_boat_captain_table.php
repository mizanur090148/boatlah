<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoatCaptainTable extends Migration
{

    public function up()
    {
        Schema::create('rel_boat_captain', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('boat_id')->unsigned();
            $table->bigInteger('captain_id')->unsigned();
            $table->timestamps();

            $table->foreign('boat_id')->references('id')->on('boats')->onDelete('cascade');
            $table->foreign('captain_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rel_boat_captain');
    }
}

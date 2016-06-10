<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoatCoordinatorProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boat_coordinator_profiles', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->enum('gender', ['male', 'female']);
            $table->enum('location', ['Eastern', 'Western']);
            $table->string('about');
            $table->bigInteger('boat_owner')->unsigned()->nullable();
            $table->enum('loggedin',['no','yes']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('boat_owner')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('boat_coordinator_profiles');
    }
}

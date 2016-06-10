<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsParentTable extends Migration
{
    public function up()
    {
        Schema::create('trips_parent', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('trip_id');
            $table->bigInteger('boat_id')->unsigned();
            $table->bigInteger('owner_id')->unsigned();
            $table->bigInteger('passenger_id')->unsigned();
            $table->bigInteger('captain_id')->unsigned();
            $table->bigInteger('booked_by')->unsigned();
            $table->bigInteger('shipping_agency')->unsigned()->nullable();
            $table->enum('zone',['Eastern','Western']);
            $table->date('trip_date');
            $table->enum('journey_type', ['single', 'multiple']);
            $table->string('started_at');
            $table->string('completed_at');
            $table->enum('status', ['upcoming', 'ongoing', 'completed']);
            $table->enum('collected_user_type', ['captain', 'coordinator']);
            $table->enum('payment_method', ['cash', 'invoice']);
            $table->bigInteger('collected_by_user')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('boat_id')->references('id')->on('boats')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('passenger_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('captain_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('booked_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shipping_agency')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('collected_by_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('trips_parent');
    }
}

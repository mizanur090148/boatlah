<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsChildTable extends Migration
{
    public function up()
    {
        Schema::create('trips_child', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->integer('principle_id')->unsigned();
            $table->integer('start_point')->unsigned();
            $table->integer('destination_point')->unsigned();
            $table->string('started_at');
            $table->string('completed_at');
            $table->decimal('cost');
            $table->string('vessel_name')->nullable();
            $table->string('accompanying_passenger')->nullable();
            $table->text('remarks')->nullable();
            $table->bigInteger('trips_parent_id')->unsigned();
            $table->enum('aoh',['no','yes']);
            $table->string('waiting_time')->nullable();
            $table->timestamps();

            $table->foreign('principle_id')->references('id')->on('principles')->onDelete('cascade');
            $table->foreign('destination_point')->references('id')->on('base_anchorages')->onDelete('cascade');
            $table->foreign('trips_parent_id')->references('id')->on('trips_parent')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('trips_child');
    }
}

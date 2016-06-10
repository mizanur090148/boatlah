<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('captain_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('company_name');
            $table->enum('operating_zone', ['Eastern','Western']);
            $table->string('registration_no');
            $table->string('date_of_registration');
            $table->string('about');
            $table->string('habourcraft_number');
            $table->string('license');
            $table->string('license_date')->nullable();
            $table->enum('manning_type', ['one manned', 'two manned']);
            $table->string('unique_id');
            $table->string('average_speed');
            $table->string('capacity');
            $table->string('photo');
            $table->string('thumb_photo');
            $table->integer('anchorage_id')->unsigned();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->enum('status', ['available', 'off-duty', 'busy', 'booked']);
            $table->boolean('isactive')->default(1);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('captain_id')->references('id')->on('users')->onDelete('set null');
            //$table->foreign('anchorage_id')->references('id')->on('base_anchorages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('boats');
    }
}

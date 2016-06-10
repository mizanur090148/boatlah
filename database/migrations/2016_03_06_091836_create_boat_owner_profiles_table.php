<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoatOwnerProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boat_owner_profiles', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('company_name');
            $table->string('type_of_firm');
            $table->enum('gender', ['male', 'female']);
            $table->string('uen_number');
            $table->string('date_of_registration');
            $table->string('landline');
            $table->text('about');
            $table->string('gst_registration');
            $table->string('invoice_header_image');
            $table->string('invoice_footer_image');
            $table->text('invoice_bank_details');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('boat_owner_profiles');
    }
}

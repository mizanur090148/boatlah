<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogsTable extends Migration
{
    public function up()
    {
        Schema::create('catalogs', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->integer('catalogs_parent_id')->unsigned();
            $table->enum('zone',['Eastern','Western']);
            $table->enum('status',['inactive','active','pending']);
            $table->timestamps();

            $table->foreign('catalogs_parent_id')->references('id')->on('catalogs_parent')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('catalogs');
    }
}

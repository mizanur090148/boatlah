<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogsParentTable extends Migration
{
    public function up()
    {
        Schema::create('catalogs_parent', function (Blueprint $table) {

            $table->increments('id');
            $table->string('catalogs_code');
            $table->bigInteger('owner_id')->unsigned();
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->enum('catalog_type',['standard','non-standard']);
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('catalogs_parent');
    }
}

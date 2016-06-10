<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogsRelationsTable extends Migration
{
    public function up()
    {
        Schema::create('catalogs_relation', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->integer('catalogs_parent_id')->unsigned();
            $table->integer('principle_id')->unsigned();
            $table->timestamps();

            $table->foreign('catalogs_parent_id')->references('id')->on('catalogs_parent')->onDelete('cascade');
            $table->foreign('principle_id')->references('id')->on('principles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('catalogs_relation');
    }
}

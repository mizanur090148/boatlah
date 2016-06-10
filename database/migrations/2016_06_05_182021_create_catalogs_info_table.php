<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogsInfoTable extends Migration
{
    public function up()
    {
        Schema::create('catalog_info', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('catalogs_id')->unsigned();
            $table->integer('anchorage_code')->unsigned();
            $table->integer('normal_rates');
            $table->integer('aoh_rates');
            $table->integer('charges_withing_same_anchorages');
            $table->integer('free_waiting_time');
            $table->integer('per_block_of_extra_time');
            $table->integer('per_block_of_waiting_time_charges_normal');
            $table->integer('per_block_of_waiting_time_charges_aoh');
            $table->integer('fuel_surcharge');
            $table->integer('extra_boatman_charges');
            $table->timestamps();

            $table->foreign('catalogs_id')->references('id')->on('catalogs')->onDelete('cascade');
            $table->foreign('anchorage_code')->references('id')->on('base_anchorages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('catalog_info');
    }
}

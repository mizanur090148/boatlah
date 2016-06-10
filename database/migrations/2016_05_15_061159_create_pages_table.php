<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{

    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->string('title');
            $table->binary('content');
            $table->enum('category',['about','learn_more','resources']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('pages');
    }
}

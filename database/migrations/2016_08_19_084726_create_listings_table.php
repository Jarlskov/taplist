<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('beer_id')->unsigned();
            $table->integer('bar_id')->unsigned();
            $table->string('tap_name');
            $table->boolean('is_available');

            $table->timestamps();

            $table->foreign('beer_id')->references('id')->on('beers');
            $table->foreign('bar_id')->references('id')->on('bars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('listings');
    }
}

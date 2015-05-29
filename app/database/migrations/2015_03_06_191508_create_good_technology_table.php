<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodTechnologyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('good_technology', function($table)
        {
            $table->integer('id_good')->unsigned();
            $table->integer('id_technology')->unsigned();

            $table->foreign('id_good')->references('id')->on('goods')->onUpdate('cascade');
            $table->foreign('id_technology')->references('id')->on('technologies')->onUpdate('cascade');
        });
    }


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('good_technology');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGallerySectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('gallerySections',function($table)
        {
        $table -> increments('section_id')->unsigned()->nullable();
        $table -> string('title',100);
        $table -> text('description');
        $table -> integer('position')->unsigned();
        $table -> timestamps();
        });
	}
	

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
        Schema::drop('gallerySections');
	}

}

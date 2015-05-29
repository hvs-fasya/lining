<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//создание таблицы с фотографиями галереи;
        Schema::create('photos',function($table)
        {
        $table -> increments('id');
        $table -> integer ('section_id')->unsigned()->nullable();
        $table->foreign('section_id')->references('section_id')->on('gallerySections')->onUpdate('cascade')->onDelete('set null');
        $table -> string('title',100)->nullable;
        $table -> string('photo',300);
        $table -> string('preview',300);
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
        Schema::drop('photos');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechnologiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//создание таблицы технологий;
        Schema::create('technologies',function($table)
        {
        $table -> increments('id');
        $table -> string('name',80);
        $table -> string('shortname',10)->nullable;
        $table -> text('description')->nullable;
        $table -> string('logo',100)->nullable;
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
        Schema::drop('technologies');
	}

}

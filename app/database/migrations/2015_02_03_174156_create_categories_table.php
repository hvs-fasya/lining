<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	
	public function up()
	{
        //создание таблицы категории товаров;
        Schema::create('categories',function($table)
            {
            $table -> increments('category_id')->unsigned()->nullable();
            $table -> string('category',100);
            $table -> integer ('position')->unsigned();
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
        Schema::drop('categories');
	}

}

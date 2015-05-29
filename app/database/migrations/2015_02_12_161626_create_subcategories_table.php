<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subcategories',function($table)
        {
        $table -> increments('id');
        $table -> integer ('category_id')->unsigned()->nullable();
        $table->foreign('category_id')->references('category_id')->on('categories')->onUpdate('cascade')->onDelete('set null');
        $table -> string('title',50)->nullable;
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
		//
        Schema::drop('subcategories');
	}

}

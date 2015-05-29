<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//создание таблицы товаров;
        Schema::create('goods',function($table)
        {
        $table -> increments('id');
        $table -> integer ('subcat_id')->unsigned()->nullable();
        $table->foreign('subcat_id')->references('id')->on('subcategories')->onUpdate('cascade')->onDelete('set null');
        $table -> string('artikel',50)->nullable;
        $table -> text('description')->nullable;
        $table -> string('fullsize',100);
        $table -> string('goodpreview',100);
        $table -> decimal('price',6,2)->unsigned;
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
        Schema::drop('goods');
	}

}

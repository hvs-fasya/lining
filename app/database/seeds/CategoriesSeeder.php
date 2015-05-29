<?php


class CategoriesSeeder extends Seeder {

  public function run()
  {
      //DB::table('categories')->delete();
      //Category::truncate();
      Category::create(['category'=>'Ракетки','position'=>1]);
      Category::create(['category'=>'Воланы','position'=>2]);
      Category::create(['category'=>'Одежда','position'=>3]);
      Category::create(['category'=>'Обувь','position'=>4]);
      Category::create(['category'=>'Чехлы/сумки','position'=>5]);
      Category::create(['category'=>'Аксессуары','position'=>6]);
      
  }

}
<?php


class SubcategoriesSeeder extends Seeder {

  public function run()
  {
      DB::table('subcategories')->delete();
      //Subcategory::truncate();
      Subcategory::create(['category_id'=>1,
                            'title'=>'N-серия',
                            'position'=>1]);
      Subcategory::create(['category_id'=>1,
                            'title'=>'Серия ракеток 2',
                            'position'=>2]);
      Subcategory::create(['category_id'=>1,
                            'title'=>'Серия ракеток 3',
                            'position'=>3]);
      Subcategory::create(['category_id'=>1,
                            'title'=>'Серия ракеток 4',
                            'position'=>4]);
      Subcategory::create(['category_id'=>1,
                            'title'=>'Серия ракеток 5',
                            'position'=>5]);
      Subcategory::create(['category_id'=>2,
                            'title'=>'Серия воланов 1',
                            'position'=>1]);
      Subcategory::create(['category_id'=>2,
                            'title'=>'Серия воланов 2',
                            'position'=>2]);
      Subcategory::create(['category_id'=>2,
                            'title'=>'Серия воланов 3',
                            'position'=>3]);
      Subcategory::create(['category_id'=>2,
                            'title'=>'Серия воланов 4',
                            'position'=>4]);
      Subcategory::create(['category_id'=>2,
                            'title'=>'Серия воланов 5',
                            'position'=>5]);
      Subcategory::create(['category_id'=>3,
                            'title'=>'Футболки муж/жен',
                            'position'=>1]);
      Subcategory::create(['category_id'=>3,
                            'title'=>'Шорты/юбки',
                            'position'=>2]);
      Subcategory::create(['category_id'=>3,
                            'title'=>'Спортивные костюмы',
                            'position'=>3]);
      Subcategory::create(['category_id'=>3,
                            'title'=>'Носки',
                            'position'=>4]);
      Subcategory::create(['category_id'=>4,
                            'title'=>'Кроссовки мужские',
                            'position'=>1]);
      Subcategory::create(['category_id'=>4,
                            'title'=>'Кроссовки женские',
                            'position'=>2]);
      Subcategory::create(['category_id'=>4,
                            'title'=>'Кроссовки детские',
                            'position'=>3]);
      Subcategory::create(['category_id'=>5,
                            'title'=>'Чехлы',
                            'position'=>1]);
      Subcategory::create(['category_id'=>5,
                            'title'=>'Рюкзаки',
                            'position'=>2]);
      Subcategory::create(['category_id'=>6,
                            'title'=>'Обмотки',
                            'position'=>1]);
      Subcategory::create(['category_id'=>6,
                            'title'=>'Струны',
                            'position'=>2]);
      
  }

}
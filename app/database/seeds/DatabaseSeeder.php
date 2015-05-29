<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
        $this->call('PostsSeeder');
        $this->call('CategoriesSeeder');
        $this->call('GallerySectionsSeeder');
        $this->call('CalendarsSeeder');
        $this->call('SubcategoriesSeeder');
		$this->call('GoodsSeeder');
		$this->call('PhotosSeeder');
		$this->call('UsersSeeder');
		$this->call('TechnologiesSeeder');
        $this->command->info('Таблица новостей и таблица категорий товаров загружены данными!');
	}

}

<?php

class CalendarsSeeder extends Seeder {

	/**
	 * Run the Calendar seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker\Factory::create();
        Calendar::truncate();
        for($i=0;$i<10;$i++){
            Calendar::create([
                'title'=>$faker->sentence(3),
                'date'=>$faker->date($format = 'j-F-Y', $max = 'now'),
                'body'=>$faker->paragraph(3),
            ]);
        }

		// $this->call('UserTableSeeder');
	}

}

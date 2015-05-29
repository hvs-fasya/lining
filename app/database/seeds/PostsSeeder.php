<?php

class PostsSeeder extends Seeder {

	/**
	 * Run the News seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker\Factory::create();
        Post::truncate();
        for($i=0;$i<10;$i++){
            Post::create([
                'title'=>$faker->sentence(3),
                //'date'=>$faker->date($format = 'j-F-Y', $max = 'now'),
                'date'=>($i+1).'-января-2015',
                'body'=>$faker->paragraph(7),
                'position'=>($i+1)
            ]);
        }

		// $this->call('UserTableSeeder');
	}

}

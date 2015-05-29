<?php

use Illuminate\Filesystem;

class TextsSeeder extends Seeder {

	
	public function run()
	{
        if( !File::exists(storage_path().'/'.'texts') )
            {
            File::makeDirectory(storage_path().'/'.'texts');
            }
        $faker = Faker\Factory::create();
        $branches = [
                    'child'=>'Дети',
                    'individual'=>'Индивидуальные тренировки',
                    'grownup'=>'Взрослые',
                    'shedule'=>'Расписание',
                    'price'=>'Цены',
                    'li-ning'=>'Li-ning'
                    ];
        foreach ( $branches as $key => $value ){
            $body = $faker->paragraph(7);
            $title = $faker->sentence(5);
            $filename = $key.'.txt';
            $path = storage_path().'/texts/'.$filename;
            File::put($path,'<h4>'.$title.'</h4><p>'.$body.'</p>');
        }
    }
    
}
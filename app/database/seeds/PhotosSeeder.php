<?php

class PhotosSeeder extends Seeder {

	/**
	 * Run the Photos seeds.
	 *
	 * @return void
	 */
   
    public function run()
	{
		$faker = Faker\Factory::create();
        Photo::truncate();
        //$path = 'C:\openserver\domains\badmrulittest\public\img\gallery\photo';
        $path = 'public/img/gallery/photo';
        $dirlist = array_diff(scandir($path),['.','..']);
        foreach($dirlist as $dir){
            $imagelist = array_diff(scandir($path.'\\'.$dir),['.','..']);
            foreach ($imagelist as $image){
            $preview = Photo::makePreview($image,$dir,100,100);
            $section=GallerySection::where('title','=', $dir)->get();
            Photo::create([
                'section_id'=>$section[0]->section_id,
                'title'=>$faker->sentence(3),
                //'date'=>$faker->date($format = 'j-F-Y', $max = 'now'),
                'photo'=>'img/gallery/photo/'.$dir.'/'.$image,
                'preview'=>'img/gallery/preview/'.$dir.'/'.$image
            ]);
            }
        }

		// $this->call('UserTableSeeder');
	}

}

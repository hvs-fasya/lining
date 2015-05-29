<?php

class EventsController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'NewsController@getThree');
	|
	*/

	public function getEvents()
	{
        
        $archieve = Post::getArchieve();
        $gallerySection = GallerySection::getGallerySection();
        //$photos = Photo::getPhotoBySection();
        //$calendar = Calendar::getAll();
        //$calendar = Calendar::getAllOrdered();
        //return '<pre>'.print_r($gallerySection[0]['section_id'],true);
        //$sections = DB::table('gallerySections')->lists('section_id');
        //return '<pre>'.print_r($sections, true).'</pre>';
		//return View::make('events')->with(['calendar'=>$calendar,'archieve'=>$archieve,'gallerySection'=>$gallerySection]);
		return View::make('events')->with(['archieve'=>$archieve,'gallerySection'=>$gallerySection]);
	}

}
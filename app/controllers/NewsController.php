<?php

class NewsController extends BaseController {

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

	public function getThree()
	{
        //$posts = Post::getAll();
        $posts = Post::getThree();
        //return '<pre>'.print_r($posts,true).'</pre>';
		return View::make('home')->with('posts',$posts);
	}

}
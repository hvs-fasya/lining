<?php

class CatalogController extends BaseController {

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

	public function getCategories(){
        $categories = Category::getAll();
        $subcategories = Subcategory::getSubcategoryByCategory();
        $goods = Good::getGoodBySubcat();
        $technologies = Technology::get();
        $dir_data = scandir('../public/img/catalog_show');
        if($dir_data && !empty($dir_data)){
            $catalog_show = array_slice($dir_data,2);
            }else{
            $catalog_show = ['home2.jpg','home5.jpg'];}
		return View::make('catalog')->with(['categories'=>$categories,'subcategories'=>$subcategories,'goods'=>$goods,'technologies'=>$technologies,'catalog_show'=>$catalog_show]);
        //return '<pre>'.print_r($technologies,true).'</pre>';
        }
	

}
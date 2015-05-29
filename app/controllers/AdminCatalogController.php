<?php

class AdmincatalogController extends BaseController {

    //----------------------------------//
    //работа с категориями товаров
    //----------------------------------//
    public function editCategories($message=null)
	{
		$categories = Category::getAll();
        $msg = $message;
        return View::make('admincategory')->with(['categories'=>$categories]);
	}
    public function deleteCategory()
    {
        $message = Category::delCat();
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@editCategories');
    }
    public function updateCategory()
    {   
        $data = Input::all();
        $catId = Input::get('id');
        $catName = $data[$catId]['catName'];
        $rules = Category::$categoryValidation;
        $dataArr = ['id'=>$catId,'catName'=>$catName];
        $catValidator = Validator::make($dataArr,$rules);
        if($catValidator->fails()){
           $messages = $catValidator->messages();
           $messages->toArray();
           Session::flash('opentab', $catId);
           return Redirect::back()->withErrors($catValidator)->withInput();
        }
        $message = Category::updateCat($dataArr);
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@editCategories');
        //return '<pre>'.print_r($data,true).'<pre>';
    }
    public function addCategory()
    {
        $data = Input::all();
        $rules = Category::$categoryValidation;
        $catValidator = Validator::make($data,$rules);
        if($catValidator->fails()){
           $messages = $catValidator->messages();
           $messages->toArray();
           Session::flash('opentab', 'addcat');
           return Redirect::back()->withErrors($catValidator)->withInput();
        }
        $message = Category::addCat($data);
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@editCategories');
    }
    public function moveCategory()
    {
        $message = Category::moveCat();
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@editCategories');
    }
    //----------------------------------//
    //работа с ПОДкатегориями товаров
    //----------------------------------//
    public function editSubcategories($message=null)
	{
        $categories = Category::getAll();
        $subcategories = Subcategory::getSubcategoryByCategory();
        $msg = $message;
        //$subcategories = Subcategory::all();
		return View::make('adminsubcategory')->with(['categories'=>$categories,'subcategories'=>$subcategories,'message'=>$msg]);
        //return $message;
	}
    public function deleteSubcategories()
	{
        $message = Subcategory::delSub();
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@editSubcategories');
	}
    public function updateSubcategory()
    {
        $message = Subcategory::updateSub();
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@editSubcategories');
    }
    
     public function addSubcategory()
    {
        $message = Subcategory::addSub();
        Session::flash('message', $message);
		return Redirect::action('AdmincatalogController@editSubcategories');
    }
    public function setcatSubcategory()
    {
        $message = Subcategory::setcatSub();
        Session::flash('message', $message);
		return Redirect::action('AdmincatalogController@editSubcategories');
    }
    public function moveSubcategory()
    {
        $message = Subcategory::moveSub();
        Session::flash('message', $message);
		return Redirect::action('AdmincatalogController@editSubcategories');
    }

    
    //----------------------------------//
    //работа с товарами
    //----------------------------------//
    public function updateGoods($message=null)
	{
        $categories = Category::getAll();
        $subcategories = Subcategory::getAll();
        $goods = Good::getAll();
        $technologies = Technology::all();
		return View::make('admingoodsedit')->with(['categories'=>$categories,'subcategories'=>$subcategories,'goods'=>$goods,'technologies'=>$technologies]);
	}
    public function deleteGoods()
	{
        $categories = Category::getAll();
        $subcategories = Subcategory::getAll();
        $goods = Good::getAll();
        $arrayCat=[];
		return View::make('admingoodsdelete')->with(['categories'=>$categories,'subcategories'=>$subcategories,'goods'=>$goods]);
        //return '<pre>'.print_r($arrayCat,true).'</pre>';
	}
    public function delGood()
	{
        $message = Good::delGood();
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@deleteGoods');
	}
    public function addGoods()
	{
        $categories = Category::getAll();
        $subcategories = Subcategory::getAll();
        $technologies = Technology::all();
		return View::make('admingoodsadd')->with(['categories'=>$categories,'subcategories'=>$subcategories,'technologies'=>$technologies]);
	}
    public function updateTech()
	{
        $categories = Category::getAll();
        $subcategories = Subcategory::getAll();
        $technologies = Technology::orderBy('name')->get();
		return View::make('admintechedit')->with(['categories'=>$categories,'subcategories'=>$subcategories,'technologies'=>$technologies]);
	}
    public function newGood()
	{
        $data = Input::all();
        $out = $data;
        $rules = Good::$goodValidation;
        $dataArr = ['goodArtikel'=>$data['goodArtikel'],'goodSub'=>$data['goodSub'],'goodPrice'=>$data['goodPrice']];
        $goodValidator = Validator::make($dataArr,$rules);
        if($goodValidator->fails()){
           $messages = $goodValidator->messages();
           $messages->toArray();
           return Redirect::back()->withErrors($goodValidator)->withInput();
        }
        if ( $file = $data['image'] ) {
            $rules = [];
            $rules = ['image'=>'image'];
            $imageValidator = Validator::make(['image'=>$file],$rules);
            if($imageValidator->fails()){
               $messages = $imageValidator->messages();
               $messages->toArray();
               return Redirect::back()->withErrors($imageValidator)->withInput();
            }else{
            $format = $file->getClientOriginalExtension();
            $filename = str_replace(' ','_',$data['goodArtikel']).'.'.$format;
            $path = 'img/goods_full_size';
            $file->move($path, $filename);
            $out['fullsize'] = $path.'/'.$filename;
            $preview = Good::makePreview($filename,'img/goods_full_size',80,80);
            $out['goodpreview'] = 'img/goods_preview/'.$filename;
            }
        }else{
            $out['fullsize'] = '';
            $out['goodpreview']= '';
        }
        if( isset($out['setTech']) ){
            $out['setTech'] = array_values($out['setTech']);
        }
        $message = Good::addGood($out);
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@addGoods');
        //return '<pre>'.print_r( $out,true ).'<pre>';
	}
    public function editGood()
	{  
        $data = Input::all();
        $goodId = explode('_',array_keys($data)[1])[1];
        $goodDescr = $data['goodDescr_'.$goodId];
        $goodArtikel = $data['goodArtikel_'.$goodId];
        $goodSub = $data['goodSub_'.$goodId];
        $goodPrice = $data['goodPrice_'.$goodId];
        $goodCat = $data['cat_'.$goodId];
        $out = ['id'=>$goodId,'goodArtikel'=>$goodArtikel,'goodSub'=>$goodSub,'goodPrice'=>$goodPrice,'goodDescr'=>$goodDescr];
        $rules = Good::$goodValidation;
        $dataArr = ['goodArtikel'=>$goodArtikel,'goodSub'=>$goodSub,'goodPrice'=>$goodPrice];
        $goodValidator = Validator::make($dataArr,$rules);
        if($goodValidator->fails()){
           $messages = $goodValidator->messages();
           $messages->toArray();
           Session::flash('opentab', $goodCat.'::'.$goodSub.'::'.$goodId);
           return Redirect::back()->withErrors($goodValidator)->withInput();
        }
        if ( $file = $data['image_'.$goodId] ) {
            $rules = [];
            $rules = ['image'=>'image'];
            $imageValidator = Validator::make(['image'=>$file],$rules);
            if($imageValidator->fails()){
               $messages = $imageValidator->messages();
               $messages->toArray();
               Session::flash('opentab', $goodCat.'::'.$goodSub.'::'.$goodId);
               return Redirect::back()->withErrors($imageValidator)->withInput();
            }else{
            $format = $file->getClientOriginalExtension();
            $filename = str_replace(' ','_',$goodArtikel).'.'.$format;
            $path = 'img/goods_full_size';
            $file->move(public_path().'/'.$path, $filename);
            $out['fullsize'] = $path.'/'.$filename;
            $preview = Good::makePreview($filename,'img/goods_full_size',80,80);
            $out['goodpreview'] = 'img/goods_preview/'.$filename;
            }
        }else{
            $out['fullsize'] = '';
            $out['goodpreview']= '';
        }
        if ( $data['addTech_'.$goodId] ){
            $out['addTech'] = $data['addTech_'.$goodId];
        }
        if ( $data['moveTech_'.$goodId] ){
            $out['moveTech'] = $data['moveTech_'.$goodId];
        }
        $message = Good::editGood( $out );
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@updateGoods');
        //return '<pre>'.print_r( $out,true ).'<pre>';
	}
    public function setSub()
	{
        $data = Input::all();
        $out = [];
        $out['gnullid'] = explode('_',array_keys($data)[1])[1];
        $out['gnullsub'] = $data['gnullsub_'.$out['gnullid']];
        $message = Good::setGoodSub($out);
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@updateGoods');
        //return '<pre>'.print_r( $out,true ).'<pre>';
	}
    public function newTech()
	{
        $data = Input::all();
        $out = $data;
        $rules = Technology::$techValidation;
        $dataArr = ['techName'=>$data['techName'],'shortName'=>$data['shortName'],'techDescr'=>$data['techDescr']];
        $techValidator = Validator::make($dataArr,$rules);
        if($techValidator->fails()){
           $messages = $techValidator->messages();
           $messages->toArray();
           Session::flash('opentab', 'addTechnology');
           return Redirect::back()->withErrors($techValidator)->withInput();
        }
        if ( $file = Input::file('logo') ) {
            $rules = [];
            $rules = ['logo'=>'image'];
            $imageValidator = Validator::make(['logo'=>$file],$rules);
            if($imageValidator->fails()){
               $messages = $imageValidator->messages();
               $messages->toArray();
               Session::flash('opentab', 'addTechnology');
               return Redirect::back()->withErrors($imageValidator)->withInput();
            }else{
            $format = $file->getClientOriginalExtension();
            $filename = str_replace(' ','_',$data['techName']).'.'.$format;
            $path = 'img/technology';
            $file->move($path, $filename);
            $out['logo'] = $path.'/'.$filename;
            //Technology::resizeLogo($filename,200);
            }
        }else{
            $out['logo'] = '';
        }
        $message = Technology::addTechnology($out);
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@updateTech');
        //return '<pre>'.print_r( $info,true ).'<pre>';
	}
    
    public function delTech()
	{
        $id = Input::get('techId');
        $message = Technology::deleteTech($id);
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@updateTech');
	}
    
    public function editTech()
	{
        $data = Input::all();
        $out = [];
        $out['id'] = explode('_',array_keys($data)[1])[1];
        $out['techName'] = $data['techName_'.$out['id']];
        $out['shortName'] = $data['shortName_'.$out['id']];
        $out['techDescr'] = $data['techDescr_'.$out['id']];
        $rules = Technology::$techValidation;
        $dataArr = ['techName'=>$out['techName'],'shortName'=>$out['shortName'],'techDescr'=>$out['techDescr']];
        $techValidator = Validator::make($dataArr,$rules);
        if($techValidator->fails()){
           $messages = $techValidator->messages();
           $messages->toArray();
           Session::flash('opentab', $out['id']);
           return Redirect::back()->withErrors($techValidator)->withInput();
        }
        if ( $file = Input::file('logo_'.$out['id']) ) {
            $rules = [];
            $rules = ['logo'=>'image'];
            $imageValidator = Validator::make(['logo'=>$file],$rules);
            if($imageValidator->fails()){
               $messages = $imageValidator->messages();
               $messages->toArray();
               Session::flash('opentab', $out['id']);
               return Redirect::back()->withErrors($imageValidator)->withInput();
            }else{
            $format = $file->getClientOriginalExtension();
            $filename = str_replace(' ','_',$out['techName']).'.'.$format;
            $path = 'img/technology';
            $file->move($path, $filename);
            $out['logo'] = $path.'/'.$filename;
            //Technology::resizeLogo($filename,200);
            }
        }else{
            $out['logo'] = '';
        }
        $message = Technology::editTechnology($out);
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@updateTech');
        //return '<pre>'.print_r( $out,true ).'<pre>';
	}
    
    public function bindTech()
	{
        $data = Input::all();
        $out = [];
        $out['id'] = explode('_',array_keys($data)[1])[2];
        $out['idSet'] = array_slice(array_values($data),1,(count($data)-2));
        $message = Technology::bindTech($out);
        Session::flash('message', $message);
        return Redirect::action('AdmincatalogController@updateTech');
        //return '<pre>'.print_r( $out,true ).'<pre>';
	}
}
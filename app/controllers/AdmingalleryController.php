<?php

class AdmingalleryController extends BaseController {

    public function addFolder()
	{
		/* $posts = Post:: orderBy('position','desc')->get();
        $msg = $message;*/
        $gallerySections = GallerySection::getGallerySection();
        return View::make('adminaddfolder')->with(['gallerySections'=>$gallerySections]);
	}
    
    public function newFolder()
	{
		$data = Input::get();
        $rules = GallerySection::$sectionValidation;
        $secValidator = Validator::make($data,$rules);
        if($secValidator->fails()){
           $messages = $secValidator->messages();
           $messages->toArray();
           Session::flash('opentab', 'addFolder');
           return Redirect::back()->withErrors($secValidator)->withInput();
        }
        $message = GallerySection::newDir($data);
        Session::flash('message', $message);
        return Redirect::action('AdmingalleryController@addFolder');
        //return '<pre>'.print_r($data,true).'</pre>';
	}

    public function moveFolder()
    {
        $data = Input::all();
        $out['secId'] = explode('_',array_keys($data)[1])[1];
        $out['prevPos'] = $data['prevSec_'.$out['secId']];
        $message = GallerySection::moveDir($out);
        Session::flash('message', $message);
        return Redirect::action('AdmingalleryController@addFolder');
        //return '<pre>'.print_r($out,true).'</pre>';
    }
    
    public function changeFolder()
    {
        $data = Input::all();
        $out['secId'] = explode('_',array_keys($data)[1])[1];
        $out['newDescr'] = $data['newDescr_'.$out['secId']];
        $rules = ['newDescr'=>'required'];
        $descrValidator = Validator::make($out,$rules);
        if( $descrValidator->fails() ){
            $messages = $descrValidator->messages();
            $messages->toArray();
            Session::flash('opentab', 'changeTitle::'.$out['secId']);
            return Redirect::back()->withErrors($descrValidator)->withInput();
        }
        $message = GallerySection::changeDir($out);
        Session::flash('message', $message);
        return Redirect::action('AdmingalleryController@addFolder');
        //return '<pre>'.print_r($out,true).'</pre>';
    }
    public function newPhoto()
	{
		$data = Input::all();
        $out['secId'] = explode('_',array_keys($data)[1])[1];
        $rules = ['photo'=>'required|image'];
        $imageValidator = Validator::make(['photo'=>$data['photo_'.$out['secId']]],$rules);
        if( $imageValidator->fails() ){
            $messages = $imageValidator->messages();
            $messages->toArray();
            Session::flash('opentab', 'addPhoto::'.$out['secId']);
            return Redirect::back()->withErrors($imageValidator)->withInput();
            }
        $out['photo'] = $data['photo_'.$out['secId']];
        $message = Photo::addPhoto($out);
        Session::flash('message', $message);
        return Redirect::action('AdmingalleryController@addFolder');
        //return '<pre>'.print_r($out,true).'</pre>';
	}
    public function delFolder()
    {
        $gallerySections = GallerySection::getGallerySection();
        return View::make('admingallerydel')->with(['gallerySections'=>$gallerySections]);
    }
    public function delPhoto()
    {
        $photoId = explode('_',array_keys(Input::all())[1])[1];
        $message = Photo::deletePhoto($photoId);
        Session::flash('message', $message);
        return Redirect::action('AdmingalleryController@delFolder');
        //return '<pre>'.print_r($photoId,true).'</pre>';
    }
    public function delDir()
    {
        $dirId = explode('_',array_keys(Input::all())[1])[1];
        $message = GallerySection::deleteFolder($dirId);
        Session::flash('message', $message);
        return Redirect::action('AdmingalleryController@delFolder');
        //return '<pre>'.print_r($dirId,true).'</pre>';
    }
    
    }
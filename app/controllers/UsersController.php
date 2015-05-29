<?php

class UsersController extends BaseController {

    public function signin($message=null){
        $msg = $message;
        return View::make('admin',array('message'=>$msg));
    }

    public function regUser(){
        $rules = User::$validation;
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()){
            $messages = $validator->messages();
            $messages->toArray();
            return Redirect::to('admin')->withErrors($validator)->withInput();
        }
        $message = User::register(Input::all());
        return Redirect::action('UsersController@signin', array('message'=>$message));
        //return '<pre>'.print_r($data,true).'<pre>';
    }
    
    public function userlogin(){
        $data = array(
                        'password' => Input::get('password'),
                        'username' => Input::get('username')
                        );
        if (Auth::attempt($data, Input::has('remember'))){
            $message='Пользователь '.Input::get('username').' авторизован и может тут даже поработать';
        }else{
            $message = 'Вы подозрительная личность, '.Input::get('username').'... Пароль с логином не сходятся(((... или логин с паролем???';
            Session::flash('message', $message);
            }
        return Redirect::action('UsersController@signin', array('message'=>$message));
        }
        
    public function userlogout() {
        Auth::logout();
    return Redirect::action('UsersController@signin');
    }
    
    }
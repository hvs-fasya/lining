<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
    protected $fillable = array('username', 'email', 'password', 'isAdmin');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
    
    public static $validation = array(
            // Поле email является обязательным, также это должен быть допустимый адрес
            // электронной почты и быть уникальным в таблице users
        'email'=>'required|email|unique:users',
            // Поле username является обязательным, содержать только латинские символы и цифры, и
            // также быть уникальным в таблице users
        'username'=>'required|alpha_num|unique:users',
            // Поле password является обязательным, должно быть длиной не меньше 6 символов, а
            // также должно быть повторено (подтверждено) в поле password_confirmation
        'password'=>'required|confirmed|min:6',
        'password_confirmation'=>'same:password'
);
    
    public static function register($data){
        try{
        User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'isAdmin' => true,
            'remember_token'=>$data['_token'],
            'email'=>$data['email']
           ]);
        $message = 'Пользователь зарегистрирован';
        }
        catch(\Exception $e){
            $message = 'Не вышло зарегистрировать нового пользователя';
            }
        return $message;
    }
    
}

<?php

class Post extends Eloquent {

    protected $fillable = ['title','date','body','position'];

	public static function getAll(){
        $posts = Post::all();
        return $posts;
    }
    
    public static function getThree(){
        $posts = Post:: orderBy('position','desc')->take(3)->get();
        return $posts;
    }
    
    public static function getArchieve(){
        $posts = Post:: orderBy('position','desc')->get();
        $dim = count($posts);
        $archieve = array();
        for ($i=3;$i<$dim;$i++){
            $archieve[] = $posts[$i];
        }
        return $archieve;
    }
    
    /* public static function validateCorrectDate ($attribute, $value){
        Validator::extend('correct_date', function($attribute, $value)
        {
            $month = $value[0];
            $day = $value[1];
            $year = $value[2];
            return checkdate( $month , $day , $year ); 
        }); 
    }       */ 
        
    public static $postValidation = array(
            // Поле "Текст новости" является обязательным
        'postBody'=>'required',
            // Поле "Заголовок новости" является обязательным, должно быть длиной не больше 50 символов
        'postTitle'=>'required|max:50',
            // Поле "Дата" является обязательным, дата должна быть осмысленной
        'postDate'=>'correct_date'
    );
    
    public static $months = array (
                    1 => 'января',
                    2 => 'февраля',
                    3 => 'марта',
                    4 => 'апреля',
                    5 => 'мая',
                    6 => 'июня',
                    7 => 'июля',
                    8 => 'августа',
                    9 => 'сентября',
                    10 => 'октября',
                    11 => 'ноября',
                    12 => 'декабря'
                    );
                    
    public static function delPost($postId)
    {
        $post = Post::where('id','=',$postId)->first(); 
        $message = DB::transaction(function()use(&$post){
                $position = $post->position;
            try{ 
                $post->delete();
                $allposts = Post::where('position','>',$position)->orderBy('position')->get();
                foreach($allposts as $p){
                    $newPos = $p['position']-1;
                    Post::where('id','=',$p['id'])->update(['position'=>$newPos]);
                }; 
                return $message = 'Новость удалена - можно слазать проверить на главной странице сайта;';
                 }
            catch (\Exception $e)
            {return $message = 'Не вышло правильно удалить новость';}
    });
        return $message;
    }
    
    public static function updatePost($postId,$postTitle,$postDate,$postBody)
    {   
        $message=DB::transaction(function()use(&$postId,&$postTitle,&$postDate,&$postBody){
        try{
            Post::where('id','=',$postId)->update(['title'=>$postTitle,'date'=>$postDate,'body'=>$postBody]);
            return $message = 'Новость изменена - можно слазать проверить на главной странице сайта;';
            }
        catch(\Exception $e)
            {return $message = 'Не вышло изменить новость';}
        });
        return $message;
    }
    
    public static function movePost($prev,$postid)
    {
    $message = DB::transaction(function()use(&$prev,&$postid){
        try{
            //$prevpos = $prev+1;
            $post = Post::where('id','=',$postid)->first();
            $oldpos = $post->position;
            if($oldpos > $prev){
                $posts = Post::where('position','<',$oldpos)->where('position','>',($prev-1))->orderBy('position')->get();
                foreach($posts as $p){
                    $newp = $p['position']+1;
                    Post::where('id','=',$p['id'])->update(['position'=>$newp]);
                }
                Post::where('id','=',$postid)->update(['position'=>$prev]);
          }else{
                $posts = Post::where('position','<',$prev)->where('position','>',$oldpos)->orderBy('position')->get();
                foreach($posts as $p){
                    $newp = $p['position']-1;
                    Post::where('id','=',$p['id'])->update(['position'=>$newp]);
                }
            Post::where('id','=',$postid)->update(['position'=>($prev-1)]);
          }
          return $message = 'Новость удачно пододвинули - можно слазать проверить на главной странице сайта';
          //return $message = $oldpos;
        }
        catch(\Exception $e)
            {return $message = 'Не вышло подвинуть новость!!!';}
        });
    return $message;
    }
    
    public static function addPost($prevpos,$postTitle,$postBody,$date)
    {
    $message = DB::transaction(function()use(&$prevpos,&$postTitle,&$postBody,&$date){
        try{
            $posts = Post::where('position','>=',$prevpos)->get();
            foreach($posts as $p)
            {
                $newp = $p['position']+1;
                Post::where('id','=',$p['id'])->update(['position'=>$newp]);
            }
            Post::create([
                'title'=>$postTitle,
                'date'=>$date,
                'body'=>$postBody,
                'position'=>($prevpos)
                ]);
            return $message = 'Новость успешно добавлена - можно слазать проверить на главной странице сайта';
        }
        catch(\Exception $e)
            {return $message = 'Не вышло правильно добавить новость!!!';}
        });
    return $message;
    }
}

<?php

class Category extends Eloquent {

    protected $primaryKey = 'category_id';
    protected $fillable = ['category_id','category','position'];
    
    public function subcategories()
    {
        return $this->hasMany('Subcategory', 'category_id', 'category_id');
    }

    public static function getAll(){
        $categories = Category::with('subcategories')->orderBy('position')->get();
        foreach($categories as $cat){
        $cat['subcategories']->sortBy('position');
        }
        return $categories;
    }
    
    public static function delCat()
    {
        $catId = Input::get('catId');
        $message = DB::transaction(function()use(&$catId){
                //$name = $category->category;
            try{ 
                $category = Category::where('category_id','=',$catId)->firstOrFail(); 
                $position = $category->position;
                $category->delete();
                 $cat = Category::where('position','>',$position)->orderBy('position')->get();
                foreach($cat as $c){
                    $newPos = $c['position']-1;
                    Category::where('category_id','=',$c['category_id'])->update(['position'=>$newPos]);
                }; 
                return $message = 'Категория удалена - можно слазать проверить на странице каталога;';
                 }
            catch (\Exception $e)
            {return $message = 'Не вышло правильно удалить категорию';}
    });
        return $message;
    }
    
    public static $categoryValidation = array(
            // Поле "Новое название" является обязательным и уникальным в таблице "категории"; максимум 20 символов
        'catName'=>'required|unique:categories,category|max:20'
    );
    
    public static function updateCat($data)
    {   
            $new = $data['catName'];
            $id  = $data['id'];
        $message=DB::transaction(function()use(&$new,&$id){
        try{
            Category::where('category_id','=',$id)->update(['category'=>$new]);
            return $message = 'Категория изменена - можно слазать проверить на странице каталога;';
            }
        catch(\Exception $e)
            {return $message = 'Не вышло изменить категорию';}
        });
        return $message;
    }
    
    public static function addCat($data)
    {   
            $newCat = $data['catName'];
            $newPos  = $data['prevpos']+1;
        $message = DB::transaction(function()use(&$newCat,&$newPos){
            try{
            $cat = Category::where('position','>',$_POST['prevpos'])->orderBy('position')->get();
            foreach($cat as $c){
                $newp = $c['position']+1;
                Category::where('category_id','=',$c['category_id'])->update(['position'=>$newp]);
            };
            $category = Category::create(['position'=>$newPos,'category'=>$newCat]); 
            return $message = 'Категория добавлена - можно слазать проверить на странице каталога;';
            }
        catch(\Exception $e)
            {return $message = 'Не вышло добавить категорию!!!';}
        });
        return $message;
    }
    
    public static function moveCat()
    {
    $message = DB::transaction(function(){
        try{
            if($_POST['oldpos']<$_POST['prev']){
                $cat = Category::where('position','>',$_POST['oldpos'])->where('position','<',($_POST['prev']+1))->orderBy('position')->get();
                foreach($cat as $c){
                    $newp = $c['position']-1;
                    Category::where('category_id','=',$c['category_id'])->update(['position'=>$newp]);
                }
                Category::where('category_id','=',$_POST['id'])->update(['position'=>$_POST['prev']]);
          }else{
                $cat = Category::where('position','>',$_POST['prev'])->where('position','<',$_POST['oldpos'])->orderBy('position')->get();
                foreach($cat as $c){
                    $newp = $c['position']+1;
                    Category::where('category_id','=',$c['category_id'])->update(['position'=>$newp]);
                }
            Category::where('category_id','=',$_POST['id'])->update(['position'=>($_POST['prev']+1)]);
          }
          return $message = 'Категорию удачно пододвинули - можно слазать проверить на странице каталога';
        }
        catch(\Exception $e)
            {return $message = 'Не вышло подвинуть категорию!!!';}
        });
    return $message;
    }

}

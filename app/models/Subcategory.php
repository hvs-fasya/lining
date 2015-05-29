<?php
class Subcategory extends Eloquent {

	protected $table = 'subcategories';
    protected $fillable = ['id','category_id','title','position'];
    
    public function category()
    {
        return $this->belongsTo('Category');
    }
    
    public function goods()
    {
        return $this->hasMany('Good','subcat_id');
    }
    
    public static function getAll(){
        $subcategories = Subcategory::with('goods')->get();
        return $subcategories;
    }
        
    public static function getSubcategoryByCategory(){
            $data = Subcategory::orderBy('position')->get();
            $categories = DB::table('categories')->lists('category_id');
            $subcategories = [];
            foreach ($categories as $category){
                $subcategories[$category]=[];
            }
            foreach ($data as $subcategory){
                $id = $subcategory['category_id'];
                $subcategories[$id][]=$subcategory;
                }
            return $subcategories;
        }
        
    public static function delSub(){
                    $id = $_POST['id'];
                    $subcategory = Subcategory::where('id','=',$id)->first();
            $message = DB::transaction(function () use(&$subcategory){
                    $cat = $subcategory->category_id;
                    $pos = $subcategory->position;
                try{
                    $subcategory->delete();
                    $sub = Subcategory::where('category_id','=',$cat)->where('position','>',$pos)->get();
                    foreach($sub as $s){
                        $pos = $s['position']-1;
                        Subcategory::where('id','=',$s['id'])->update(['position'=>$pos]);
                    };
                    return $message = 'Подкатегория удалена; можно слазать проверить на странице каталога;';
                }
                catch (\Exception $e)
                    {return $message = 'Не вышло правильно удалить подкатегорию!!!';}
            });
        return $message;
        }
        
    public static function updateSub(){   
            $new = $_POST['subName'];
            $id  = $_POST['id'];
        if( $sub = Subcategory::where('id','=',$id)->first() ){
            Subcategory::where('id','=',$id)->update(['title'=>$new]);
            $message = 'Подкатегория изменена; можно слазать проверить на странице каталога;';
        }else{$message = 'Не вышло изменить подкатегорию';}
        return $message;
        }
        
    public static function addSub(){
        $message = DB::transaction(function(){
            try{
                $sub = Subcategory::where('category_id','=',$_POST['catid'])->where('position','>',$_POST['prevpos'])->orderBy('position', 'desc')->get();
                foreach($sub as $s){
                    $pos = $s['position']+1;
                    Subcategory::where('id','=',$s['id'])->update(['position'=>$pos]);
                };
                Subcategory::create(['category_id'=>$_POST['catid'],'title'=>$_POST['subName'],'position'=>($_POST['prevpos']+1)]);
                return $message = 'Категория добавлена; можно слазать проверить на странице каталога;';
                }
        catch(\Exception $e)
            {return$message = 'Не вышло добавить категорию!!!';}
        });
        return $message;
        }
        
    public static function setcatSub(){   
            $subId  = $_POST['id'];
            $catId = $_POST['catId'];
            $pos = Subcategory::where('category_id','=',$_POST['catId'])->max('position')+1;
        if( Subcategory::where('id','=',$subId)->update(['category_id'=>$catId,'position'=>$pos]) 
            ){
            $message = 'Категория назначена; можно слазать проверить на странице каталога;';
        }else{$message = 'Не вышло назначить категорию!!!';}
        return $message;
        }
        
    public static function moveSub(){   
            $message = DB::transaction(function () {
            if ($_POST['prevpos']>$_POST['oldpos']){
                try{
                    $sub = Subcategory::where('category_id','=',$_POST['catid'])->where('position','>',$_POST['oldpos'])->where('position','<=',$_POST['prevpos'])->orderBy('position', 'desc')->get();
                    foreach($sub as $s){
                        $pos = $s['position']-1;
                        Subcategory::where('id','=',$s['id'])->update(['position'=>$pos]);
                    };
                    Subcategory::where('id','=',$_POST['id'])->update(['position'=>$_POST['prevpos']]);
                   return $message = 'Подкатегорию подвинули - можно слазать проверить на странице каталога';
                    }
                catch (\Exception $e){
                        return $message = 'Не вышло подвинуть подкатегорию!!!';
                    }
            }else{
                try {
                    $sub = Subcategory::where('category_id','=',$_POST['catid'])->where('position','>',$_POST['prevpos'])->where('position','<',$_POST['oldpos'])->orderBy('position', 'desc')->get();
                    foreach($sub as $s){
                        $pos = $s['position']+1;
                        Subcategory::where('id','=',$s['id'])->update(['position'=>$pos]);
                    };
                    Subcategory::where('id','=',$_POST['id'])->update(['position'=>($_POST['prevpos']+1)]); 
                    return $message = 'Подкатегорию подвинули - можно слазать проверить на странице каталога';
                    }
                catch (\Exception $e){
                    return $message = 'Не вышло подвинуть подкатегорию!!!';
                }
                }
            });
        return $message ;
        }
}
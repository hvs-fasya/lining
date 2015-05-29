<?php

class Good extends Eloquent {

    protected $fillable = ['subcat_id','artikel','description','fullsize', 'goodpreview','price'];
    
    public function technologies()
{
    return $this->belongsToMany('Technology', 'good_technology', 'id_good', 'id_technology');
}

public function subcategory()
{
    return $this->belongsTo('Subcategory');
}

public static $goodValidation = array(
        'goodArtikel'=>'required',
        'goodSub'=>'exists:subcategories,id',
        //'image'=>'image',
        'goodPrice'=>'numeric'
    );
    
    
    public static function getAll(){
        $goods = Good::with('technologies')->get();
        return $goods;
    }
    
	public static function getGoodBySubcat(){
            //$data = Good::all();
            $data = Good::with('technologies')->get();
            $subcats = DB::table('subcategories')->lists('id');
            $goods = [];
            foreach ($subcats as $sub){
                $goods[$sub]=[];
            }
            foreach ($data as $good){
                $subcat = $good['subcat_id'];
                $goods[$subcat][]=$good;
                }
            return $goods;
        }
        
    public static function makePreview($imageName,$dirName,$prH,$prW){
            $previewH = $prH;
            $previewW = $prW;
            $colorDiff = 0xffffff;
            //расчеты размеров
            $size = getimagesize($dirName.'/'.$imageName);
            $ratio = min(($previewW/$size[0]),($previewH/$size[1]));
            $new_width = floor($size[0]*$ratio);
            $new_hight = floor($size[1]*$ratio);
            //-----------------
            $format = strtolower(substr($size['mime'],strpos($size['mime'],'/')+1));
            $createfuncName = 'imagecreatefrom'.$format;
            if(!function_exists($createfuncName)) return false;
            $image = $createfuncName($dirName.'/'.$imageName);
            $imgScaled = imagescale($image,$new_width,$new_hight);
            $techImg  = imagecreatetruecolor($previewH, $previewW);
            imagefill($techImg, 0, 0, $colorDiff);
            $path = public_path().'/img/'.'goods_preview'.'/'.$imageName;
            imagecopyresampled($techImg, $imgScaled, floor(($previewW-$new_width)/2), 0, 0, 0, $new_width, $new_hight, $new_width, $new_hight);
            imagejpeg($techImg,$path);
            imagedestroy($techImg);
            imagedestroy($image);
            imagedestroy($imgScaled);
        return $path;
    }
    
    public static function showPhoto($name,$width)
        {
            $newWidth = $width;
            $colorDiff = 0xffffff;
            //расчеты размеров
            if(!$size = getimagesize(public_path().'/img/goods_full_size/'.$name)){$mes = 'fail2';};
            $ratio = $size[0]/$newWidth;
            $newHeight = $size[1]/$ratio;
            //-----------------
            if($image = imagecreatefromjpeg(public_path().'/img/goods_full_size/'.$name)){
            $message = 'img/goods_full_size/'.$name;
            }else{$message = 'fail';}
            if($imgScaled = imagescale($image,$newWidth,$newHeight)){
            $techImg  = imagecreatetruecolor($newWidth, $newHeight);
            imagefill($techImg, 0, 0, $colorDiff);
            imagecopyresampled($techImg, $imgScaled, 0, 0, 0, 0, $newWidth, $newHeight, $newWidth, $newHeight);
            imagejpeg($techImg,public_path().'/img/gallery/tmpphoto.jpg'); 
            imagedestroy($techImg);
            header('Content-Type: image/jpeg; charset=utf-8');
            imagedestroy($image);
            imagedestroy($imgScaled);}

}
    public static function editGood( $data )
    {   
        $message=DB::transaction(function()use(&$data){
        try{
            if($data['fullsize'] && $data['goodpreview']){
            Good::where('id','=',$data['id'])->update(['subcat_id'=>$data['goodSub'],'artikel'=>$data['goodArtikel'],'description'=>$data['goodDescr'],'fullsize'=>$data['fullsize'],'goodpreview'=>$data['goodpreview'],'price'=>$data['goodPrice']]);
            }else{
            Good::where('id','=',$data['id'])->update(['subcat_id'=>$data['goodSub'],'artikel'=>$data['goodArtikel'],'description'=>$data['goodDescr'],'price'=>$data['goodPrice']]);
            }
            if( isset($data['addTech']) ){
                $tech = Technology::where('id','=',$data['addTech'])->first();
                $tech->goods()->attach([ $data['id'] ]);
            }
            if( isset($data['moveTech']) ){
                $tech = Technology::where('id','=',$data['moveTech'])->first();
                $tech->goods()->detach( [$data['id']] );
            }
            return $message = 'Данные товара изменены - можно слазать проверить на странице каталога;';
             }
        catch(\Exception $e)
            {return $message = 'Не вышло изменить данные товара';}
        });
        return $message;
    }
    
    public static function delGood()
    {
        $goodId = Input::get('goodId');
        $message = DB::transaction(function()use(&$goodId){
            try{ 
                $good = Good::find($goodId);
                $photo_path = $good->fullsize;
                $preview_path = $good->goodpreview;
                DB::table('good_technology')->where('id_good','=',$goodId)->delete();
                $good->delete();
                if( Good::find($goodId) == NULL )
                    {
                    if ( file_exists(public_path().'/'.$photo_path) )
                        {unlink( public_path().'/'.$photo_path );}
                    if ( file_exists(public_path().'/'.$preview_path) )
                        {unlink( public_path().'/'.$preview_path );}
                     }
                return $message = 'Товар удален - можно слазать проверить на странице каталога;';
                 }
            catch (\Exception $e)
            {return $message = 'Не вышло правильно удалить товар';}
    });
        return $message;
    }

    public static function setGoodSub($data)
    {
        $message = DB::transaction(function()use(&$data){
            try{ 
                Good::where( 'id','=',$data['gnullid'] )->update( ['subcat_id'=>$data['gnullsub']] );
                return $message = 'Категория назначена - можно слазать проверить на странице каталога;';
                 }
            catch (\Exception $e)
            {return $message = 'Не вышло правильно назначить категорию';}
    });
        return $message;
    }
    
    public static function addGood( $data )
    {   
        $message=DB::transaction(function()use(&$data){
        try{ 
            $good = new Good;
            $good->subcat_id = $data['goodSub'];
            $good->artikel = $data['goodArtikel'];
            $good->description = $data['goodDescr'];
            $good->price = $data['goodPrice'];
            $good->fullsize = $data['fullsize'];
            $good->goodpreview = $data['goodpreview'];
            $good->save();
            if( isset($data['setTech']) ){
                $good->technologies()->attach($data['setTech']);
            }
            $good->push();
            return $message = 'Товар добавлен - можно слазать проверить на странице каталога;';
               }
        catch(\Exception $e)
            {return $message = 'Не вышло добавить товар';} 
        }); 
        return $message;
    }
    
    }
    
 
<?php

class Technology extends Eloquent {

    protected $fillable = ['name','shortname','description', 'logo'];
    
    public function goods()
{
    return $this->belongsToMany('Good', 'good_technology', 'id_technology', 'id_good');
}

    public static $techValidation = array(
        'techName'=>'required',
        'shortName'=>'required',
        'techDescr'=>'required'
    );

    public static function addTechnology( $data )
    {   
        $message=DB::transaction(function()use(&$data){
        try{ 
            $techno = new Technology;
            $techno->name = $data['techName'];
            $techno->shortname = $data['shortName'];
            $techno->description = $data['techDescr'];
            $techno->logo = $data['logo'];
            $techno->save();
            $insertedId = $techno->id;
            return $message = 'Технология добавлена - можно слазать проверить на странице каталога;';
               }
        catch(\Exception $e)
            {return $message = 'Не вышло добавить технологию';} 
        }); 
        return $message;
    }
    public static function resizeLogo($filename,$widthLogo)
    {
            $colorDiff = 0xffffff;
            //расчеты размеров
            $size = getimagesize('img/technology/'.$filename);
            $ratio = $widthLogo/$size[0];
            $new_hight = floor($size[1]*$ratio);
            $format = strtolower(substr($size['mime'],strpos($size['mime'],'/')+1));
            $createfuncName = 'imagecreatefrom'.$format;
            if(!function_exists($createfuncName)) return false;
            $image = $createfuncName('img/technology/'.$filename);
            $imgScaled = imagescale($image,$widthLogo,$new_hight);
            $techImg  = imagecreatetruecolor( $widthLogo, $new_hight);
            imagefill($techImg, 0, 0, $colorDiff);
            $path = public_path().'/img/'.'technology'.'/'.$filename;
            imagecopyresampled($techImg, $imgScaled, 0, 0, 0, 0, $widthLogo, $new_hight, $widthLogo, $new_hight);
            imagejpeg($techImg,$path);
            imagedestroy($techImg);
            imagedestroy($image);
            imagedestroy($imgScaled);
    }
  
    public static function deleteTech($id)
    {   
        $message=DB::transaction(function()use(&$id){
        try{             
            DB::table('good_technology')->where('id_technology','=',$id)->delete();
            $tech = Technology::find($id);
            $tech->delete();
            return $message = 'Технология удалена - можно слазать проверить на странице каталога;';
               }
        catch(\Exception $e)
            {return $message = 'Не вышло удалить технологию';} 
        }); 
        return $message;
    }
    
    public static function editTechnology($data)
    {   
        $message=DB::transaction(function()use(&$data){
        try{ 
            if($data['logo']){
            Technology::where('id','=',$data['id'])->update(['name'=>$data['techName'],'shortname'=>$data['shortName'],'description'=>$data['techDescr'],'logo'=>$data['logo']]);
            }else{
            Technology::where('id','=',$data['id'])->update(['name'=>$data['techName'],'shortname'=>$data['shortName'],'description'=>$data['techDescr']]);
            }
            return $message = 'Технология изменена - можно слазать проверить на странице каталога;';
               }
        catch(\Exception $e)
            {return $message = 'Не вышло изменить технологию';} 
        }); 
        return $message;
    }
    public static function bindTech($data)
    {   
        $message=DB::transaction(function()use(&$data){
        try{             
            $tech = Technology::find($data['id']);
            $tech->goods()->attach($data['idSet']);
            return $message = 'Технология привязана к товарам - можно слазать проверить на странице каталога;';
               }
        catch(\Exception $e)
            {return $message = 'Не вышло связать технологию и товары';} 
        }); 
        return $message;
    }
}
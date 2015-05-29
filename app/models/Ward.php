<?php

class Ward extends Eloquent {

    protected $fillable = ['name','description','portrait'];


public static $wardValidation = array(
        'wardName'=>'required|max:50|unique:wards,name',
        'wardDescr'=>'required'
        //'image'=>'image'
    );
    
    public static function makePortrait($path,$filename,$width)
    {
        $portraitW = $width;
        $colorDiff = 0xffffff;
        //расчеты размеров
        $size = getimagesize($path);
        $ratio = $portraitW/$size[0];
        $portraitH = floor($size[1]*$ratio);
        //-----------------
        $format = strtolower(substr($size['mime'],strpos($size['mime'],'/')+1));
        $createfuncName = 'imagecreatefrom'.$format;
        if(!function_exists($createfuncName)) return false;
        $image = $createfuncName($path);
        $imgScaled = imagescale($image,$portraitW,$portraitH);
        $techImg  = imagecreatetruecolor($portraitW, $portraitH);
        imagefill($techImg, 0, 0, $colorDiff);
        $new_path = public_path().'/img/portraits/'.$filename;
        imagecopyresampled($techImg, $imgScaled, 0, 0, 0, 0, $portraitW, $portraitH, $portraitW, $portraitH);
        imagejpeg($techImg,$new_path);
        imagedestroy($techImg);
        imagedestroy($image);
        imagedestroy($imgScaled);
        return 'img/portraits/'.$filename;
    }
    public static function newWard( $data )
    {   
        $message=DB::transaction(function()use(&$data){
        try{ 
            $ward = new Ward;
            $ward->name = $data['wardName'];
            $ward->description = $data['wardDescr'];
            $ward->portrait = $data['portrait'];
            $ward->save();
            return $message = 'Воспитанник добавлен - можно слазать проверить на странице "Тренировки";';
               }
        catch(\Exception $e)
            {return $message = 'Не вышло добавить воспитанника';} 
        }); 
        return $message;
    }

    public static function changeWard( $data )
    {   
        $message=DB::transaction(function()use(&$data){
        try{ 
            $ward = Ward::find( $data['wardId'] );
            $ward->name = $data['wardName'];
            $ward->description = $data['wardDescr'];
            if( $data['portrait'] )
                {$ward->portrait = $data['portrait'];}
            $ward->save();
            return $message = 'Данные воспитанника изменены - можно слазать проверить на странице "Тренировки";';
               }
        catch(\Exception $e)
            {return $message = 'Не вышло изменить данные воспитанника';} 
        }); 
        return $message;
    }
    
    public static function deleteWard($id)
    {
        $message = DB::transaction(function()use(&$id){
            try{ 
                $ward = Ward::find($id);
                $ward->delete();
                return $message = 'Информация о воспитаннике удалена - можно слазать проверить на странице "Тренировки";';
                 }
            catch (\Exception $e)
            {return $message = 'Не вышло правильно удалить информацию о воспитаннике';}
    });
        return $message;
    }
    }
    
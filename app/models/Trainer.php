<?php

class Trainer extends Eloquent {

    protected $fillable = ['name','description','portrait'];


public static $trainerValidation = array(
        'trainerName'=>'required|max:50|unique:trainers,name',
        'trainerDescr'=>'required'
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
    public static function newTrainer( $data )
    {   
        $message=DB::transaction(function()use(&$data){
        try{ 
            $trainer = new Trainer;
            $trainer->name = $data['trainerName'];
            $trainer->description = $data['trainerDescr'];
            $trainer->portrait = $data['portrait'];
            $trainer->save();
            //$trainer->push();
            return $message = 'Тренер добавлен - можно слазать проверить на странице "Тренировки";';
               }
        catch(\Exception $e)
            {return $message = 'Не вышло добавить тренера';} 
        }); 
        return $message;
    }

    public static function changeTrainer( $data )
    {   
        $message=DB::transaction(function()use(&$data){
        try{ 
            $trainer = Trainer::find( $data['trainerId'] );
            $trainer->name = $data['trainerName'];
            $trainer->description = $data['trainerDescr'];
            if( $data['portrait'] )
                {$trainer->portrait = $data['portrait'];}
            $trainer->save();
            return $message = 'Данные тренера изменены - можно слазать проверить на странице "Тренировки";';
               }
        catch(\Exception $e)
            {return $message = 'Не вышло изменить данные тренера';} 
        }); 
        return $message;
    }
    
    public static function deleteTrainer($id)
    {
        $message = DB::transaction(function()use(&$id){
            try{ 
                $trainer = Trainer::find($id);
                $trainer->delete();
                return $message = 'Информация о тренере удалена - можно слазать проверить на странице каталога;';
                 }
            catch (\Exception $e)
            {return $message = 'Не вышло правильно удалить информацию о тренере';}
    });
        return $message;
    }
    }
    
 
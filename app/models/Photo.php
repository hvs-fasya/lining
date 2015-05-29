<?php

class Photo extends Eloquent {

        protected $fillable = ['section_id','title','date','photo','preview'];
        
        public function gallerySection()
    {
        return $this->belongsTo('GallerySection','section_id','section_id');
    }
    
        public static function getPhotoBySection(){
            $data = Photo::all();
            $sections = DB::table('gallerySections')->lists('section_id');
            $photos = [];
            foreach ($sections as $section){
                $photos[$section]=[];
            }
            foreach ($data as $photo){
                $id = $photo['section_id'];
                $photos[$id][]=$photo;
                }
            return $photos;
        }
    
        public static function makePreview($imageName,$dirName,$prH,$prW){
            $previewH = $prH;
            $previewW = $prW;
            $colorDiff = 0xffffff;
            //расчеты размеров
            //$size = getimagesize('public/img/gallery/photo/'.$dirName.'/'.$imageName);
            $size = getimagesize( public_path().'/img/gallery/photo/'.$dirName.'/'.$imageName);
            $ratio = min(($previewW/$size[0]),($previewH/$size[1]));
            $new_width = floor($size[0]*$ratio);
            $new_hight = floor($size[1]*$ratio);
            //-----------------
            $format = strtolower(substr($size['mime'],strpos($size['mime'],'/')+1));
            $createfuncName = 'imagecreatefrom'.$format;
            if(!function_exists($createfuncName)) return false;
            $image = $createfuncName( public_path().'/img/gallery/photo/'.$dirName.'/'.$imageName);
            $imgScaled = imagescale($image,$new_width,$new_hight);
            $techImg  = imagecreatetruecolor($previewH, $previewW);
            imagefill($techImg, 0, 0, $colorDiff);
            //path = 'public/img/gallery/preview/'.$dirName.'/'.$imageName;
            $path = public_path().'/img/gallery/preview/'.$dirName.'/'.$imageName;
            /* if (!is_dir('public/img/gallery/preview/'.$dirName)) {    
                mkdir('public/img/gallery/preview/'.$dirName); */
            if (!is_dir(public_path().'/img/gallery/preview/'.$dirName)) {    
                mkdir(public_path().'/img/gallery/preview/'.$dirName);
                }
            imagecopyresampled($techImg, $imgScaled, floor(($previewW-$new_width)/2), 0, 0, 0, $new_width, $new_hight, $new_width, $new_hight);
            imagejpeg($techImg,$path);
            imagedestroy($techImg);
            imagedestroy($image);
            imagedestroy($imgScaled);
        return $path;
    }
    
        public static function showGalleryPhoto($dir,$path,$width)
        {
            $newWidth = $width;
            $colorDiff = 0xffffff;
            //расчеты размеров
            //if(!$size = getimagesize('../public/img/gallery/photo/'.$dir.'/'.$path)){$mes = 'fail2';};
            if(!$size = getimagesize(public_path().'/img/gallery/photo/'.$dir.'/'.$path)){$mes = 'fail2';};
            $ratio = $size[0]/$newWidth;
            $newHeight = $size[1]/$ratio;
            //-----------------
            //if($image = imagecreatefromjpeg('../public/img/gallery/photo/'.$dir.'/'.$path)){
            if($image = imagecreatefromjpeg(public_path().'/img/gallery/photo/'.$dir.'/'.$path)){
            $message = 'img/gallery/photo/'.$dir.'/'.$path;
            }else{$message = 'fail';}
            if($imgScaled = imagescale($image,$newWidth,$newHeight)){
            $techImg  = imagecreatetruecolor($newWidth, $newHeight);
            imagefill($techImg, 0, 0, $colorDiff);
            imagecopyresampled($techImg, $imgScaled, 0, 0, 0, 0, $newWidth, $newHeight, $newWidth, $newHeight);
            //imagejpeg($techImg,'../public/img/gallery/tmpphoto.jpg'); 
            imagejpeg($techImg,public_path().'/img/gallery/tmpphoto.jpg'); 
            imagedestroy($techImg);
            header('Content-Type: image/jpeg; charset=utf-8');
            imagedestroy($image);
            imagedestroy($imgScaled);}

}

        public static function addPhoto($data)
        {$message = DB::transaction(function()use(&$data){
            try{
                $file = $data['photo'];
                $dir = GallerySection::where('section_id',$data['secId'])->pluck('title');
                $path = public_path()."/img/gallery/photo/".$dir."/";
                $name = date("His").($file->getClientOriginalName());
                $file->move( $path,$name );
                Photo::makePreview( $name,$dir,100,100 );
                $preview = "img/gallery/preview/".$dir."/".$name;
                Photo::create(['section_id'=>$data['secId'],'title'=>$file->getClientOriginalName(),'photo'=>"img/gallery/photo/".$dir."/".$name,'preview'=>$preview]);
                return $message = 'Фото добавлено; можно слазать проверить на основном сайте;';
                }
            catch(\Exception $e)
                {return $message = 'Не вышло добавить фото!!!';}
            });
            return $message;
        }
        public static function deletePhoto($id){
        try{
            $photo = Photo::find($id);
            $photo->delete();
            unlink(public_path().'/'.$photo['photo']);
            unlink(public_path().'/'.$photo['preview']);
            return $message = 'Фото удалено; можно слазать проверить на основном сайте;';
            }
        catch (\Exception $e)
            { return $message = 'Не вышло удалить фото!!!'; }
        }
        
}

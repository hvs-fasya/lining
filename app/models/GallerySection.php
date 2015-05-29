<?php
class GallerySection extends Eloquent {

	protected $table = 'gallerySections';
    protected $primaryKey = 'section_id';
    protected $fillable = ['title','description','position'];
    
    public function photos()
    {
        return $this->hasMany('Photo', 'section_id', 'section_id');
    }
    
    public static $sectionValidation = array(
        'folderDescription'=>'required'
    );
    
    public static function getGallerySection(){
        $gallerySection = GallerySection::with('photos')->orderBy('position','desc')->get();
        return $gallerySection;
        
    }
    
    public static function newDir($data){
        $folderDescription = $data['folderDescription'];
        $prevpos = $data['prev'];
        $lastDir = DB::table('gallerySections')->max('title');
        $folderTitle = 'dir'.(explode('dir',$lastDir)[1]+1);
        if ( !file_exists( public_path()."/img/gallery/photo/".$folderTitle ) && !file_exists( public_path()."/img/gallery/preview/".$folderTitle ))
            {
            mkdir( public_path()."/img/gallery/photo/".$folderTitle );
            mkdir( public_path()."/img/gallery/preview/".$folderTitle );
            }
        if( file_exists( public_path()."/img/gallery/photo/".$folderTitle ) &&
            file_exists( public_path()."/img/gallery/preview/".$folderTitle ) &&
            is_dir(public_path()."/img/gallery/photo/".$folderTitle) &&
            is_dir(public_path()."/img/gallery/preview/".$folderTitle) )
           {
                if(!$data['prev']){
                $message = DB::transaction(function()use(&$data,&$folderTitle){
                    try{
                        $newpos = (DB::table('gallerySections')->max('position')) + 1;
                        GallerySection::create(['title'=>$folderTitle,'description'=>$data['folderDescription'],'position'=>$newpos]);
                        return $message = 'Папка добавлена; можно слазать проверить на основном сайте;';
                        }
                catch(\Exception $e)
                    {return $message = 'Не вышло добавить папку!!!';}
                }); 
                }else{
                    $message = DB::transaction(function()use(&$data,&$folderTitle){
                    try{
                    $newpos = $data['prev'];
                    $upsections = GallerySection::where('position','>=',$data['prev'])->orderBy('position','desc')->get();
                    foreach ($upsections as $up){
                        $oldpos = $up->position;
                        $up->position = $oldpos+1;
                        $up->save();
                    }
                    GallerySection::create(['title'=>$folderTitle,'description'=>$data['folderDescription'],'position'=>$newpos]);
                    return $message = 'Папка добавлена; можно слазать проверить на основном сайте;';
                    }
                    catch(\Exception $e)
                        {return $message = "Не вышло добавить папку!!!";}
                    });
                };
                }else{
                $message = "Не вышло добавить папку!!!";
                }
        return $message;
        }
        
        public static function moveDir($data){
            $message = DB::transaction(function()use(&$data){
            if(!$data['prevPos']){
                $prevpos = (DB::table('gallerySections')->max('position'))+1;
                }else{
                $prevpos = $data['prevPos'];
                }
            $folder = GallerySection::find($data['secId']);
            if($folder['position']>$prevpos){
                try{
                    $newpos = $prevpos;
                    $sections = GallerySection::whereBetween('position', [$newpos, ($folder['position']-1)])->get();
                    foreach($sections as $sec){
                        $sec->position = $sec['position']+1;
                        $sec->save();
                    }
                    $folder->position = $newpos;
                    $folder->save();
                    return $message = 'Папку подвинули; можно слазать проверить на основном сайте;';
                   }
                catch(\Exception $e)
                    {return $message = 'Не вышло подвинуть папку!!!';}
            }
            elseif( $folder['position']<$prevpos ){
                try{
                    $newpos = $prevpos-1;
                    $sections = GallerySection::whereBetween('position', [($folder['position']+1),$newpos])->get();
                    foreach($sections as $sec){
                        $sec->position = $sec['position']-1;
                        $sec->save();
                    }
                    $folder->position = $newpos;
                    $folder->save();
                    return $message = 'Папку подвинули; можно слазать проверить на основном сайте;';
                    }
                catch(\Exception $e)
                    {return $message = 'Не вышло подвинуть папку!!!';}
            }
                }); 
        return $message;
        }
        
        public static function changeDir($data){
        $message = DB::transaction(function()use(&$data){
        try{
            $folder = GallerySection::find($data['secId']);
            $folder->description = $data['newDescr'];
            $folder->save();
            return $message = "Название папки изменили; можно слазать проверить на основном сайте;";
            }
        catch(\Exception $e){return $message = "Не вышло изменить название папки!!!";}
        });
        return $message;
        }
        
        public static function deldir($path){
            if (is_dir($path)) {
                $content = scandir($path);
                foreach ($content as $obj) {
                    if ($obj != "." && $obj != "..") {
                    if (filetype($path."/".$obj) == "dir") {
                        rrmdir($path."/".$obj);
                    }
                    else{
                        unlink($path."/".$obj);
                    }
                    }
                }
            reset($content);
            rmdir($path);
            } 
        }
        
        public static function deleteFolder($id){
        try{
            $folder = GallerySection::with('photos')->find($id);
            foreach($folder['photos'] as $photo){
                $photo->delete();
            }
            $path_photo = public_path().'/img/gallery/photo/'.($folder->title);
            $path_preview = public_path().'/img/gallery/preview/'.($folder->title);
            GallerySection::deldir($path_photo);
            GallerySection::deldir($path_preview);
            $folder->delete();
            return $message = "Папка удалена; можно слазать проверить на основном сайте;";
        }
        catch (\Exception $e)
            {return $message = "Не вышло удалить папку!!!";}
        }
}
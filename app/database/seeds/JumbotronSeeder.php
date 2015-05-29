<?php

class JumbotronSeeder extends Seeder {

	
	public function run()
	{
        $path = 'public/img/jumbotron';
        //$imagelist = array_diff(scandir($path),['.','..']);
            $previewH = 450;
            $previewW = 772;
            $size = getimagesize('public/img/jumbotron/'.'show_5.jpg');
            $ratio = $previewH/$size[1];
            $new_width = floor($size[0]*$ratio);
            $new_hight = floor($size[1]*$ratio);
            $image = imagecreatefromjpeg('public/img/jumbotron/'.'show_5.jpg');
            $imgScaled = imagescale($image,$new_width,$new_hight);
            $path = 'public/img/jumbotron/'.'show_5_.JPG';
            imagejpeg($imgScaled,$path);
            imagedestroy($image);
            imagedestroy($imgScaled);
        
            return $path;
    
}
}
<?php


class GallerySectionsSeeder extends Seeder {

  public function run()
  {
      //GallerySection::truncate();
      
      GallerySection::create(['title'      =>'dir3',
                              'position'   => 3,
                              'description'=>'Фото с Первества студентов ВУЗов России (январь 2015)']);
      GallerySection::create(['title'      =>'dir2',
                              'position'   => 2,
                              'description'=>'Папка с фотографиями с тренировки детской группы']);
      GallerySection::create(['title'      => 'dir1',
                              'position'   => 1,
                              'description'=> 'Папка с фотографиями с празднования Нового года']);
      
      
       
      
  }

}
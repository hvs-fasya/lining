<?php

class GoodsSeeder extends Seeder {

   
    public function run()
	{
        //Good::truncate();
        $path = 'public/img/goods_full_size';
        $prevpath = 'public/img/goods_preview';
        $preview1 = Good::makePreview('N7.jpg',$path,80,80);
        $preview2 = Good::makePreview('N9.jpg',$path,80,80);
        $preview3 = Good::makePreview('N36.jpg',$path,80,80);
        $preview4 = Good::makePreview('N90III.jpg',$path,80,80);
        Good::create([
        'subcat_id'=>1,
        'artikel'=>'N7',
        'description'=>'Играет: Чай Юн (Cai Yun)'.PHP_EOL.'Материал: углеродное волокно'.PHP_EOL.'Вес: 85-89 гр'.PHP_EOL.'Длина: 675 мм'.PHP_EOL.'Точка равновесия: 300 мм'.PHP_EOL.'Гибкость: средняя',
        'fullsize'=> 'img/goods_full_size/N7.jpg',
        'goodpreview'=> 'img/goods_preview/N7.jpg',
        'price'=>'70'
            ]);
        Good::create([
            'subcat_id'=>1,
            'artikel'=>'N9',
            'description'=>'Играет: Фу Хайфенг (Fu Haifeng)'.PHP_EOL.'Материал: углеродное волокно'.PHP_EOL.'Вес: 85-89 гр'.PHP_EOL.'Длина: 675 мм'.PHP_EOL.'Точка равновесия: 295 мм'.PHP_EOL.'Гибкость: средняя',
            'fullsize'=> 'img/goods_full_size/N9.jpg',
            'goodpreview'=> 'img/goods_preview/N9.jpg',
            'price'=>'90'
            ]);
        Good::create([
            'subcat_id'=>1,
            'artikel'=>'N36',
            'description'=>'Играет: Понсана Бунсак (Ponsana Boonsak)'.PHP_EOL.'Материал: углеродное волокно'.PHP_EOL.'Вес: 85-89 гр'.PHP_EOL.'Длина: 675 мм'.PHP_EOL.'Точка равновесия: 300 мм'.PHP_EOL.'Гибкость: средняя',
            'fullsize'=> 'img/goods_full_size/N36.jpg',
            'goodpreview'=> 'img/goods_preview/N36.jpg',
            'price'=>'75'
            ]);
        Good::create([
            'subcat_id'=>1,
            'artikel'=>'N90III',
            'description'=>'Играет: Лин Дан (Lin Dan)'.PHP_EOL.'Материал: углеродное волокно'.PHP_EOL.'Вес: 85-89 гр'.PHP_EOL.'Длина: 675 мм'.PHP_EOL.'Точка равновесия: 302 мм'.PHP_EOL.'Гибкость: средняя',
            'fullsize'=> 'img/goods_full_size/N90III.jpg',
            'goodpreview'=> 'img/goods_preview/N90III.jpg',
            'price'=>'110'
            ]);
		// $this->call('UserTableSeeder');
	}

}

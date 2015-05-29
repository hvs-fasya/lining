<?php

class TrainingController extends BaseController {

	public function getTraining()
	{
        $branches = [
                    'child'=>'Дети',
                    'individual'=>'Индивидуальные тренировки',
                    'grownup'=>'Взрослые',
                    'shedule'=>'Расписание',
                    'price'=>'Цены',
                    //'li-ning'=>'Li-ning'
                    ];
        $titles = [];
        $bodies = [];
        foreach ($branches as $key=>$value)
            {
            try{
                $content = File::get(storage_path().'/texts/'.$key.'.txt');
                preg_match('#<h4>(.*?)</h4>#si',$content,$cont);
                $titles[$key] = $cont[1];
            }catch(\Exception $e){
                $titles[$key] = 'Здесь должен быть заголовок - когда кто-нибудь напишет, будет';
            }
            try{
                $content = File::get(storage_path().'/texts/'.$key.'.txt');
                preg_match('#<p>(.*?)</p>#si',$content,$cont);
                if( !$cont[1]=='' )
                { $bodies[$key] = $cont[1]; }
                else { $bodies[$key] = 'Здесь должен быть текст - когда кто-нибудь напишет, будет'; }
            }catch(\Exception $e){
                $bodies[$key] = 'Здесь должен быть текст - когда кто-нибудь напишет, будет';
            }
            }
        $trainers = Trainer::all();
        $wards = Ward::all();
		return View::make('training')->with(['branches'=>$branches,'titles'=>$titles,'bodies'=>$bodies,'trainers'=>$trainers,'wards'=>$wards]);
	}

}
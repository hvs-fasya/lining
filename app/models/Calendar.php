<?php

class Calendar extends Eloquent {

    public static function getAll(){
        $calendar = Calendar::all();
        return $calendar;
    }

	public static function getAllOrdered(){
        $data = Calendar::getAll();
        $calendar =[];
        foreach($data as $cal){
            $k = strtotime($cal['date']);
            $calendar[$k]=$cal;
        }
        ksort($calendar);
        return $calendar;
    }


}

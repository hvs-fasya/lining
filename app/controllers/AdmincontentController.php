<?php

class AdmincontentController extends BaseController {

    public function editPosts($message=null)
	{
		$posts = Post:: orderBy('position','desc')->get();
        $msg = $message;
        return View::make('adminposts')->with(['posts'=>$posts,'message'=>$msg]);
	}
    public function deletePost()
    {
        $postId = Input::get('postId');
        $message = Post::delPost($postId);
        Session::flash('message', $message);
        return Redirect::action('AdmincontentController@editPosts');
    }
    public function updatePost()
    {
        $data = Input::all();
        $postId = Input::get('id');
        $postTitle = $data[$postId]['postTitle'];
        $postBody = $data[$postId]['postBody'];
        $monthArr = Post::$months;
        $postDate = [array_search( $data[$postId]['postdateMonth'], $monthArr ),$data[$postId]['postdateDay'],$data[$postId]['postdateYear']];
        $postDateString = $data[$postId]['postdateDay'].'-'.$data[$postId]['postdateMonth'].'-'.$data[$postId]['postdateYear'];
        $inputArray = ['postTitle'=>$postTitle,'postBody'=>$postBody,'postDate'=>$postDate];
        $rules = Post::$postValidation;
        $pValidator = Validator::make($inputArray,$rules);
        if($pValidator->fails()){
            $messages = $pValidator->messages();
            $messages->toArray();
            Session::flash('opentab', $postId);
            return Redirect::back()->withErrors($pValidator)->withInput();
        }
        $message = Post::updatePost($postId,$postTitle,$postDateString,$postBody);
        Session::flash('message', $message);
        return Redirect::action('AdmincontentController@editPosts');
    }
    public function movePost()
    {
        $prev = Input::get('prev');
        $postid = Input::get('id');
        $message = Post::movePost($prev,$postid);
        Session::flash('message', $message);
        return Redirect::action('AdmincontentController@editPosts');
    }
    public function addPost()
    {
        $data = Input::all();
        $postTitle = Input::get('postTitle');
        $postBody = Input::get('postBody');
        $monthArr = Post::$months;
        $postDate = [array_search( $data['postdateMonth'], $monthArr ),$data['postdateDay'],$data['postdateYear']];
        $inputArray = ['postTitle'=>$postTitle,'postBody'=>$postBody,'postDate'=>$postDate];
        $rules = Post::$postValidation;
        $pValidator = Validator::make($inputArray,$rules);
        if($pValidator->fails()){
            $messages = $pValidator->messages();
            $messages->toArray();
            Session::flash('opentab', 'addpost');
            return Redirect::back()->withErrors($pValidator)->withInput();
        }
        $prevpos = Input::get('prevpos');
        $postDateString = Input::get('postdateDay').'-'.Input::get('postdateMonth').'-'.Input::get('postdateYear');
        $message = Post::addPost($prevpos,$postTitle,$postBody,$postDateString);
        Session::flash('message', $message);
        return Redirect::action('AdmincontentController@editPosts');
    }
    
    public function editTexts()
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
        try{
                $content = File::get(storage_path().'/texts/'.'lining.txt');
                preg_match('#<h4>(.*?)</h4>#si',$content,$cont);
                $liningTitle = $cont[1];
            }catch(\Exception $e){
                $liningTitle = 'Здесь должен быть заголовок - когда кто-нибудь напишет, будет';
            }
            try{
                $content = File::get(storage_path().'/texts/'.'lining.txt');
                preg_match('#<p>(.*?)</p>#si',$content,$cont);
                if( !$cont[1]=='' )
                { $liningBody = $cont[1]; }
                else { $liningBody = 'Здесь должен быть текст - когда кто-нибудь напишет, будет'; }
            }catch(\Exception $e){
                $liningBody = 'Здесь должен быть текст - когда кто-нибудь напишет, будет';
            }
        return View::make('admintexts')->with(['branches'=>$branches,'titles'=>$titles,'bodies'=>$bodies,'liningTitle'=>$liningTitle,'liningBody'=>$liningBody]);
	}
    
    public function updateTexts()
    {
        $data = Input::all();
        $textId = $data['textId'];
        $textTitle = $data[$textId.'Title'];
        $textBody = $data[$textId.'Body'];
        $message = '';
        try{
            $content = File::get(storage_path().'/texts/'.$textId.'.txt');
            $pattern = "~<p>(.*?)</p>~si";
            $replacement = '<p>'.$textBody.'</p>';
            if( preg_match($pattern,$content) ){
                $cont = preg_replace($pattern, $replacement, $content);
                File::put(storage_path().'/texts/'.$textId.'.txt',$cont);
            }else{
                File::append(storage_path().'/texts/'.$textId.'.txt',$replacement);
            }
                $message = $message.'Текст поменяли.</br>';
            }
        catch(\Exception $e){
            $message = $message.'Не вышло изменить текст.</br>';
            Session::flash('message', $message);
            Redirect::back()->withInput();
            }
        try{
            $content = File::get(storage_path().'/texts/'.$textId.'.txt');
            $pattern = "~<h4>(.*?)</h4>~si";
            $replacement = '<h4>'.$textTitle.'</h4>';
            if( preg_match($pattern,$content) ){
                $cont = preg_replace($pattern, $replacement, $content);
                File::put(storage_path().'/texts/'.$textId.'.txt',$cont);
            }else{
                File::append(storage_path().'/texts/'.$textId.'.txt',$replacement);
            }
                $message = $message.'Заголовок поменяли.</br>';
            }
        catch(\Exception $e){
            $message = $message.'Не вышло изменить заголовок.</br>';
            Session::flash('message', $message);
            Redirect::back()->withInput();
            }
        Session::flash('message', $message);
        return Redirect::action('AdmincontentController@editTexts');
        //return '<pre>'.print_r($data,true).'</pre>';
    }
    public function editTrainers()
	{
		//return 'Редактирование раздела "Тренеры"';
        $trainers = Trainer::all();
        return View::make('admintrainers')->with(['trainers'=>$trainers]);
	}
    
    public function editWards()
	{
		//return 'Редактирование раздела "Наша гордость"';
        $wards = Ward::all();
        return View::make('adminwards')->with(['wards'=>$wards]);
	}
    public function addTrainer()
    {
        $data = Input::all();
        $out = $data;
        $rules = Trainer::$trainerValidation;
        $trainerValidator = Validator::make($data,$rules);
        if($trainerValidator->fails()){
           $messages = $trainerValidator->messages();
           $messages->toArray();
           Session::flash('opentab', 'addTrainer');
           return Redirect::back()->withErrors($trainerValidator)->withInput();
        }
        if ( $file = $data['trainerImage'] ) {
            $rules = [];
            $rules = ['trainerImage'=>'image'];
            $imageValidator = Validator::make(['trainerImage'=>$file],$rules);
            if($imageValidator->fails()){
               $messages = $imageValidator->messages();
               $messages->toArray();
               return Redirect::back()->withErrors($imageValidator)->withInput();
            }else{
            $format = $file->getClientOriginalExtension();
            //$filename = str_replace(' ','_',$data['trainerName']).'.'.$format;
            $filename = 'trainer'.time().'.'.$format;
            $path = $file->getRealPath();
            if( $portrait = Trainer::makePortrait($path,$filename,400) ){
                $out['portrait'] = $portrait;
            }
            }
        }else{
            $out['portrait']= '';
        }
        $message = Trainer::newTrainer($out);
        Session::flash('message', $message);
        return Redirect::action('AdmincontentController@editTrainers');
    }
    
    public function updateTrainer()
    {
        $data = Input::all();
        $trainerId = explode('_',array_keys($data)[1])[1];
        $trainerName = $data['trainerName_'.$trainerId];
        $trainerDescr = $data['trainerDescr_'.$trainerId];
        $out = ['trainerId'=>$trainerId,'trainerName'=>$trainerName,'trainerDescr'=>$trainerDescr];
        $rules = Trainer::$trainerValidation;
        $rules['trainerName'] = 'required|max:50';
        $trainerValidator = Validator::make($out,$rules);
        if($trainerValidator->fails()){
           $messages = $trainerValidator->messages();
           $messages->toArray();
           Session::flash('opentab', 'update'.$trainerId);
           return Redirect::back()->withErrors($trainerValidator)->withInput();
        }
        if( Input::hasFile('trainerImage_'.$trainerId) ){
            $out['trainerImage'] = $data['trainerImage_'.$trainerId];
            $file = $out['trainerImage'];
            $rules = [];
            $rules = ['trainerImage'=>'image'];
            $imageValidator = Validator::make(['trainerImage'=>$file],$rules);
            if($imageValidator->fails()){
               $messages = $imageValidator->messages();
               $messages->toArray();
               Session::flash('opentab', 'update'.$trainerId);
               return Redirect::back()->withErrors($imageValidator)->withInput();
            }else{
            $format = $file->getClientOriginalExtension();
            $filename = 'trainer'.time().'.'.$format;
            $path = $file->getRealPath();
            if( $portrait = Trainer::makePortrait($path,$filename,400) ){
                $out['portrait'] = $portrait;
            }
            }
        }else{
            $out['portrait']= '';
        }
        $message = Trainer::changeTrainer($out);
        Session::flash('message', $message);
        return Redirect::action('AdmincontentController@editTrainers');
        //return '<pre>'.print_r($out,true).'</pre>';
    }
    
    public function delTrainer()
	{
        $data = Input::all();
        $trainerId = $data[array_keys($data)[1]];
        $message = Trainer::deleteTrainer($trainerId);
        Session::flash('message', $message);
        return Redirect::action('AdmincontentController@editTrainers');
        //return '<pre>'.print_r($trainerId ,true).'</pre>';
	}
    
    public function addWard()
    {
        $data = Input::all();
        $out = $data;
        $rules = Ward::$wardValidation;
        $wardValidator = Validator::make($data,$rules);
        if($wardValidator->fails()){
           $messages = $wardValidator->messages();
           $messages->toArray();
           Session::flash('opentab', 'addWard');
           return Redirect::back()->withErrors($wardValidator)->withInput();
        }
        if ( $file = $data['wardImage'] ) {
            $rules = [];
            $rules = ['wardImage'=>'image'];
            $imageValidator = Validator::make(['wardImage'=>$file],$rules);
            if($imageValidator->fails()){
               $messages = $imageValidator->messages();
               $messages->toArray();
               return Redirect::back()->withErrors($imageValidator)->withInput();
            }else{
            $format = $file->getClientOriginalExtension();
            $filename = 'ward'.time().'.'.$format;
            $path = $file->getRealPath();
            if( $portrait = Ward::makePortrait($path,$filename,200) ){
                $out['portrait'] = $portrait;
            }
            }
        }else{
            $out['portrait']= '';
        }
        $message = Ward::newWard($out);
        Session::flash('message', $message);
        return Redirect::action('AdmincontentController@editWards');
    }
    public function delWard()
	{
        $data = Input::all();
        $wardId = $data[array_keys($data)[1]];
        $message = Ward::deleteWard($wardId);
        Session::flash('message', $message);
        return Redirect::action('AdmincontentController@editWards');
	}
    
    public function updateWard()
    {
        $data = Input::all();
        $wardId = explode('_',array_keys($data)[1])[1];
        $wardName = $data['wardName_'.$wardId];
        $wardDescr = $data['wardDescr_'.$wardId];
        $out = ['wardId'=>$wardId,'wardName'=>$wardName,'wardDescr'=>$wardDescr];
        $rules = Ward::$wardValidation;
        $rules['wardName'] = 'required|max:50';
        $wardValidator = Validator::make($out,$rules);
        if($wardValidator->fails()){
           $messages = $wardValidator->messages();
           $messages->toArray();
           Session::flash('opentab', 'update'.$wardId);
           return Redirect::back()->withErrors($wardValidator)->withInput();
        }
        if( Input::hasFile('wardImage_'.$wardId) ){
            $out['wardImage'] = $data['wardImage_'.$wardId];
            $file = $out['wardImage'];
            $rules = [];
            $rules = ['wardImage'=>'image'];
            $imageValidator = Validator::make(['wardImage'=>$file],$rules);
            if($imageValidator->fails()){
               $messages = $imageValidator->messages();
               $messages->toArray();
               Session::flash('opentab', 'update'.$wardId);
               return Redirect::back()->withErrors($imageValidator)->withInput();
            }else{
            $format = $file->getClientOriginalExtension();
            $filename = 'ward'.time().'.'.$format;
            $path = $file->getRealPath();
            if( $portrait = Ward::makePortrait($path,$filename,400) ){
                $out['portrait'] = $portrait;
            }
            }
        }else{
            $out['portrait']= '';
        }
        $message = Ward::changeWard($out);
        Session::flash('message', $message);
        return Redirect::action('AdmincontentController@editWards');
    }
}
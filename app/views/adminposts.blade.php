@extends('template.admintemplate')

@section('content')
{{HTML::script('js/admin_posts_message.js')}}

@if(Session::has('opentab'))
     <p id='opentab' class ='hidden'>{{Session::get('opentab')}}</p>
@endif


<?php
    if(!function_exists('parse_date')){
        function parse_date($date){
            return explode('-',$date);
        }
    }
    $cdate = parse_date(date('d-n-Y'));
    switch ($cdate[1]) {
    case '1': $cdate[1] = 'января'; break;
    case '2': $cdate[1] = 'февраля'; break;
    case '3': $cdate[1] = 'марта'; break;
    case '4': $cdate[1] = 'апреля'; break;
    case '5': $cdate[1] = 'мая'; break;
    case '6': $cdate[1] = 'июня'; break;
    case '7': $cdate[1] = 'июля'; break;
    case '8': $cdate[1] = 'августа'; break;
    case '9': $cdate[1] = 'сентября'; break;
    case '10': $cdate[1] = 'октября'; break;
    case '11': $cdate[1] = 'ноября'; break;
    case '12': $cdate[1] = 'декабря'; break;
    default: $cdate[1] = 'января';
  }
  $curdate = $cdate[0].'-'.$cdate[1].'-'.$cdate[2];
?>
<hr/>
<hr/>
<div>
<a role="button" class='btn btn-link' data-toggle="collapse" href="#addPost"><strong>Добавить новость</strong></a>
     <div class="collapse" id="addPost">
        {{ Form::open(['url' => "/admin/posts/addpost" ]) }}
        <hr/>
        {{ Form::label('postTitle', 'Заголовок') }}</br>
        {{ Form::textarea('postTitle', 'Здесь пишем ручками текст заголовка', array('rows'=>'2')) }}</br>
        
        {{ Form::label('dateinput', 'Дата' ) }}
    <div id="dateinput" class="form-group">
        {{ Form::label('postdateDay', 'Число', array('class'=>'sr-only') ) }}
        {{ Form::text('postdateDay',parse_date($curdate)[0],array('class'=>'col-lg-1 col-md-1 col-sm-1 col-xs-2'))}}
        {{ Form::label('postdateMonth', 'Месяц', array('class'=>'sr-only') ) }}
        {{ Form::text('postdateMonth',parse_date($curdate)[1],array('class'=>'col-lg-1 col-md-2 col-sm-3 col-xs-6'))}}
        {{ Form::label('postdateYear', 'Месяц', array('class'=>'sr-only') ) }}
        {{ Form::text('postdateYear',parse_date($curdate)[2],array('class'=>'col-lg-1 col-md-1 col-sm-2 col-xs-4'))}}</br>
    </div>    
        {{ Form::label('postBody', 'Текст') }}</br>
        {{ Form::textarea('postBody','Здесь пишем ручками текст новости')}}</br>
        {{ Form::label('prevpos', 'Вставить раньше новости:') }}</br>
        <?php 
        if(isset($posts)&&!empty($posts)){
            $selector = [];
            $selector[count($posts)+1] = 'Поставить последней';
            foreach ($posts as $p){
                $selector[$p['position']]=$p['date']." : ".$p['title'];
            }}
        else{$selector = [];
            $selector[1] = 'Поставить в начало';}
        ?>
        {{Form::select('prevpos', $selector)}}</br></br>
        {{Form::submit('Добавить') }} 
        {{Form::close()}}
        <hr/>
    </div>
</div>


    
@if(isset($posts)&&!empty($posts))

<h4>Все новости</h4>

<ul>
    @foreach ($posts as $post)
<li>
{{$post['date']}}---{{$post['title']}}
        {{ Form::open(['url' => "/admin/posts/deletepost" ]) }}
        {{ Form::hidden('postId', $post['id']) }}
     <a>{{ Form::submit('Удалить', array('class'=>'btn btn-link btn-sm', 'role'=>'button')) }}</a>
        {{Form::close()}}

<a role="button" class="btn btn-link btn-sm" data-toggle="collapse" href="#updatePost{{$post['id']}}">Изменить</a>
    <div class="collapse" id="updatePost{{$post['id']}}">
        
        {{ Form::open(['url' => "/admin/posts/updatepost" ]) }}
        <hr/>
        {{ Form::label( $post['id'].'[postTitle]', 'Новый заголовок') }}</br>
        {{ Form::textarea( $post['id'].'[postTitle]', $post['title'],array('rows'=>'2')) }}</br>
        
        {{ Form::label( $post['id'].'[dateinput]', 'Дата' ) }}
    <div id="dateinput" class="form-group">
        {{ Form::label( $post['id'].'[postdateDay]', 'Число', array('class'=>'sr-only') ) }}
        {{ Form::text( $post['id'].'[postdateDay]',parse_date($post['date'])[0],array('class'=>'col-lg-1 col-md-1 col-sm-1 col-xs-2'))}}
        {{ Form::label( $post['id'].'[postdateMonth]', 'Месяц', array('class'=>'sr-only') ) }}
        {{ Form::text( $post['id'].'[postdateMonth]',parse_date($post['date'])[1],array('class'=>'col-lg-1 col-md-2 col-sm-3 col-xs-6'))}}
        {{ Form::label( $post['id'].'[postdateYear]', 'Месяц', array('class'=>'sr-only') ) }}
        {{ Form::text( $post['id'].'[postdateYear]',parse_date($post['date'])[2],array('class'=>'col-lg-1 col-md-1 col-sm-2 col-xs-4'))}}</br>
    </div>    
        {{ Form::label( $post['id'].'[postBody]', 'Текст') }}</br>
        {{ Form::textarea( $post['id'].'[postBody]',$post['body'], array('rows'=>'10'))}}</br>
        {{ Form::hidden( 'id', $post['id']) }}
        {{ Form::submit('ОК') }} 
        {{ Form::close()}}
        <hr/>
    </div>
    <a role="button" class="btn btn-link btn-sm" data-toggle="collapse" href="#movePost{{$post['id']}}">Изменить позицию на странице сайта</a>
            <div class="collapse" id="movePost{{$post['id']}}">
                <hr/>
                {{ Form::open(['url' => "/admin/posts/movepost" ]) }}
                {{ Form::label('prev', 'Поставить раньше новости:') }}</br>
                <?php 
                    $selector = [];
                    $selector[count($posts)+1] = 'Поставить в начало';
                    foreach ($posts as $p){
                        if($p!=$post)
                       $selector[$p['position']]=$p['date']." : ".$p['title'];
                    }
                ?>
                {{Form::select('prev', $selector, $selector[count($posts)+1])}}
                {{ Form::hidden('id', $post['id']) }}
                {{Form::submit('ОК') }} 
                {{Form::close()}}
                <hr/>
            </div>
</li>
    @endforeach
</ul>
@else
    <p>Нет ни одной новости</p>
@endif



@endsection
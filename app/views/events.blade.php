@extends('template.template')

@section('subnav')
<?php

$classHome = '';
$classTrain = '';
$classEvent = 'active';
$classLiNing = '';

$nav='events';
if (isset($_GET['subnav'])){
$subnav = trim(strip_tags($_GET['subnav']),"'");
}
else{
$subnav='lining';
}
?>
@endsection

@section('content')
<!--navbar events page-->
<div class="navbar navbar-default hidden-xs">
<ul class="nav nav-tabs">
  
  <?php ($subnav == 'calendar') ? $class = 'active' : $class = ''?>
  <!--<li class="{{$class}}">
  <a aria-expanded="false" href="#calendar" data-toggle="tab">Календарь</a></li>-->
  
  <?php ($subnav == 'archieve') ? $class = 'active' : $class = ''?>
  <li class="{{$class}}">
  <a aria-expanded="false" href="#archieve" data-toggle="tab">Архив новостей</a></li>
  
  <?php ($subnav == 'gallery') ? $class = 'active' : $class = ''?>
  <li class="{{$class}}">
  <a aria-expanded="false" href="#gallery" data-toggle="tab">Галерея</a></li>
  
  <?php ($subnav == 'lining') ? $class = 'active' : $class = ''?>
  <li class="{{$class}}">
  <a aria-expanded="false" href="#li-ning" data-toggle="tab"><b>Li-ning</b></a></li>
  
</ul>
</div>
<!--End navbar events page-->

<!--TabContent-->
<div class="row">
<div id="TabContent" class="tab-content col-lg-8 col-md-8">
  
  <!--<div class="tab-pane fade" id="calendar">
    @if(isset($calendar)&&!empty($calendar))
        @foreach($calendar as $cal)
            <h6>{{$cal['date']}}</h6>
            <a class="btn btn-link" data-toggle="collapse" href="#cal{{$cal['id']}}" aria-expanded="false" aria-controls="{{$cal['id']}}"><p>{{$cal['title']}}</p></a>
            <div class="collapse" id="cal{{$cal['id']}}">
            <p class="well">{{$cal['body']}}</p>
            <hr>
            </div>
        @endforeach
    @else <p>Нет событий календаря</p>
    @endif
  </div>-->
  
  <div class="tab-pane fade" id="archieve">
    <a class="pull-right hidden-xs" href="index.php?subnav=news">Вернуться в раздел "Новости"</a>
    @if (isset($archieve)&&!empty($archieve))
        @foreach ($archieve as $post)
            <h6>{{$post['date']}}</h6>
            <h6>{{$post['title']}}</h6>
            <a class="btn btn-link" data-toggle="collapse" href="#post{{$post['id']}}" aria-expanded="false" aria-controls="{{$post['id']}}">Показать</a>
            <div class="collapse" id="post{{$post['id']}}">
              <div class="well">{{$post['body']}}</div>
            <hr>
            </div>
        @endforeach 
    @else <p>Архив новостей пуст</p>
    @endif
  </div>
  
  <div class="tab-pane fade" id="gallery">
    @if (isset($gallerySection)&&count($gallerySection))
        @foreach ($gallerySection as $section)
            <a data-toggle="collapse" href="#sec{{$section['section_id']}}" aria-expanded="false" aria-controls="sec{{$section['section_id']}}"><h5>{{$section['description']}}</h5></a>
            <hr>
            <div class="collapse" id="sec{{$section['section_id']}}">
            @if(isset($section['photos'])&&count($section['photos']))
                @foreach ($section['photos'] as $photo)
                <a href="#photoModal" role="button" class="btn btn-link" data-toggle="modal" data-whatever="{{$photo['photo']}}"><img class="photo" src="{{$photo['preview']}}" alt="{{$photo['preview']}}" /></a>
                @endforeach
    <div class="clear"></div>
            <hr>
                <p><a href="#">Скачать все фото</a></p>
            @else
                <span>Папка пуста</span>
            @endif
            </div>
            <hr>
        @endforeach
    @else 
        <p>нет фото</p>
    @endif
    </div>
    
                        <!--<p><img src="{{$photo['photo']}}" alt="{{$photo['photo']}}" /></p>-->
    <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-body">
                        <img src="" alt="photo" />
                        <p></p>
                    </div>
                    
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                    </div>
                    </div>
                    </div>
                </div>
  
  <div class="tab-pane fade" id="li-ning">
    <!--<h4>LI-NING - супер товары для бадминтона</h4>
    <p>Здесь текст про Li-Ning и бла-бла-бла...Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.
  </p>-->
  {{File::get(storage_path().'/texts/lining.txt')}}
    <a class="pull-right" href="catalog.php">Посмотреть каталог</a>
  </div>
</div>
</div>
<!--End TabContent-->
@endsection
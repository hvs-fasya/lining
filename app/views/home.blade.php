@extends('template.template')

@section('subnav')
<?php 
$classHome = 'active';
$classTrain = '';
$classEvent = '';
$classLiNing = '';

$nav='home';
if (isset($_GET['subnav'])){
$subnav = trim(strip_tags($_GET['subnav']),"'");
}else{
$subnav='news';
}
?>
@endsection

@section('content')
<!--navbar home page-->
<div class="navbar navbar-default">
<ul class="nav nav-tabs">
  <?php ($subnav == 'news') ? $class = 'active' : $class = ''?>
  <li class="<?= $class?>">
    <a aria-expanded="true" href="#news" data-toggle="tab">Новости</a></li>
  <?php ($subnav == 'contacts') ? $class = 'active' : $class = ''?>
  <li class="<?= $class?>">
  <a aria-expanded="false" href="#contacts" data-toggle="tab">Контакты</a></li>
  <?php ($subnav == 'lining') ? $class = 'active' : $class = ''?>
  <li class="<?= $class?>">
  <a aria-expanded="false" href="#li-ning" data-toggle="tab"><b>Li-ning</b></a></li>
</ul>
</div>
<!--End navbar home page-->

<!--TabContent-->
<div class="row">
<div id="TabContent" class="tab-content col-lg-8 col-md-8">
 <div class="tab-pane fade" id="news">
    <a class="pull-right hidden-md hidden-sm hidden-xs" href="events.php?subnav=archieve">Перейти к архиву новостей</a>
    
    @if (isset($posts)&&!empty($posts))
        @foreach ($posts as $post)
            <h6>{{$post['title']}}</h6>
            <h6>{{$post['date']}}</h6>
            <p class='wrapp'>{{$post['body']}}</p>
        @endforeach
    @else <p>нет записей</p>
    @endif
    
  </div>
  <div class="tab-pane fade" id="contacts">
    <h5>Адрес зала</h5>
    <p>Мытищи, 1-я Институтская ул., д.1</p>
    <h5>Телефоны</h5>
    <p>+7 (965) 3040124</p>
    <h5>E-mail</h5>
    <p>tamara-migalina@yandex.ru</p>
  </div>
  <div class="tab-pane fade" id="li-ning">
    <!--<h5>LI-NING - супер товары для бадминтона</h5>
    <p><b>Здесь текст про Li-Ning и бла-бла-бла...</b> Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.
  </p>-->
  {{File::get(storage_path().'/texts/lining.txt')}}
    <a class="pull-right" href="catalog.php">Посмотреть каталог</a>
  </div>
</div>
</div>
<!--End TabContent-->
@endsection

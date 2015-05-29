@extends('template.template')

@section('subnav')
<?php
$classHome = '';
$classTrain = 'active';
$classEvent = '';
$classLiNing = '';

$nav='training';
if (isset($_GET['subnav'])){
$subnav = trim(strip_tags($_GET['subnav']),"'");
}
else{
$subnav='lining';
}
?>
@endsection

@section('content')
<!--navbar home page-->
                    
<div class="navbar navbar-default hidden-xs">
<ul class="nav nav-tabs">
  
  <?php ($subnav == 'trainers') ? $class = 'active' : $class = ''?>
  <li class="{{$class}}">
  <a aria-expanded="false" href="#trainers" data-toggle="tab">Тренеры</a></li>
  
  <?php ($subnav == 'ward') ? $class = 'active' : $class = ''?>
  <li class="{{$class}}">
  <a aria-expanded="false" href="#ward" data-toggle="tab">Наша гордость</a></li>
  
  @if(isset($branches))
  @foreach($branches as $key=>$value)
      <?php ($subnav == $key) ? $class = 'active' : $class = ''?>
      <li class="{{$class}}">
      <a aria-expanded="false" href="#{{$key}}" data-toggle="tab">{{$value}}</a></li>
  @endforeach
  @endif
  
  <?php ($subnav == 'lining') ? $class = 'active' : $class = ''?>
  <li class="{{$class}}">
  <a aria-expanded="false" href="#li-ning" data-toggle="tab"><b>Li-ning</b></a></li>
</ul>
</div>
<!--End navbar home page-->

<!--TabContent-->
<div class="row">
<div id="TabContent" class="tab-content col-lg-8 col-md-8">
  
  <div class="tab-pane fade" id="trainers">
        @if (isset($trainers)&&count($trainers))
        <h4>Тренировки проводят</h4>
        <hr/>
        @foreach($trainers as $trainer)
            <p class="col-lg-4 col-md-4 col-sm-4 hidden-xs"><img src="{{$trainer['portrait']}}"></img></p>
            <div class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-4 col-md-offset-4 col-sm-offset-4">
                <h6>{{$trainer['name']}}</h6>
                <span class="wrapp">{{$trainer['description']}}</span>
            </div>
            <div class="clear"></div>
        @endforeach
        @else
        <p>Нет информации</p>
        @endif
  </div>
  
  <div class="tab-pane fade" id="ward">
        @if (isset($wards)&&count($wards))
        <hr/>
        <h4>Наши воспитанники:</h4>
        <hr/>
        @foreach($wards as $ward)
            <p class="col-lg-4 col-md-4 col-sm-4"><img src="{{$ward['portrait']}}"></img></p>
            <div class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-4 col-md-offset-4 col-sm-offset-4">
                <h6>{{$ward['name']}}</h6>
                <span class="wrapp">{{$ward['description']}}</span>
            </div>
            <div class="clear"></div>
            <hr/>
        @endforeach
        @else
        <p>Нет информации</p>
        @endif
  </div>
  
  @if(isset($branches))
  @foreach($branches as $key=>$value)
  <div class="tab-pane fade" id="{{$key}}">
    @if(isset($titles[$key]))
        <h4>{{$titles[$key]}}</h4>
    @endif
    @if(isset($bodies[$key]))
        <p class="wrapp">{{$bodies[$key]}}</p>
    @endif
  </div>
  @endforeach
  @endif
  
  <div class="tab-pane fade" id="li-ning">
    {{File::get(storage_path().'/texts/lining.txt')}}
    <a class="pull-right" href="catalog.php">Посмотреть каталог</a>
  </div>
</div>
</div>
<!--End TabContent-->
@endsection
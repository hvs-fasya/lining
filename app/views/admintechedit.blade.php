@extends('template.admintemplate')

@section('content')
{{HTML::script('js/admin_tech.js')}}

@if(Session::has('opentab'))
     <p id='opentab' class ='hidden'>{{Session::get('opentab')}}</p>
@endif
@if(Session::has('message'))
     <p id='message' class =''>{{Session::get('message')}}</p>
@endif


<?php
   //echo('<pre>'.print_r($technologies,true).'</pre>');
?>
<hr/>

<a role="button" class='btn btn-link' data-toggle="collapse" href="#addTechnology"><strong>Добавить технологию</strong></a>
<div class="row collapse" id="addTechnology">
<div class="well col-lg-6 col-md-6 col-sm-10 col-xs-12">
        {{ Form::open(['url' => "/admin/catalog/addtech",'files' => 'true' ]) }}
        {{ Form::label('techName', 'Название') }}
        {{ Form::text('techName')}}</br>
        {{ Form::label('shortName', 'Короткое название') }}
        {{ Form::text('shortName')}}</br>
        {{ Form::label( 'techDescr', 'Описание(обязательно все абзацы и переносы делать так как хотим видеть на сайте!!!)') }}</br>
        {{ Form::textarea( 'techDescr', null,['rows'=>'8','cols'=>'40']) }}</br>
        {{ Form::label( 'logo', 'Добавить логотип') }}</br>
        {{ Form::file( 'logo' ) }}
        {{Form::submit('OK') }} 
        {{Form::close()}}
</div>
</div>
<hr/>
@if( isset($technologies)&&count($technologies))
<ol class="wonum">
    @foreach($technologies as $tech)
    <li>
        {{ $tech['name'] }} >>> <a role="button" class="btn btn-link btn-sm" data-toggle="collapse" href="#form{{$tech['id']}}">Изменить</a>
                            >>> <a role="button" class="btn btn-link btn-sm" data-toggle="collapse" href="#bind{{$tech['id']}}">Привязать к товарам</a>
        <div class="collapse smalltext row" id="form{{$tech['id']}}">
            <div class="well col-lg-6 col-md-6 col-sm-10 col-xs-12">
            {{ Form::open(['url' => "/admin/catalog/edittech",'files' => 'true']) }}
            {{ Form::label('techName_'.$tech['id'], 'Название') }}
            {{ Form::text('techName_'.$tech['id'], $tech['name'])}}</br>
            {{ Form::label('shortName_'.$tech['id'], 'Короткое название') }}
            {{ Form::text('shortName_'.$tech['id'],$tech['shortname'])}}</br>
            {{ Form::label( 'techDescr_'.$tech['id'], 'Описание(обязательно все абзацы и переносы делать так как хотим видеть на сайте!!!)') }}</br>
            {{ Form::textarea( 'techDescr_'.$tech['id'], $tech['description'],['rows'=>'8','cols'=>'50']) }}</br>
            {{ Form::label( 'logo_'.$tech['id'], 'Изменить логотип') }}</br>
            <img src="../../{{ $tech['logo'] }}"/>
            {{ Form::file( 'logo_'.$tech['id'] ) }}
            {{ Form::hidden('techId_'.$tech['id'], $tech['id']) }}
            {{ Form::submit ('ОК') }}
            {{ Form::close() }}
            </div>
        </div>
        <div class="collapse smalltext row" id="bind{{$tech['id']}}">
            <div class="well col-lg-6 col-md-6 col-sm-10 col-xs-12">
            {{ Form::open(['url' => "/admin/catalog/bindtech"]) }}
            @foreach($categories as $cat)
            <a role="button" class="btn btn-link btn-sm" data-toggle="collapse" href="#cat{{$cat['category_id']}}_{{$tech['id']}}">{{$cat['category']}}</a></br>
            <div class="collapse row" id="cat{{$cat['category_id']}}_{{$tech['id']}}">
            @foreach($cat['subcategories'] as $sub)
            <p class="col-lg-4 col-md-4 col-sm-5 col-xs-5 col-lg-offset-2 col-md-offset-2 col-sm-offset-1 col-xs-offset-1">{{ $sub['title'] }}</p>
            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 col-lg-offset-6 col-md-offset-6 col-sm-offset-6 col-xs-offset-6">
            @foreach($sub['goods'] as $good)
            @if(!($tech['goods']->contains($good['id'])))
                {{ Form::label( 'good_'.$good['id'].'_'.$tech['id'], $good['artikel']) }}
                {{ Form::checkbox('good_'.$good['id'].'_'.$tech['id'], $good['id'])}}</br>
            @endif
            @endforeach
            </div></br>
            @endforeach
            </div>
            @endforeach
            {{ Form::hidden('id_'.$tech['id'], $tech['id']) }}
            {{ Form::submit ('ОК') }}
            {{ Form::close() }}
            </div>
        </div>
        {{ Form::open(['url' => "/admin/catalog/deltech"]) }}
        {{ Form::hidden('techId', $tech['id']) }}
     <a>{{ Form::submit ('Удалить', array('class'=>'btn btn-link btn-sm', 'role'=>'button')) }}</a>
        {{ Form::close() }}
     
    </li>
    @endforeach
</ol>
@else
    <p>Технологии не заданы</p>
@endif



@endsection
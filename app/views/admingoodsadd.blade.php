@extends('template.admintemplate')


@section('content')

{{HTML::script('js/goodsadd.js')}}

@if(Session::has('opentab'))
     <p id='opentab' class ='hidden'>{{Session::get('opentab')}}</p>
@endif

<?php
    $arrayCat = [];
    /* $arrayCat = [ '...' => [] ];
    $arrayCat['...']['NULL']='Нет подкатегории'; */
    if( isset($categories)&&count($categories) ){
        foreach($categories as $c){
            if( count($c['subcategories']) ){
                $arrayCat[$c['category']]=[];
                foreach($c['subcategories'] as $s){
                    $arrayCat[$c['category']][$s['id']]=$s['title'];
                }
            }
        }
    }
?>
                        
        <hr/>
    <h4>Добавление товаров</h4>
        <hr/>

    <div class="well">
                {{ Form::open(['url' => '/admin/goods/newgood','files' => 'true']) }}
                {{ Form::label( 'goodArtikel', 'Наименование') }}</br>
                {{ Form::text( 'goodArtikel') }}</br>
                {{ Form::label( 'goodDescr', 'Описание(обязательно все абзацы и переносы делать так как хотим видеть на сайте!!!)') }}</br>
                {{ Form::textarea( 'goodDescr',null,['rows'=>'8','cols'=>'40']) }}</br>
                {{ Form::label( 'goodSub', 'Выбрать подкатегорию') }}</br>
                {{ Form::select( 'goodSub', $arrayCat)}}</br>
                {{ Form::label( 'image', 'Выбрать фото') }}</br>
                {{ Form::file( 'image' ) }}
                {{ Form::label( 'goodPrice', 'Цена, евро') }}</br>
                {{ Form::number( 'goodPrice') }}</br>
                <a role="button" class="btn btn-link btn-sm" data-toggle="collapse" href="#techSet"><strong>Привязать технологии</strong></a></br>
                <div class="collapse" id="techSet">
                    @foreach($technologies->sortBy('name') as $t)
                    {{ Form::checkbox('setTech['.$t["id"].']', $t['id']) }}
                    {{ Form::label( 'setTech['.$t["id"].']', $t['name']) }}</br>
                    @endforeach
                </div>
                {{ Form::submit('OK') }}
                {{ Form::close() }}
                </div>
                
@endsection
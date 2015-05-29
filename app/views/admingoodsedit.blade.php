@extends('template.admintemplate')


@section('content')

{{HTML::script('js/goodsedit.js')}}
   
<?php
if(isset($goods)){ 
    $goodsNull = [];
    foreach($goods as $goo){
        if ($goo['subcat_id'] === NULL){
            $goodsNull[] = $goo;
        }
}
}
?>

@if(Session::has('opentab'))
     <p id='opentab' class ='hidden'>{{Session::get('opentab')}}</p>
@endif


        <hr/>
    <h4>Редактирование товаров</h4>
        <hr/>
<div role="tabpanel">

  <!-- Nav tabs (категории)-->
  <ul id="catNavAdmin" class="nav nav-tabs" role="tablist">
  @if(isset($categories)&&count($categories))
  @foreach($categories as $cat)
    <li role="presentation"><a href="#cat{{$cat['category_id']}}" aria-controls="cat{{$cat['category_id']}}" role="tab" data-toggle="tab"><small>{{$cat['category']}}</small></a></li>
  @endforeach
  @else
    <li>Нет категорий</li>
  @endif
  @if( count($goodsNull) )
    <li role="presentation"><a href="#goodsNull" aria-controls="goodsNull" role="tab" data-toggle="tab"><small>Товары без подкатегории</small></a></li>
  @endif
  </ul>
  <!--End of Nav tabs -->
  
  <!-- Tab panes (подкатегории)-->
  <div class="rows">
  <div id="subNavAdmin" class="tab-content col-lg-3 col-md-3 col-sm-3 col-xs-3">
    @if(isset($categories)&&count($categories))
    @foreach($categories as $cat)
        <div role="tabpanel" class="tab-pane" id="cat{{$cat['category_id']}}">
        <ul class="nav nav-stacked" role="tablist">
        @if(isset($cat['subcategories'])&&count($cat['subcategories']))
        @foreach($cat['subcategories'] as $sub)
            <li role="presentation"><a href="#goods{{$sub['id']}}" aria-controls="goods{{$sub['id']}}" role="tab" data-toggle="tab" class="btn btn-sm btn-link">{{$sub['title']}}</a></li>
        @endforeach
        @else
        <li>Нет подкатегорий</li>
        @endif
        </ul>
        </div>
    @endforeach
    @endif
    <?php   
        $arrayCat=[];
        foreach($categories as $c){
            $arrayCat[$c['category']]=[];
            foreach($c['subcategories'] as $s){
                $arrayCat[$c['category']][$s['id']]=$s['title'];
            }
        }
    ?>
                        
    @if( count($goodsNull) )
        <div role="tabpanel" class="tab-pane" id="goodsNull">
            <ul class="wonum">
            @foreach($goodsNull as $gnull)
            <li>
              <a class="btn btn-sm btn-link" role="button" data-toggle="collapse" href="#formSet{{$gnull['id']}}" aria-expanded="false" aria-controls="formSet{{$gnull['id']}}">{{$gnull['artikel']}} --> Назначить подкатегорию</a>
              <div class="collapse smalltext" id="formSet{{$gnull['id']}}">
                <div class="well">
                {{ Form::open(['url' => '/admin/goods/setsub']) }}
                {{ Form::label( 'gnullsub_'.$gnull['id'], 'Выбрать подкатегорию') }}</br>
                {{ Form::select( 'gnullsub_'.$gnull['id'], $arrayCat )}}</br>
                {{ Form::hidden( 'id_'.$gnull['id'], $gnull['id'] ) }}
                {{ Form::submit('Назначить') }}
                {{ Form::close() }}
                </div>
              </div>
            </li>
            @endforeach
            </ul>
        </div>
    @endif
  </div>
  
  <!--Goods-->
  <div id="goodsAdmin" class="tab-content col-lg-8 col-md-8 col-sm-8 col-xs-8">
    @if(isset($subcategories)&&count($subcategories))
    @foreach ($subcategories as $sub)
    <div role="tabpanel" class="tab-pane" id="goods{{$sub['id']}}">
    <ul class="wonum">
        @if(count($sub['goods']))
            @foreach ($sub['goods'] as $good)
            <li><a class="btn btn-sm btn-link" role="button" data-toggle="collapse" href="#form{{$good['id']}}" aria-expanded="false" aria-controls="form{{$good['id']}}">{{$good['artikel']}}</a></li>
            <div class="collapse smalltext" id="form{{$good['id']}}">
                <div class="well">
                {{ Form::open(['url' => '/admin/goods/editgood','files' => 'true']) }}
                {{ Form::label( 'goodArtikel_'.$good['id'], 'Наименование') }}</br>
                {{ Form::text( 'goodArtikel_'.$good['id'], $good["artikel"]) }}</br>
                {{ Form::label( 'goodDescr_'.$good['id'], 'Описание(обязательно все абзацы и переносы делать так как хотим видеть на сайте!!!)') }}</br>
                {{ Form::textarea( 'goodDescr_'.$good['id'], $good["description"],['rows'=>'8','cols'=>'40']) }}</br>
                <?php $def = $good['subcat_id'] ?>
                {{ Form::label( 'goodSub_'.$good['id'], 'Выбрать подкатегорию') }}</br>
                {{ Form::select( 'goodSub_'.$good['id'], $arrayCat, $def)}}</br>
                {{ Form::label( 'image_'.$good['id'], 'Поменять фото') }}</br>
                {{ Form::file( 'image_'.$good['id'] ) }}
                {{ Form::label( 'goodPrice_'.$good['id'], 'Цена, евро') }}</br>
                {{ Form::number( 'goodPrice_'.$good['id'], $good["price"]) }}</br>
                <?php $arrayTechAll =[];
                      if(isset($technologies)&&count($technologies)){
                      foreach($technologies as $techn){
                        $arrayTechAll[$techn['id']] = $techn['name'];
                      }
                      }
                ?>
                <?php $arrayTech =[];
                      if(count($good['technologies'])){
                      foreach($good['technologies'] as $tech){
                        $arrayTech[$tech['id']] = $tech['name'];
                      }
                      }
                      $arrayTechAll = array_diff($arrayTechAll,$arrayTech);
                      $arrayTech[0]='Не удалять';
                      $arrayTechAll[0]='Не добавлять';
                      ?>
                {{ Form::label( 'addTech_'.$good['id'], 'Добавить технологию') }}
                {{ Form::select( 'addTech_'.$good['id'],$arrayTechAll,0) }}</br>
                {{ Form::label( 'moveTech_'.$good['id'], 'Убрать технологию') }}
                {{ Form::select( 'moveTech_'.$good['id'],$arrayTech,0) }}</br>
                {{ Form::hidden( 'id_'.$good['id'], $good['id'] ) }}
                {{ Form::hidden('cat_'.$good['id'], $sub['category_id']) }}
                {{ Form::submit('OK') }}
                {{ Form::close() }}
                </div>
            </div>
            @endforeach
        @else
            <li>Нет товаров в категории "{{$sub['title']}}"</li>
        @endif
    </ul>
    </div>
    @endforeach
    @endif
  </div>
  <!--End of Goods-->
  
  </div><!--rows-->
  <!-- End of Tab panes -->
</div>

@endsection
@extends('template.admintemplate')


@section('content')

{{HTML::script('js/goodsdelete.js')}}

@if(Session::has('opentab'))
     <p id='opentab' class ='hidden'>{{Session::get('opentab')}}</p>
@endif


        <hr/>
    <h4>Удаление товаров</h4>
        <hr/>
<div role="tabpanel">

  <!-- Nav tabs (категории)-->
  <ul id="catNavAdmin" class="nav nav-tabs" role="tablist">
  @if(isset($categories)&&count($categories))
  @foreach($categories as $cat)
    <li role="presentation">
    <a href="#cat{{$cat['category_id']}}" aria-controls="cat{{$cat['category_id']}}" role="tab" data-toggle="tab"><small>{{$cat['category']}}</small></a>
    </li>
  @endforeach
  @else
    <li>Нет категорий</li>
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
  </div>
  
  <!--Goods-->
  <div id="goodsAdmin" class="tab-content col-lg-8 col-md-8 col-sm-8 col-xs-8">
    @if(isset($subcategories)&&count($subcategories))
    @foreach ($subcategories as $sub)
    <div role="tabpanel" class="tab-pane" id="goods{{$sub['id']}}">
    <ul class="wonum">
        @if(count($sub['goods']))
            @foreach ($sub['goods'] as $good)
            <li>
            <div class="row">
            {{ Form::open(['url' => "/admin/catalog/delgood", 'id'=>'form'.$good['id'] ]) }}
            {{ Form::hidden('goodId', $good['id']) }}
            {{ Form::label ('delete', $good['artikel'], ['class'=>'col-lg-2 col-md-4 col-sm-4 col-xs-6']) }}
         <a>{{ Form::submit(' ---> Удалить', array('class'=>'btn btn-link btn-sm col-lg-2 col-md-2 col-sm-4 col-xs-6', 'role'=>'button')) }}</a><span class="glyphicon glyphicon-trash hidden-sm hidden-xs"></span>
            {{ Form::close() }}
            <div>
            </li>
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
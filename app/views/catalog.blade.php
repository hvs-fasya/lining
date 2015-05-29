@extends('template.template')

@section('subnav')
<?php
$classHome = '';
$classTrain = '';
$classEvent = '';
$classLiNing = 'active';
$nav='lining';
?>
@endsection

@section('content')



<!--navbar events page-->
<div class="navbar navbar-default">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-default-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
  
    <div id="subnav" class="navbar-collapse collapse navbar-default-collapse">
        <ul id="catNav" class="nav nav-tabs">
        @if(isset($categories))
        @foreach($categories as $cat)
          <li><a aria-expanded="false" href="#cat{{$cat['category_id']}}" data-toggle="tab">{{$cat['category']}}</a></li>
        @endforeach
        @else
          <li><a aria-expanded="false" href="#" data-toggle="tab">Каталог пуст</a></li>
        @endif
          <li><a aria-expanded="false" href="#docs" data-toggle="tab"><b>Технологии</b></a></li>
        </ul>
    </div>
</div>
<!--End navbar events page-->

<!--TabContent-->
<div class="row">
<div id="TabContent" class="tab-content col-lg-10 col-md-10 col-sm-10 col-xs-12 cat">
    <a class="btn btn-link btn-sm pull-right" data-toggle="collapse" href="#orderCont" aria-expanded="false" aria-controls="orderCont">Cвязаться с нами</a>
<!--Order contacts-->
    <hr/>
    <div class="collapse well" id="orderCont">
            <h6>телефон:</h6>
            <p>+7 (965) 3040124</p>
            <h6>e-mail:</h6>
            <p>tamara-migalina@yandex.ru</p>
    </div>
    <hr/>
<!------>
@if(isset($categories))
    
  @foreach ($categories as $cat)  
    <div class="tab-pane fade col-lg-4 col-md-4 col-sm-4 col-xs-12 cat" id="cat{{$cat['category_id']}}">
    @if(isset($subcategories))
    <h6>{{$cat['category']}}:</h6>
    <div class="hidden-xs">
        <ul class="nav">
        @foreach($subcategories[$cat['category_id']] as $subcat)
        <li><a class="btn btn-link btn-sm" data-toggle="tab" aria-expended="false" aria-controls="goods{{$subcat['id']}}" href="#goods{{$subcat['id']}}">{{$subcat['title']}}</a>
        </li>
        @endforeach
        </ul>
    </div>
    <div class="visible-xs">
        <ul class="nav">
        @foreach($subcategories[$cat['category_id']] as $subcat)
        <li><a class="btn btn-link btn-sm" data-toggle="collapse" aria-expended="false" aria-controls="goods{{$subcat['id']}}" href="#goods{{$subcat['id']}}xs">{{$subcat['title']}}</a>
            <div class="collapse" id="goods{{$subcat['id']}}xs">
            <div class="visible-xs">
                <ul>
                @if(!empty($goods[$subcat['id']]))
                @foreach($goods[$subcat['id']] as $good)
                <li>
                <a href="#descrModal" data-toggle="modal" data-whatever="{{$good['description']}}::{{$good['price']}} &euro;::{{$good['artikel']}}" role="button" class="btn btn-sm btn-link">{{$good['artikel']}}</a>
                <a href="#goodModal" data-toggle="modal" data-whatever="{{$good['fullsize']}}" class="btn btn-sm btn-link" role="button"><small>->фото</small></a>
                </li>
                @endforeach
                @else
                <li><small>Товаров в этом разделе нет</small></li>
                @endif
                </ul>
            </div>
            </div>
        </li>
        @endforeach
        </ul>
    </div>
  @else
    <div>
      <p>{{$cat['category']}}: товаров пока нет</p>
    </div>
  @endif
  </div>
  @endforeach
  <div class="tab-pane fade col-lg-4 col-md-4 col-sm-4 col-xs-4 cat" id="docs">
  @if (isset($technologies)&&!empty($technologies))
  <h6>Технологии:</h6>
    <ul class="visible-xs">
        @foreach($technologies as $tech)
        <li>
            <a class="unfocus" href="#techModal" data-whatever="{{$tech['name']}}::{{$tech['description']}}" data-toggle="modal">
            <span  data-toggle="tooltip" data-placement="right" title="{{$tech['name']}}"><small>{{$tech['shortname']}}</small></span>
            </a>
        </li>
        @endforeach
    </ul>
    <ul class="hidden-xs">
        @foreach($technologies as $tech)
        <li><a data-toggle="tab" aria-expended="false" aria-controls="tech{{$tech['id']}}" href="#tech{{$tech['id']}}"><small>{{$tech['name']}}</small></a></li>
        @endforeach
    </ul>

  @else
    <p>Пусто</p>
  @endif
  </div>
@else
<!--Если нет категорий отображается только вкладка "Технологии"-->
    <div class="tab-pane fade col-lg-4 col-md-4 col-sm-4 col-xs-4 cat" id="docs">
        @if (isset($technologies)&&!empty($technologies))
      <h6>Технологии:</h6>
        <ul class="visible-xs">
            @foreach($technologies as $tech)
            <li>
                <a class="unfocus" href="#techModal" data-whatever="{{$tech['name']}}::{{$tech['description']}}" data-toggle="modal">
                <span  data-toggle="tooltip" data-placement="right" title="{{$tech['name']}}"><small>{{$tech['shortname']}}</small></span>
                </a>
            </li>
            @endforeach
        </ul>
        <ul class="hidden-xs">
            @foreach($technologies as $tech)
            <li><a data-toggle="tab" aria-expended="false" aria-controls="tech{{$tech['id']}}" href="#tech{{$tech['id']}}"><small>{{$tech['name']}}</small></a></li>
            @endforeach
        </ul>

      @else
        <p>Пусто</p>
      @endif
    </div>
<!--Конец повтора вкладки "Технологии"-->
@endif


    <!--Goods previews-->
    <div id="good_show" class="container tab-content col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <!--Technologies content-->
        @if (isset($technologies)&&!empty($technologies))
            @foreach ($technologies as $tech)
            <div id="tech{{$tech['id']}}" class="tab-pane fade hidden-xs">
                <h6 class="center">{{$tech['name']}}</h6>
                <div class="tech-header"><p><img src="{{$tech['logo']}}" alt="" class="img-rounded"></p></div>
                <p class="wrapp tech">{{$tech['description']}}</p>
            </div>
            @endforeach  
        @endif
        <!--End of Technologies content-->
    @if(isset($categories,$subcategories,$goods))
    @foreach ($categories as $cat)
    @foreach($subcategories[$cat['category_id']] as $subcat)
    @if(!empty($goods[$subcat['id']]))
    <div id="goods{{$subcat['id']}}" class="tab-pane fade">
    <div class="visible-sm">
        @foreach($goods[$subcat['id']] as $good)
        <div class="btn-group" role="group">
                <a href="#descrModal" data-toggle="modal" data-whatever="{{$good['description']}}::{{$good['price']}} &euro;::{{$good['artikel']}}" role="button" class="btn btn-sm btn-link unfocus">{{$good['artikel']}}</a>
                <a href="#goodModal" data-toggle="modal" data-whatever="{{$good['fullsize']}}::{{$good['artikel']}}" class="btn btn-sm btn-link" role="button"><img src="{{$good['goodpreview']}}" alt="" class="img-responsive"></a>
                <span class="center"><small><i>{{$good['price']}} &euro;</i></small></span>
        </div>
        @endforeach
    </div>
    <div class="hidden-xs hidden-sm">
        <div class="well">
            <div id="goodsCarousel{{$subcat['id']}}" data-interval="false" class="carousel slide">
                <!-- Carousel items -->
                <div class="carousel-inner">
                <?php $active = ' active' ?>
                @foreach($goods[$subcat['id']] as $good)
                        <div class="item{{$active}}">
                                <div class="row">
                                <div class="thumbnail col-lg-12 col-md-12">
                                <a href="#goodModal" role="button" data-toggle="modal" data-whatever="{{$good['fullsize']}}"><img src="{{$good['goodpreview']}}" alt="" class="img-responsive"></a>
                                <h6 class="center">{{$good['artikel']}}</h6>
                                <div class="caption">
                                    <p class="wrapp">{{$good['description']}}</p>
                                    <p class="center"><b><i>Цена: {{$good['price']}} &euro;</i></b></p></br>
                                    <p class="technology">
                                        @foreach ($good['technologies'] as $tech)
                                        <a href="#techModal" class="btn btn-sm btn-link unfocus" data-whatever="{{$tech['name']}}::{{$tech['description']}}" data-toggle="modal" role="button"><img src="{{$tech['logo']}}" alt="" class="img-rounded"></a></br>
                                        @endforeach
                                     </p>
                                </div>    
                                </div>
                                </div>
                        <!--/row-->
                    </div>
                   <?php $active = '' ?>
                    @endforeach
                </div>
                <!--/carousel-inner--> 
                <a class="left carousel-control" href="#goodsCarousel{{$subcat['id']}}" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#goodsCarousel{{$subcat['id']}}" data-slide="next">›</a>
            </div>
            <!--/goodsCarousel-->
        </div>
        <!--/well-->
    </div>
    </div>
    @else
        <div id="goods{{$subcat['id']}}" class="tab-pane fade hidden-xs">
        <p>Товаров в этом разделе нет</p>
        </div>
    @endif
    @endforeach
    @endforeach
                        <!--Slide-show catalog page-->
                        <div id='catalog_show' class="tab-pane fade active in col-lg-6 col-md-8 hidden-sm hidden-xs">
                            <ul>
                            @foreach ($catalog_show as $img)
                                <li><img src="img/catalog_show/{{$img}}" alt="" id="lin_dan"/></li>
                            @endforeach
                            </ul>
                        </div>
                        <div class="clear"></div>
                        <!----->
    @endif         
</div>
    <!--//end of Goods previews-->
</div>
</div>
<!--End TabContent-->

<!----------------------->
<!--------Modals--------->
<div class="modal fade" id="goodModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                    <!--<div class="modal-dialog">-->
                    <div class="modal-content">
                    <div class="modal-body">
                        <p></p>
                        <img src="" alt="" />
                    </div>
                    
                    <div class="modal-footer">
                        <button class="btn btn-sm" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                    </div>
                    </div>
                    </div>
                </div>
              
<div class="modal fade" id="descrModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-body">                     
                        <p class="center"><b></b></span>
                        <p class="wrapp"><small></small></p>
                        <span class="center"><small><b>Цена: <i></i></b></small></span>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                    </div>
                    </div>
                    </div>
                </div>
<div class="modal fade" id="techModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-body">                     
                        <p class="center"><b></b></span>
                        <p class="wrapp"><small></small></p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm" data-dismiss="modal" aria-hidden="true">Закрыть</button>
                    </div>
                    </div>
                    </div>
                </div>

<!---End-of-Modals--------->
<!----------------------->

@endsection
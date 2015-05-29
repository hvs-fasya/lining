@extends('template.admintemplate')



@section('content')

        <hr/>
@if(isset($message))
    <div id="msg" class='hidden'>
        {{strip_tags($message)}}
    </div>
@endif
        <hr/>

@if(isset($subcategories)&&count($subcategories))
    <h4>Перечень подкатегорий товаров</h4>
    @foreach($categories as $cat)
    
    <div>
    <a role="button" class="btn btn-link btn-sm" data-toggle="collapse" href="#show{{$cat['category_id']}}"><h5>{{$cat['category']}}</h5></a>
    <div class="collapse" id="show{{$cat['category_id']}}">
        <ol>
        
        @foreach($subcategories[$cat['category_id']] as $sub)
          <li>
          {{$sub['title']}}</br>
                {{ Form::open(['url' => "/admin/catalog/deletesubcategory" ]) }}
                {{ Form::hidden('id', $sub['id']) }}
                <a>{{ Form::submit('Удалить', array('class'=>'btn btn-link btn-sm', 'role'=>'button')) }}</a>
                {{Form::close()}}
          <a role="button" class="btn btn-link btn-sm" data-toggle="collapse" href="#updateSubcategory{{$sub['id']}}">Изменить</a>
            <div class="collapse" id="updateSubcategory{{$sub['id']}}">
                {{ Form::open(['url' => "/admin/catalog/updatesubcategory" ]) }}
                <hr/>
                {{ Form::label('subName', 'Новое название') }}</br>
                {{ Form::text('subName', $sub['title']) }}
                {{ Form::hidden('id', $sub['id']) }}
                {{Form::submit('ОК') }} 
                {{Form::close()}}
                <hr/>
            </div>
          <a role="button" class="btn btn-link btn-sm" data-toggle="collapse" href="#moveSubcategory{{$sub['id']}}">Изменить позицию в списке</a>
            <div class="collapse" id="moveSubcategory{{$sub['id']}}">
                <hr/>
                {{ Form::open(['url' => "/admin/catalog/movesubcategory" ]) }}
                {{ Form::label('prevpos', 'Поставить после подкатегории:') }}</br>
                <?php 
                    $selector = [];
                    $selector[0] = 'Поставить в начало';
                    foreach ($subcategories[$cat['category_id']] as $s){
                        if($s!=$sub)
                        $selector[$s['position']]=$s['title'];
                    }
                ?>
                {{Form::select('prevpos', $selector)}}
                {{ Form::hidden('oldpos', $sub['position']) }}
                {{ Form::hidden('id', $sub['id']) }}
                {{ Form::hidden('catid', $cat['category_id']) }}
                {{Form::submit('ОК') }} 
                {{Form::close()}}
                <hr/>
            </div>
        @endforeach
          </li>
          <!--добавление подкатегории-->
          <li class='wonum'>
          <a role="button" class='btn btn-link' data-toggle="collapse" href="#addSub{{$cat['category_id']}}"><strong>Добавить подкатегорию</strong></a>
            <div class="collapse" id="addSub{{$cat['category_id']}}">
                {{ Form::open(['url' => "/admin/catalog/addsubcategory" ]) }}
                {{ Form::label('subName', 'Название') }}</br>
                {{ Form::text('subName')}}</br>
                {{ Form::label('prevpos', 'Вставить после подкатегории:') }}</br>
                <?php 
                    $selector = [];
                    $selector[0] = 'Добавить в начало';
                    foreach ($subcategories[$cat['category_id']] as $sub){
                        $selector[$sub['position']]=$sub['title'];
                    }
                    if(!function_exists('endKey')){
                        function endKey($array){
                            end($array);
                            return key($array);
                        }
                    }
                    $def = endKey($selector);
                ?>
                {{Form::select('prevpos', $selector, $def)}}
                {{ Form::hidden('catid', $cat['category_id']) }}
                {{Form::submit('ОК') }} 
                {{Form::close()}}
                <hr/>
            </div>
          </li>
          <!--end of добавление подкатегории-->
        </ol>
    </div>
    </div>
    @endforeach
    <hr/>
    <!--сиротские подкатегории-->
    <hr/>
    <div>
        <a role="button" class="btn btn-link btn-sm" data-toggle="collapse" href="#showCatNull"><h6>Сиротские подкатегории - не вошедшие ни в одну из категорий</h6></a>
        <div class="collapse" id="showCatNull">
            <ul>
            @if(isset($subcategories[NULL])&&count($subcategories[NULL]))
                @foreach($subcategories[NULL] as $sub)
                    <li>{{$sub['title']}}</li>
                    <!--<a role="button" class='btn btn-link btn-sm' href="/admin/catalog/deletesubcategory/{{$sub['id']}}">Удалить</a>-->
                    {{ Form::open(['url' => "/admin/catalog/deletesubcategory" ]) }}
                    {{ Form::hidden('id', $sub['id']) }}
                    <a>{{ Form::submit('Удалить', array('class'=>'btn btn-link btn-sm', 'role'=>'button')) }}</a>
                    {{Form::close()}}
                    <a role="button" class="btn btn-link btn-sm" data-toggle="collapse" href="#setcatSubcategory{{$sub['id']}}">Назначить категорию</a>
                    <div class="collapse" id="setcatSubcategory{{$sub['id']}}">
                        {{ Form::open(['url' => "/admin/catalog/setcatsubcategory" ]) }}
                        <hr/>
                        <?php
                        $selector = [];
                        foreach ($categories as $cat){
                                $selector[$cat['category_id']]=$cat['category'];
                            } ?>
                        {{ Form::label('catId', 'Выбрать категорию') }}</br>
                        {{Form::select('catId', $selector)}}
                        {{ Form::hidden('id', $sub['id']) }}
                        {{Form::submit('ОК') }} 
                        {{Form::close()}}
                        <hr/>
                    </div>
                @endforeach
            @else
                <li>Сиротских подкатегорий нет</li>
            @endif
            </ul>
        </div>
    </div>
    <!--end of сиротские подкатегории-->
@else
    <h4>Подкатегории не заданы</h4>
@endif
    


@endsection
@extends('template.admintemplate')


@section('content')

{{HTML::script('js/admin_cat_message.js')}}

@if(Session::has('opentab'))
     <p id='opentab' class ='hidden'>{{Session::get('opentab')}}</p>
@endif
<hr/>

@if(isset($categories)&&count($categories))
<h4>Перечень категрий товаров</h4>

<ol>
    @foreach ($categories as $category)
<li>
{{$category['category']}}
        {{ Form::open(['url' => "/admin/catalog/deletecategory" ]) }}
        {{ Form::hidden('catId', $category['category_id']) }}
     <a>{{ Form::submit('Удалить', array('class'=>'btn btn-link btn-sm', 'role'=>'button')) }}</a>
        {{Form::close()}}
    <a role="button" class="btn btn-link btn-sm" data-toggle="collapse" href="#updateCategory{{$category['category_id']}}">Изменить</a>
    <div class="collapse" id="updateCategory{{$category['category_id']}}">
        {{ Form::open(['url' => "/admin/catalog/updatecategory" ]) }}
        <hr/>
        {{ Form::label($category['category_id'].'[catName]', 'Новое название') }}</br>
        {{ Form::text($category['category_id'].'[catName]', $category['category']) }}
        {{ Form::hidden('id', $category['category_id']) }}
        {{Form::submit('ОК') }} 
        {{Form::close()}}
        <hr/>
    </div>
    <a role="button" class="btn btn-link btn-sm" data-toggle="collapse" href="#moveCategory{{$category['category_id']}}">Изменить позицию в списке</a>
            <div class="collapse" id="moveCategory{{$category['category_id']}}">
                <hr/>
                {{ Form::open(['url' => "/admin/catalog/movecategory" ]) }}
                {{ Form::label('prev', 'Поставить после категории:') }}</br>
                <?php 
                    $selector = [];
                    $selector[0] = 'Поставить в начало';
                    foreach ($categories as $c){
                        if($c!=$category)
                        {$selector[$c['position']]=$c['category'];}
                    }
                ?>
                {{ Form::select('prev', $selector)}}
                {{ Form::hidden('oldpos', $category['position']) }}
                {{ Form::hidden('id', $category['category_id']) }}
                {{ Form::submit('ОК') }} 
                {{ Form::close() }}
                <hr/>
            </div>
</li>
    @endforeach
</ol>
@else
    <p>Категории товаров не заданы</p>
@endif

<a role="button" class='btn btn-link' data-toggle="collapse" href="#addCategory"><strong>Добавить категорию</strong></a>
     <div class="collapse" id="addCategory">
        {{ Form::open(['url' => "/admin/catalog/addcategory" ]) }}
        <hr/>
        {{ Form::label('catName', 'Название') }}</br>
        {{ Form::text('catName')}}</br>
        {{ Form::label('prevpos', 'Вставить после категории:') }}</br>
        <?php 
            $selector = [];
            $selector[0] = 'Добавить в начало';
            foreach ($categories as $cat){
                
                $selector[$cat['category_id']]=$cat['category'];
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
        {{Form::submit('ОК') }} 
        {{Form::close()}}
        <hr/>
    </div>



@endsection
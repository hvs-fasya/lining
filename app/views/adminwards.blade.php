
@extends('template.admintemplate')

@section('content')
{{HTML::script('js/admin_wards.js')}}

@if(Session::has('opentab'))
     <p id='opentab' class ='hidden'>{{Session::get('opentab')}}</p>
@endif




@if (isset($wards) && count ($wards) )
<h4>Воспитанники (редактирование):</h4>
<div>
<ul>
@foreach($wards as $ward)
<li>
<a role="button" class="btn btn-link" data-toggle="collapse" href="#update{{$ward['id']}}">{{$ward['name']}}</a>
    <div class="collapse" id="update{{$ward['id']}}">
        
        {{ Form::open(['url' => "/admin/updateward", 'files'=>'true' ]) }}
        <hr/>
        {{ Form::label( 'wardName_'.$ward['id'], 'Фамилия имя') }}</br>
        {{ Form::textarea( 'wardName_'.$ward['id'], $ward['name'], array('rows'=>'2')) }}</br>
        {{ Form::label( 'wardDescr_'.$ward['id'], 'Заслуги и регалии') }}</br>
        {{ Form::textarea( 'wardDescr_'.$ward['id'],$ward['description'], array('rows'=>'12', 'cols'=>'80'))}}</br>
        {{ Form::label( 'wardImage_'.$ward['id'], 'Выбрать фото') }}</br>
        {{ Form::file( 'wardImage_'.$ward['id'] ) }}
        {{ Form::hidden( 'wardId_'.$ward['id'], $ward['id'] ) }}
        {{ Form::submit('ОК') }} 
        {{ Form::close()}}
        <hr/>
    </div>
</li>
@endforeach
</ul>
</div>
<hr/>
@endif

@if (isset($wards) && count ($wards) )
<h4>Воспитанники (удаление):</h4>
<div>
<ul>
@foreach($wards as $ward)
<li>
        <hr/>
        {{ Form::open(['url' => "/admin/delward", 'id'=>'form'.$ward['id'] ]) }}
        {{ Form::hidden('waId'.$ward['id'], $ward['id']) }}
        {{ Form::label ('delete', $ward['name'], ['class'=>'col-lg-2 col-md-4 col-sm-4 col-xs-6']) }}
     <a>{{ Form::submit(' ---> Удалить', array('class'=>'btn btn-link btn-sm col-lg-2 col-md-2 col-sm-4 col-xs-6', 'role'=>'button')) }}</a><span class="glyphicon glyphicon-trash hidden-sm hidden-xs"></span>
        {{ Form::close() }}
</li>
@endforeach
</ul>
<hr/>
</div>
@endif

<div>
<a role="button" class='btn btn-link' data-toggle="collapse" href="#addWard"><strong>Добавить воспитанника</strong></a>
     <div class="collapse" id="addWard">
        {{ Form::open(['url' => "/admin/addward",'files' => 'true' ]) }}
        <hr/>
        {{ Form::label('wardName', 'Имя, фамилия:') }}</br>
        {{ Form::textarea('wardName', null, array('rows'=>'2')) }}</br>
        {{ Form::label('wardDescr', 'Заслуги:') }}</br>
        {{ Form::textarea('wardDescr',null)}}</br>
        {{ Form::label( 'wardImage', 'Выбрать фото') }}</br>
        {{ Form::file( 'wardImage' ) }}
        {{Form::submit('Добавить') }} 
        {{Form::close()}}
        <hr/>
    </div>
<hr/>
</div>

@endsection
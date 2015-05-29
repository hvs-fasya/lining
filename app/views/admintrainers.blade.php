@extends('template.admintemplate')

@section('content')
{{HTML::script('js/admin_trainers.js')}}

@if(Session::has('opentab'))
     <p id='opentab' class ='hidden'>{{Session::get('opentab')}}</p>
@endif




@if (isset($trainers) && count ($trainers) )
<h4>Тренеры (редактирование):</h4>
<div>
<ul>
@foreach($trainers as $trainer)
<li>
<a role="button" class="btn btn-link" data-toggle="collapse" href="#update{{$trainer['id']}}">{{$trainer['name']}}</a>
    <div class="collapse" id="update{{$trainer['id']}}">
        
        {{ Form::open(['url' => "/admin/updatetrainer", 'files'=>'true' ]) }}
        <hr/>
        {{ Form::label( 'trainerName_'.$trainer['id'], 'ФИО') }}</br>
        {{ Form::textarea( 'trainerName_'.$trainer['id'], $trainer['name'], array('rows'=>'2')) }}</br>
        {{ Form::label( 'trainerDescr_'.$trainer['id'], 'Заслуги и регалии') }}</br>
        {{ Form::textarea( 'trainerDescr_'.$trainer['id'],$trainer['description'], array('rows'=>'12', 'cols'=>'80'))}}</br>
        {{ Form::label( 'trainerImage_'.$trainer['id'], 'Выбрать фото') }}</br>
        {{ Form::file( 'trainerImage_'.$trainer['id'] ) }}
        {{ Form::hidden( 'trainerId_'.$trainer['id'], $trainer['id'] ) }}
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

@if (isset($trainers) && count ($trainers) )
<h4>Тренеры (удаление):</h4>
<div>
<ul>
@foreach($trainers as $trainer)
<li>
        <hr/>
        {{ Form::open(['url' => "/admin/deltrainer", 'id'=>'form'.$trainer['id'] ]) }}
        {{ Form::hidden('trainId'.$trainer['id'], $trainer['id']) }}
        {{ Form::label ('delete', $trainer['name'], ['class'=>'col-lg-2 col-md-4 col-sm-4 col-xs-6']) }}
     <a>{{ Form::submit(' ---> Удалить', array('class'=>'btn btn-link btn-sm col-lg-2 col-md-2 col-sm-4 col-xs-6', 'role'=>'button')) }}</a><span class="glyphicon glyphicon-trash hidden-sm hidden-xs"></span>
        {{ Form::close() }}
</li>
@endforeach
</ul>
<hr/>
</div>
@endif

<div>
<a role="button" class='btn btn-link' data-toggle="collapse" href="#addTrainer"><strong>Добавить тренера</strong></a>
     <div class="collapse" id="addTrainer">
        {{ Form::open(['url' => "/admin/addtrainer",'files' => 'true' ]) }}
        <hr/>
        {{ Form::label('trainerName', 'ФИО тренера:') }}</br>
        {{ Form::textarea('trainerName', null, array('rows'=>'2')) }}</br>
        {{ Form::label('trainerDescr', 'Заслуги и регалии:') }}</br>
        {{ Form::textarea('trainerDescr',null)}}</br>
        {{ Form::label( 'trainerImage', 'Выбрать фото') }}</br>
        {{ Form::file( 'trainerImage' ) }}
        {{Form::submit('Добавить') }} 
        {{Form::close()}}
        <hr/>
    </div>
<hr/>
</div>

@endsection
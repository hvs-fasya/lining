@extends('template.admintemplate')

@section('content')
{{HTML::script('js/admin_posts_message.js')}}

@if(Session::has('opentab'))
     <p id='opentab' class ='hidden'>{{Session::get('opentab')}}</p>
@endif



<hr/>
<h4>Редактирование текстов на сайте</h4>
<hr/>

<h4>Разделы:</h4>

@if (isset($branches) && count ($branches) )
<ul>
@foreach($branches as $key => $value)
<li>

<a role="button" class="btn btn-link" data-toggle="collapse" href="#update{{$key}}">{{$value}}</a>
    <div class="collapse" id="update{{$key}}">
        
        {{ Form::open(['url' => "/admin/updatetext" ]) }}
        <hr/>
        {{ Form::label( $key.'Title', 'Новый заголовок') }}</br>
        {{ Form::textarea( $key.'Title', $titles[$key], array('rows'=>'2')) }}</br>
        {{ Form::label( $key.'Body', 'Текст') }}</br>
        {{ Form::textarea( $key.'Body',$bodies[$key], array('rows'=>'12', 'cols'=>'80'))}}</br>
        {{ Form::hidden( 'textId', $key ) }}
        {{ Form::submit('ОК') }} 
        {{ Form::close()}}
        <hr/>
    </div>
</li>
@endforeach
<li>
<a role="button" class="btn btn-link" data-toggle="collapse" href="#updatelining">Li-Ning</a>
    <div class="collapse" id="updatelining">
        {{ Form::open(['url' => "/admin/updatetext" ]) }}
        <hr/>
        {{ Form::label( 'lining'.'Title', 'Новый заголовок') }}</br>
        @if( isset($liningTitle) )
        {{ Form::textarea( 'lining'.'Title', $liningTitle, array('rows'=>'2')) }}</br>
        @else
        {{ Form::textarea( 'lining'.'Title', null, array('rows'=>'2')) }}</br>
        @endif
        {{ Form::label( 'lining'.'Body', 'Текст') }}</br>
        @if(isset($liningBody))
        {{ Form::textarea( 'lining'.'Body',$liningBody, array('rows'=>'12', 'cols'=>'80'))}}</br>
        @else
        {{ Form::textarea( 'lining'.'Body',null, array('rows'=>'12', 'cols'=>'80'))}}</br>
        @endif
        {{ Form::hidden( 'textId', 'lining' ) }}
        {{ Form::submit('ОК') }} 
        {{ Form::close()}}
        <hr/>
    </div>
</li>
</ul>
@endif

@endsection
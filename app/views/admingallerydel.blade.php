@extends('template.admintemplate')

@section('content')
{{HTML::script('js/admin_del_folder.js')}}

@if(Session::has('opentab'))
     <p id='opentab' class ='hidden'>{{Session::get('opentab')}}</p>
@endif
 
        <h4>Перечень папок Галереи:</h4>
        <hr>
    @if(isset($gallerySections)&&count($gallerySections))
        <div class="row" id="changeTitle">
        <ol>
        @foreach($gallerySections as $sec)
        <li><a role="button" class='btn btn-link' data-toggle="collapse" href="#delfolder{{$sec['section_id']}}">{{$sec['description']}}</a>
        <div class="row well collapse" id="delfolder{{$sec['section_id']}}">
            @if( isset($sec['photos']) && count($sec['photos']))
            <ul>
            @foreach($sec['photos'] as $photo)
            <li class='col-lg-2 col-md-3 col-sm-4 col-xs-6'>
                {{ Form::open(['url'=>'/admin/gallery/delPhoto']) }}
                {{ Form::hidden('photoId_'.$photo['id'],$photo['id']) }}</br>
                <img src="../../{{$photo['preview']}}" alt=""/></br> 
                {{ Form::submit('Удалить фото',array('class'=>'btn btn-link btn-sm')) }}
                {{ Form::close() }}
                </li>
            @endforeach
            </ul>
            @endif
        </div>
        {{ Form::open(['url'=>'/admin/gallery/delFolder']) }}
        {{ Form::hidden('sectionId_'.$sec['section_id'],$sec['section_id']) }}</br>
        {{ Form::submit('Удалить папку со всеми фото') }}
        {{ Form::close() }}
        </li>
        @endforeach
        </ol>
        </div>
    <hr>
    @else
    <p>В галерее нет папок с фото</p>
    <hr>
    @endif
    
@endsection
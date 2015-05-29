@extends('template.admintemplate')

@section('content')
{{HTML::script('js/admin_folder.js')}}

@if(Session::has('opentab'))
     <p id='opentab' class ='hidden'>{{Session::get('opentab')}}</p>
@endif


    <a role="button" class='btn btn-link' data-toggle="collapse" href="#addFolder"><strong>Добавить папку</strong></a>
    <div class="row collapse" id="addFolder">
    <div class="well col-lg-6 col-md-6 col-sm-10 col-xs-12">
        {{ Form::open(['url' => "/admin/gallery/addfolder"]) }}
        {{ Form::label('folderDescription', 'Название папки') }}</br>
        {{ Form::textarea('folderDescription',null,['rows'=>'3','cols'=>'40'])}}</br>
        
        @if(isset($gallerySections)&&count($gallerySections))
            {{ Form::label('prev', 'Поставить после папки:') }}</br>
                    <?php 
                        $selector = [];
                        $selector[0] = 'Поставить в начало';
                        foreach ($gallerySections as $sec){
                            $selector[$sec['position']]=$sec['description'];
                        }
                    ?>
            {{ Form::select('prev', $selector)}}</br>
        @endif
        {{ Form::submit('OK') }} 
        {{Form::close()}}
    </div>
    </div>
    <hr>
    @if(isset($gallerySections)&&(count($gallerySections)>1))
    <a role="button" class='btn btn-link' data-toggle="collapse" href="#moveFolder"><strong>Поменять порядок папок</strong></a>
    <div class="row collapse" id="moveFolder">
    <ol>
    @foreach($gallerySections as $sec)
        <li><a role="button" class='btn btn-link' data-toggle="collapse" href="#move{{$sec['section_id']}}">{{$sec['description']}}</a>
        <div class="well collapse" id="move{{$sec['section_id']}}">
            {{ Form::open(['url'=>'/admin/gallery/movefolder']) }}
            <?php
                $selectshort = $selector;
                unset($selectshort[$sec['position']]);
            ?>
            {{ Form::label( 'prevSec_'.$sec['section_id'], 'Поставить после папки' ) }}</br>
            {{ Form::select( 'prevSec_'.$sec['section_id'],$selectshort ) }}
            {{ Form::hidden('sectionId_'.$sec['section_id'],$sec['section_id']) }}
            {{ Form::submit('OK') }}
            {{ Form::close() }}
        </div>
        </li>
    @endforeach
    </ol>
    </div>
    <hr>
    @endif
    
    @if(isset($gallerySections)&&count($gallerySections))
        <a role="button" class='btn btn-link' data-toggle="collapse" href="#changeTitle"><strong>Изменить название папки</strong></a>
        <div class="row collapse" id="changeTitle">
        <ol>
        @foreach($gallerySections as $sec)
        <li><a role="button" class='btn btn-link' data-toggle="collapse" href="#change{{$sec['section_id']}}">{{$sec['description']}}</a>
        <div class="well collapse" id="change{{$sec['section_id']}}">
            {{ Form::open(['url'=>'/admin/gallery/changeTitle']) }}
            {{ Form::label('newDescr_'.$sec['section_id'],'Новое название') }}</br>
            {{ Form::textarea('newDescr_'.$sec['section_id'],null,['rows'=>'3','cols'=>'40']) }}
            {{ Form::hidden('sectionId_'.$sec['section_id'],$sec['section_id']) }}</br>
            {{ Form::submit('OK') }}
            {{ Form::close() }}
        </div>
        </li>
        @endforeach
        </ol>
        </div>
    <hr>
    @endif
    
    @if(isset($gallerySections)&&count($gallerySections))
        <a role="button" class='btn btn-link' data-toggle="collapse" href="#addPhoto"><strong>Добавить фото</strong></a>
        <div class="row collapse" id="addPhoto">
            <div class="col-lg-6 col-md-6 col-sm-10 col-xs-12">
            <ol>
            @foreach($gallerySections as $sec)
            <li><a role="button" class='btn btn-link' data-toggle="collapse" href="#addPhoto{{$sec['section_id']}}">{{$sec['description']}} --> <span class="glyphicon glyphicon-folder-open"></span></a>
            <div class="well collapse" id="addPhoto{{$sec['section_id']}}">
                
            {{ Form::open(['url' => "/admin/gallery/addphoto",'files' => 'true']) }}
            {{ Form::label( 'photo_'.$sec['section_id'], 'Добавить фото',['class'=>'sr-only']) }}</br>
            {{ Form::file( 'photo_'.$sec['section_id'] ) }}
            {{ Form::hidden('secId_'.$sec['section_id'], $sec['section_id']) }}
            {{ Form::submit('ОК') }} 
            {{ Form::close() }}
            <hr>
                <div>
                @foreach($sec['photos'] as $photo)
                    <img class="photo" src="../../{{$photo['preview']}}" alt="" />
                @endforeach
                </div>
                <div class="clear"></div>
            </div>
            <hr>
            </li>
            @endforeach
            </ol>
            </div>
        </div>
    @else
        <p><strong>В галерее папок нет</strong></p>
    @endif
@endsection
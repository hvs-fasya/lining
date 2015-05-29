@extends('template.admintemplate')



@section('content')
        
        @if (!Auth::check())
            <div id="signin-form">
                <h5>Вход в административный раздел сайта</h5><br>
                    {{ Form::open(['url' => "/admin/userlogin" ]) }}
                <div class="form-group">
                    {{ Form::label('username', 'Логин', array('class'=>'col-sm-2')) }}
                    {{ Form::text('username', $value = null, array('class'=>'col-sm-2')) }}</br>
                </div>
                <div class="form-group">
                    {{ Form::label('password', 'Пароль', array('class'=>'col-sm-2')) }}
                    {{ Form::password('password', array('class'=>'col-sm-2')) }}</br>
                </div>
                <div class="checkbox col-sm-3 col-sm-offset-2">
                    {{ Form::checkbox('remember','remember-me',true) }}
                    {{ Form::label('remember', 'Запомнить меня', array('class'=>'checkbox')) }}
                </div>
                <div class="col-sm-offset-2 col-sm-10">
                    {{ Form::submit('Войти', array('class'=>'btn btn-primary btn-sm', 'role'=>'button')) }}
                </div>
                    {{ Form::close() }}
            </div>
            @else
            <div id="register-form">    
                <h5>Пользователь {{ Auth::user()->username }} авторизован и может работать тут сколько влезет</h5>
                <ul>
                <li>
                {{Form::open(['url' => "/admin/userlogout" ])}}
                {{Form::submit('может разлогиниться отсюда', array('class'=>'btn btn-link','role'=>'button')) }}
                {{Form::close()}}
                </li>
                <li><a class='btn btn-link' role='button' data-toggle="collapse" href="#regform">может зарегистрировать нового пользователя</a>
                <div class="collapse" id="regform">
                </br>
                    {{ Form::open(['url' => "/admin/register" ]) }}
                <div class="form-group">
                        {{ Form::label('username', 'Логин') }}</br>
                        {{ Form::text('username', $value = null, array('class'=>'col-sm-3','data-toggle'=>'popover','data-content'=>'Может содержать только латинские символы и цифры')) }}</br>
                    </div>
                    <div class="form-group">
                        {{ Form::label('email', 'E-mail') }}</br>
                        {{ Form::email('email', $value = null, array('class'=>'col-sm-3')) }}</br>
                    </div>
                    <div class="form-group">
                        {{ Form::label('password', 'Пароль') }}</br>
                        {{ Form::password('password', array('class'=>'col-sm-3','data-toggle'=>'popover','data-content'=>'Должно быть длиной не меньше 6 символов')) }}</br>
                    </div>
                    <div class="form-group">
                        {{ Form::label('password_confirmation', 'Повтор пароля') }}</br>
                        {{ Form::password('password_confirmation', array('class'=>'col-sm-3')) }}</br>
                    </div>
                    <div class="col-sm-3">
                    </br>
                        {{ Form::submit('Зарегистрировать', array('class'=>'btn btn-primary btn-sm', 'role'=>'button')) }}
                    </div>
                    {{ Form::close()}}
                </div></li>
                </ul>
            </div>
            @endif
@endsection
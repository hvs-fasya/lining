<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Li-ning | Бадминтон в Мытищах </title>
    <!-- Bootstrap -->
    {{HTML::style('bootstrap-3.3.1/dist/css/bootstrap.css')}}
    {{HTML::style('bootstrap-3.3.1/dist/css/bootstrap-theme.css')}}
    {{HTML::style('css/badmrulit.css')}}
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {{HTML::script('bootstrap-3.3.1/js/jquery-1.11.2.min.js')}}
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    {{HTML::script('bootstrap-3.3.1/dist/js/bootstrap.min.js')}}
    <!-- {{HTML::script('js/admin_message.js')}}-->
    <!-- jQuery cookie plugin 
    <script src="bootstrap-3.3.1/js/carhartl-jquery-cookie-92b7715/jquery.cookie.js" type="text/javascript"></script>-->
</head>

<body>

<!-- Navbar header -->	
<div class="navbar navbar-inverse">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a href="#" class="btn btn-link disabled"><img src="/img/header-logo.png"/></a>
  </div>
  <div class="navbar-collapse collapse navbar-inverse-collapse">
    <ul class="nav navbar-nav">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Наполнение сайта<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="/admin/content/posts">Новости</a></li>
          <!--<li><a href="#">Календарь</a></li>-->
          <li><a href="#">Контакты</a></li>
          <li><a href="/admin/content/trainers">Тренеры</a></li>
          <li><a href="/admin/content/wards">Наша гордость</a></li>
          <li><a href="/admin/content/texts">Тексты на сайте</a></li>
          <!--<li><a href="#">Индивидуальные тренировки</a></li>
          <li><a href="#">Игровые тренировки/взрослые</a></li>
          <li><a href="#">Расписание</a></li>
          <li><a href="#">Цены</a></li>-->
        </ul>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Галерея<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="/admin/gallery/addfolder">Добавить папку/фото</a></li>
          <li><a href="/admin/gallery/delfolder">Удаление папки/фото</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Каталог<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="/admin/catalog/categories">Создать/удалить/изменить категорию товаров</a></li>
          <li><a href="/admin/catalog/subcategories">Создать/удалить/изменить подкатегорию товаров</a></li>
          <li><a href="/admin/catalog/addgoods">Добавление товаров</a></li>
          <li><a href="/admin/catalog/delete">Удаление товаров</a></li>
          <li><a href="/admin/catalog/update">Редактирование товаров</a></li>
          <li><a href="/admin/catalog/tech">Редактирование технологий</a></li>
         </ul>
      </li>
    </ul>
    @if(Auth::check())
    <ul class="nav nav-pills navbar-right">
      <li>
        {{Form::open(['url' => "/admin/userlogout" ])}}
        {{Form::submit('Разлогиниться', array('class'=>'btn btn-link','role'=>'button')) }}
        {{Form::close()}}
      </li>
    </ul>
    @endif
  </div>
</div>

<div>
    <a href="/index.php">Вернуться на основной сайт</a>
</div>
@if(Session::has('message'))
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>{{Session::get('message')}}</strong></br>
</div>
@endif
@if (count($errors))
<div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @foreach($errors->all() as $er)
        <strong>Ошибочка!!!</strong> {{$er}}</br>
    @endforeach
</div>
@endif
<hr/>
<!-- End of Navbar header -->
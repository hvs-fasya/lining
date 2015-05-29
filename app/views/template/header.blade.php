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
    @if ($nav=='home')
    {{HTML::script('js/index_subnav.js')}}
    @endif
    @if ($nav=='training')
    {{HTML::script('js/training_subnav.js')}}
    @endif
    @if ($nav=='events')
    {{HTML::script('js/events_subnav.js')}}
    @endif
    @if ($nav=='lining')
    {{HTML::script('js/catalog_subnav.js')}}
    @endif
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
    <a href="#" class="btn btn-link disabled"><img src="img/header-logo.png"/></a>
  </div>
  <div class="navbar-collapse collapse navbar-inverse-collapse">
    <ul class="nav navbar-nav">
      <!-- <li class="active"><a href="#">Главная</a></li> -->
      <!-- <li class="active dropdown"><a href="index.html">Главная</a></li> -->
      <li class="<?= $classHome?> dropdown">
        <a href="index.php" class="dropdown-toggle" data-toggle="dropdown">Главная<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="index.php?subnav=news">Новости</a></li>
          <li><a href="index.php?subnav=contacts">Контакты</a></li>
          <li class="divider"></li>
          <li><a href="index.php?subnav=lining">Li-Ning</a></li>
         </ul>
      <li class="<?= $classTrain?> dropdown">
        <a href="training.php" class="dropdown-toggle" data-toggle="dropdown">Тренировки<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="training.php?subnav=trainers">Тренеры</a></li>
          <li><a href="training.php?subnav=ward">Наши воспитанники</a></li>
          <li class="divider"></li>
          <li><a href="training.php?subnav=child">Групповые занятия/дети</a></li>
          <li><a href="training.php?subnav=individual">Индивидуальные тренировки</a></li>
          <li><a href="training.php?subnav=grownup">Игровые тренировки/взрослые</a></li>
          <li class="divider"></li>
          <!-- <li class="dropdown-header">Dropdown header</li> -->
          <li><a href="training.php?subnav=shedule">Расписание</a></li>
          <li><a href="training.php?subnav=price">Цены</a></li>
        </ul>
      </li>
      <li class="<?= $classEvent?> dropdown">
        <a href="events.php" class="dropdown-toggle" data-toggle="dropdown">События<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <!--<li><a href="events.php?subnav=calendar">Календарь</a></li>-->
          <li><a href="events.php?subnav=archieve">Архив новостей</a></li>
          <li class="divider"></li>
          <li><a href="events.php?subnav=gallery">Галерея</a></li>
         </ul>
      </li>
    </ul>
    
    <!-- <ul class="nav navbar-nav navbar-right"> -->
    <ul class="nav nav-pills navbar-right">
     <li><a href="catalog.php">Товары для бадминтона Li-Ning</a></li>
    </ul>
  </div>
</div>
<!-- End of Navbar header -->
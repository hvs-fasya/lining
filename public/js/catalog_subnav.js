//страница 'каталог' catalog.php

function Rotator() {
	$('div#catalog_show ul li').css({opacity: 0.0});
	$('div#catalog_show ul li:first').css({opacity: 1.0});
	setInterval('rotate()',3000);
}

function rotate() {	
	var current = ($('div#catalog_show ul li.show')?  $('div#catalog_show ul li.show') : $('div#catalog_show ul li:first'));
    // Берем следующую картинку, когда дойдем до последней начинаем с начала
	var next = ((current.next().length) ? ((current.next().hasClass('show')) ? $('div#catalog_show ul li:first') :current.next()) : $('div#catalog_show ul li:first'));	
    // Подключаем эффект растворения/затухания для показа картинок, css-класс show имеет больший z-index
	next.css({opacity: 0.0})
	.addClass('show')
	.animate({opacity: 1.0}, 1000);
    // Прячем текущую картинку
	current.animate({opacity: 0.0}, 1000)
	.removeClass('show');
};  

function resizing(){
    if ( ($(document).width()) < 873 )
    {
    $("#catNav").addClass('nav-stacked');
    $("#catNav").removeClass('nav-tabs');
    }else{
    $("#catNav").removeClass('nav-stacked');
    $("#catNav").addClass('nav-tabs');
    }
};

$(document).ready(function() {

if ( ($(document).width()) < 873 )
    {
    $("#catNav").addClass('nav-stacked');
    $("#catNav").removeClass('nav-tabs');
    }
$(window).resize(function(){
    resizing();
});

$("#carousel-lining").addClass("hidden-lg");
$("#carousel-lining").addClass("hidden-md");
$("#carousel-lining").addClass("hidden-sm");

$("#catNav li:first").addClass("active");
$("#TabContent div.tab-pane:first").addClass("in active");

$($('#TabContent')).css('min-height',750);
/* console.log($('#TabContent').height());
console.log($('#catalog_show').height()); */

$('div#catalog_show ul li:first').addClass('show');

Rotator();

$("#catNav li a").click('on', function(){
    $("div[id^='goods'].active.in").removeClass("active in");
    $("div[id^='tech'].active.in").removeClass("active in");
    $("div[id^='cat']>div>ul>li.active").removeClass("active");
    $("#docs>ul>li.active").removeClass("active");
    $("#catalog_show").addClass(" active in");
    $("#subnav").collapse('toggle');
});

$('#goodModal').on('show.bs.modal', function (event) {
  var modal = $(this);
  var button = $(event.relatedTarget) // Button that triggered the modal
  var data = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  var name = data.split('::')[0].split('/')[2];
  var artikel = data.split('::')[1];
  
  if(!$('.modal-dialog').width() == 0){
    var width = $('.modal-dialog').width()*0.92;
    }else{
    var width = $(window).width()*0.8;
    }
    
$.get('goodphoto/'+name+'/'+width+'/'+Math.random(),
    function(data){
    $.ajaxSetup({cashe:false});
    modal.find('.modal-body img').attr('src','img/gallery/tmpphoto.jpg?var='+Math.random());
    modal.find('.modal-body p').text(artikel);
    $('#goodModal div.modal-body').show();
    });
    })
    
$('#descrModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var descr = button.data('whatever').split('::')[0];
  var price = button.data('whatever').split('::')[1];
  var artikel = button.data('whatever').split('::')[2];
  var modal = $(this);
  modal.find('.modal-body p.wrapp small').text(descr);
  modal.find('.modal-body i').text(price);
  modal.find('.modal-body p.center b').text(artikel);
    })
    
$('#goodModal div.modal-footer button').click('on', function(){
    $('#goodModal div.modal-body').hide();
    })
    
$('#techModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var descr = button.data('whatever').split('::')[1];
  var name = button.data('whatever').split('::')[0];
  var modal = $(this);
  modal.find('.modal-body p.wrapp small').text(descr);
  modal.find('.modal-body p.center b').text(name);
    })
  
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
})  
    
});

  
//страница 'события' events.php
//включение табов подменю при выборе пунктов выпадающего списка "события"

$(document).ready(function() {

    var pos = window.location.href.indexOf("?subnav=")+1
    var subnav = window.location.href.slice(pos+7)
    switch (subnav) {
    case 'calendar': $("#calendar").addClass('active in'); break
    case 'archieve': $("#archieve").addClass('active in'); break
    case 'gallery': $("#gallery").addClass('active in'); break
    case 'lining': $("#li-ning").addClass('active in'); break
    default : $("#li-ning").addClass('active in')
}

 $('#photoModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var image = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  var name = image.split('/')[4];
  //var arr = image.split('//')[0].split('/');
  //var dir = arr[arr.length-1];
  var dir = image.split('/')[3];
  var modal = $(this);
  if(!$('.modal-dialog').width() == 0){
    var width = $('.modal-dialog').width()*0.92;
    }else{
    var width = $(window).width()*0.8;
    }
  
  $.get('preparephoto/'+dir+'/'+name+'/'+width+'/'+Math.random(),
    function(data){
    $.ajaxSetup({cashe:false});
    modal.find('.modal-body img').attr('src','img/gallery/tmpphoto.jpg?var='+Math.random())
    });
    })

});
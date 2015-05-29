$(document).ready(function() {

var del = false;    
    
    $("form[action*='delPhoto']").submit(function( event ) {
    if(del === false){
      event.preventDefault();
      $(":focus").removeClass('btn-link');
      $(":focus").addClass('btn-danger');
      del = confirm('Удалить фото???');
        }
        if(del === true){
        this.submit();
        }
    del = false;
    $(":focus").removeClass('btn-danger');
    $(":focus").addClass('btn-link');
    return del;
    })
    
    $("form[action*='delFolder']").submit(function( event ) {
    if(del === false){
      event.preventDefault();
      $(":focus").addClass('btn-danger');
      del = confirm('Удалить папку вместе с содержимым???');
        }
        if(del === true){
        this.submit();
        }
    del = false;
    $(":focus").removeClass('btn-danger');
    return del;
    })
    
    });
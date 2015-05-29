$(document).ready(function() {

    if($("#opentab").text() === 'addcat'){
        $('#addCategory').collapse('show')
        $('#addCategory form input[id="catName"]').focus();
	}else
    if( $("#opentab").text() != '' ){
        var opentab = '#updateCategory'+$("#opentab").text();
        var focusform = '"'+$("#opentab").text()+'[catName]"';
        $(opentab).collapse('show');
        $(opentab+' form input[name='+focusform+']').focus();   
        }
        

    var del = false;
    
    $("form[action*='delete']").submit(function( event ) {
    if(del === false){
      event.preventDefault();
      del = confirm('Удалить категорию???');
        }
        if(del === true){
        this.submit();
        }
    del = false;
    return del;
    });
        
    $('[data-toggle="popover"]').popover({placement:'left auto', trigger:'click'});
});
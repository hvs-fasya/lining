$(document).ready(function() {
    

        
    if ( ($("#opentab").text()) === 'addpost'){
        $('#addPost').collapse('show');
        $('#addPost form textarea[id="postTitle"]').focus();
        }
        else{
      if( ($("#opentab").text())!= '' ){
        var opentab = '#updatePost'+$("#opentab").text();
        var focusform = '"'+$("#opentab").text()+'[postTitle]"';
        $(opentab).collapse('show');
        $(opentab+' form textarea[name='+focusform+']').focus();   
        }
        }
        
    $('[data-toggle="popover"]').popover({placement:'left auto', trigger:'click'});
});
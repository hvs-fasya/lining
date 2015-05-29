$(document).ready(function() {
    

        
    if ( ($("#opentab").text()) === 'addpost'){
        $('#addPost').collapse('show');
        $('#addPost form textarea[id="postTitle"]').focus();
        }else 
        if($("#opentab").text() === 'addcat'){
        $('#addCategory6').collapse('show')
        $('#addCategory6 form textarea[id="catName"]').focus();
	    }else
      if( ($("#opentab").text()).indexOf('category')+1 ){
            var opentab = '#updateCategory'+$("#opentab").text();
            alert (opentab);
            var focusform = '"'+$("#opentab").text()+'[catName]"';
            alert (focusform);
            $(opentab).collapse('show');
            $(opentab+' form textarea[name='+focusform+']').focus();   
        }
        else
      if(($("#opentab").text()).indexOf('postnum')+1 ){
        var opentab = '#updatePost'+$("#opentab").text();
        var focusform = '"'+$("#opentab").text()+'[postTitle]"';
        $(opentab).collapse('show');
        $(opentab+' form textarea[name='+focusform+']').focus();   
        }
        
    $('[data-toggle="popover"]').popover({placement:'left auto', trigger:'click'});
});
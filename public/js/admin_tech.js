
$(document).ready(function() {
   
    if( ($("#opentab").text())!= '' ){
        var opentab = $("#opentab").text();
        if( opentab == 'addTechnology' ){
        //alert(opentab);
            $("#addTechnology").collapse('show');
            $("div[id='addTechnology'] div form input[id='techName']").focus();
            }else{
            var openwell = 'form'+$("#opentab").text();
            $("#"+openwell).collapse('show');
            $("form input[id='techName_"+$('#opentab').text()+"']").focus();
            
            }
    } 
    
    var del = false;    
    $("form[action*='deltech']").submit(function( event ) {
    if(del === false){
      event.preventDefault();
      del = confirm('Удалить технологию???');
        }
        if(del === true){
        this.submit();
        }
    del = false;
    return del;
    }); 
});
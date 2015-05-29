
$(document).ready(function() {
   
    if( ($("#opentab").text())!= '' ){
        var opentab = $("#opentab").text();
        if( opentab == 'addWard' ){
            $("#addWard").collapse('show');
            $("div[id='addWard'] form textarea[id='wardName']").focus();
            }
        else {
            $("#"+opentab).collapse('show');
            $("div[id='"+opentab+"'] form textarea[id*='wardName']").focus();
            }/* else{
            var openwell = 'form'+$("#opentab").text();
            $("#"+openwell).collapse('show');
            $("form input[id='techName_"+$('#opentab').text()+"']").focus();
            
            } */
    } 
    
    var del = false;    
    $("form[action*='delward']").submit(function( event ) {
    if(del === false){
      event.preventDefault();
      del = confirm('Удалить воспитанника???');
        }
        if(del === true){
        this.submit();
        }
    del = false;
    return del;
    }); 
});
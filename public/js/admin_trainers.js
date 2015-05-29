
$(document).ready(function() {
   
    if( ($("#opentab").text())!= '' ){
        var opentab = $("#opentab").text();
        if( opentab == 'addTrainer' ){
            $("#addTrainer").collapse('show');
            $("div[id='addTrainer'] form textarea[id='trainerName']").focus();
            }
        else {
            $("#"+opentab).collapse('show');
            $("div[id='"+opentab+"'] form textarea[id*='trainerName']").focus();
            }/* else{
            var openwell = 'form'+$("#opentab").text();
            $("#"+openwell).collapse('show');
            $("form input[id='techName_"+$('#opentab').text()+"']").focus();
            
            } */
    } 
    
    var del = false;    
    $("form[action*='deltrainer']").submit(function( event ) {
    if(del === false){
      event.preventDefault();
      del = confirm('Удалить тренера???');
        }
        if(del === true){
        this.submit();
        }
    del = false;
    return del;
    }); 
});
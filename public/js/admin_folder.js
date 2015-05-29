
$(document).ready(function() {
   
    if( ($("#opentab").text())!= '' ){
        var opentab = $("#opentab").text();
        if( opentab == 'addFolder' ){
            $("#addFolder").collapse('show');
            $("form[action*='addfolder'] textarea").focus();
            }
        else if( opentab.split('::')[0] == 'changeTitle'){
            $("#changeTitle").collapse('show');
            $("#change"+opentab.split('::')[1]).collapse('show');
            $("#newDescr_"+opentab.split('::')[1]).focus();
        }
        else{
        $("#addPhoto").collapse('show');
        $("#addPhoto"+opentab.split('::')[1]).collapse('show');
        }
    } 
    
    });
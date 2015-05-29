$(document).ready(function() {

$("#catNavAdmin li:first").addClass("active");
$("#subNavAdmin div.tab-pane:first").addClass("in active");

$("#catNavAdmin li a").click('on', function(){
    $("div[id^='goods'].active").removeClass("active");
    $("div[id^='cat']>ul>li.active").removeClass("active");
});
   
    if( ($("#opentab").text())!= '' ){
    var opentab = $("#opentab").text();
    alert(opentab);
    /*  var opentab = '#updatePost'+$("#opentab").text();
        var focusform = '"'+$("#opentab").text()+'[postTitle]"';
        $(opentab).collapse('show');
        $(opentab+' form textarea[name='+focusform+']').focus();   */
    } 

    var del = false;
    
    $("form[action*='delgood']").submit(function( event ) {
    if(del === false){
      event.preventDefault();
      del = confirm('Удалить товар???');
        }
        if(del === true){
        this.submit();
        }
    del = false;
    return del;
    });
        
});
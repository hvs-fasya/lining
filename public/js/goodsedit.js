
$(document).ready(function() {

$("#catNavAdmin li:first").addClass("active");
$("#subNavAdmin div.tab-pane:first").addClass("in active");

$("#catNavAdmin li a").click('on', function(){
    $("div[id^='goods'].active").removeClass("active");
    $("div[id^='cat']>ul>li.active").removeClass("active");
});
   
    if( ($("#opentab").text())!= '' ){
    var opentab = 'cat'+$("#opentab").text().split('::')[0];
    //var opentab = 'cat2';
    //alert(opentab);
    var opensub = $("#opentab").text().split('::')[1];
    var focusform = 'form'+$("#opentab").text().split('::')[2];
    $("#subNavAdmin div.tab-pane:first").removeClass("in active");
    $("ul[id='catNavAdmin']>li.active").removeClass("active");
    $("ul[id='catNavAdmin']>li").has("a[href='#"+opentab+"']").addClass('active');
    $("div.tab-pane[id="+opentab+"]").addClass('in active');
    $("div.tab-pane[id=goods"+opensub+"]").addClass('active');
    $("div[id="+focusform+"]").collapse('show');
    $('form input[id="goodArtikel_'+$("#opentab").text().split('::')[2]+'"]').focus();
    } 
    
    var set = false;    
    $("form[action*='goods/setsub']").submit(function( event ) {
    if(set === false){
      event.preventDefault();
      set = confirm('Назначить подкатегорию???');
        }
        if(set === true){
        this.submit();
        }
    set = false;
    return set;
    });   
});
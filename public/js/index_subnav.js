//√лавна¤ страница index.php
//включение табов подменю при выборе пунктов выпадающего списка "√Ћј¬Ќјя"

$(document).ready(function() {

    var pos = window.location.href.indexOf("?subnav=")+1
    var subnav = window.location.href.slice(pos+7)
    switch (subnav) {
    case 'news': $("#news").addClass('active in'); break
    case 'contacts': $("#contacts").addClass('active in'); break
    case 'lining': $("#li-ning").addClass('active in'); break
    default : $("#news").addClass('active in')
}
  
});
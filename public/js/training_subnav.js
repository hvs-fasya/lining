//Страница training.php
//включение табов подменю при выборе пунктов выпадающего списка "ТРЕНИРОВКИ"

$(document).ready(function() {

    var pos = window.location.href.indexOf("?subnav=")+1
    var subnav = window.location.href.slice(pos+7)
    switch (subnav) {
    case 'trainers': $("#trainers").addClass('in active'); break
    case 'ward': $("#ward").addClass('in active'); break
    case 'child': $("#child").addClass('in active'); break
    case 'individual': $("#individual").addClass('in active'); break
    case 'grownup': $("#grownup").addClass('in active'); break
    case 'shedule': $("#shedule").addClass('in active'); break
    case 'price': $("#price").addClass('in active'); break
    case 'lining': $("#li-ning").addClass('in active'); break
    default : $("#li-ning").addClass('in active')
}
  
});

/**
 * Created by leo on 18/04/17.
 * We use this in order to hide flash message after 3 seconds.
 */
$(function () {
    var alert = $('#flash-message');
    if(alert.length > 0){
        alert.hide().slideDown(300).delay(3000).slideUp();
    }
});
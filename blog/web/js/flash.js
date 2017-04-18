/**
 * Created by leo on 18/04/17.
 */
$(function () {
    var alert = $('#flash-message');
    if(alert.length > 0){
        alert.hide().slideDown(500).delay(3000).slideUp();
    }
});
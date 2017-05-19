/**
 * Created by leo on 19/05/17.
 * Contact : leo@grambert.fr
 */
$(function () {
    $('#allComment').change(function () {
        if($('#allComment').is(':checked') == true){
            $('.noReport').show();
        }
        else if($('#allComment').is(':checked') == false){
            $('.noReport').hide();
        }
    })
});
/**
 * Created by leo on 01/04/17.
 */
$(function(){

    $('.share').click(function() {
        var $url = document.location.href;
        var $html = "<div class='shareWindow'><img id='crossShare' src='../../web/img/cross.png' alt='cross_to_close'>Copiez le lien ci-dessous pour partager l'article<input type='text' class='input-field' value='"+$url+"'></div>";
        $('.share').after($html);
        $('#crossShare').click(function () {
            $('.shareWindow').remove();
        })
    });
    
});
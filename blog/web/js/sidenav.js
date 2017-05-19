/**
 * Created by leo on 08/05/17.
 * Contact : leo@grambert.fr
 */
//We use this in order to display admin sidenav on tablet and smartphone
$(function () {
    var $width = $(window).width();
        $('#hamburger').click(function(e){
            e.preventDefault();
            if ($width >= 767){
                $('.mdl-layout__drawer').css('left', '32%');
            } else if ($width < 767){
                $('.mdl-layout__drawer').css('left', '60%');
            }
            $('#hamburger').hide();
            $('main').click(function(e){
                e.preventDefault();
                $('.mdl-layout__drawer').css('left', '0');
                $('#hamburger').show();
            })
        });
});
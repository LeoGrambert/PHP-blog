/**
 * Created by leo on 18/04/17.
 * Used to display a modal in order to ask confirmation before deleting an article.
 */
$(function () {

    //We get article id
    $('.showButton').hover(function(e){
        e.preventDefault();
        var articleId = $(this).attr('id');
        articleId = articleId.split('-');

        //Function which open modal
        function showModal(){
            var id = '#modal-'+articleId[1];
            resizeModal();
            $('#background').show(200);
            $(id).show(400);
            $('.cancel').click(function (e) {
                e.preventDefault();
                hideModal();
            });
        }

        //Function which close modal
        function hideModal(){
            $('#background').hide(200);
            $('.popup').hide(200);
        }

        //Function which resize modal
        function resizeModal(){
            var modal = $('#modal-'+articleId[1]);
            var winH = $(document).height();
            var winW = $(window).width();
            $('#background').css({'width':winW,'height':winH});
            modal.css('top', winH/2.1 - modal.height()/2);
            modal.css('left', winW/4.5 - modal.width()/2);
            modal.css('marginBottom', '15%');
        }

        //The different actions (functions) when clicking on the elements
        $('#showButton-'+articleId[1]).click(function (e) {
            e.preventDefault();
            showModal();
        });

        $('#background').click(function () {
            hideModal();
        });

        $('.cancel').click(function () {
            hideModal();
        });

        $(window).resize(function () {
            resizeModal()
        });

    });
});
/**
 * Created by leo on 04/04/17.
 */
$(function () {
    //Display comment form when you click on reply button
    $('.reply').click(function (e) {
        e.preventDefault();
        var $form = $('#form-comment');
        var $this = $(this);
        var $parent_id = $this.data('id');
        var $comment = $('#comment-'+$parent_id);

        $('#parent_id').val($parent_id);
        $comment.after($form);
    });
});
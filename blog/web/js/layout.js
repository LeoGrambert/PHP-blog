/**
 * Created by leo on 29/03/17.
 */
Array.prototype.forEach.call(document.querySelectorAll('.mdl-card__media'), function(el) {
    var link = el.querySelector('a');
    if(!link) {
        return;
    }
    var target = link.getAttribute('href');
    if(!target) {
        return;
    }
    el.addEventListener('click', function() {
        location.href = target;
    });
});

// Initialize collapse button
$(".button-collapse").sideNav();


$('a[href^="#"]').click(function () {
    var the_id = $(this).attr("href");

    $('html, body').animate({
        scrollTop: $(the_id).offset().top
    }, 'slow');
    return false;
});

// Add return on top button
$('body').append('<div id="scroll" title="Retour en haut">&nbsp;</div>');

// On button click, let's scroll up to top
$('#scroll').click(function () {
    $('html,body').animate({scrollTop: 0}, 'slow');
});

$(window).scroll(function () {
    // If on top fade the bouton out, else fade it in
    if ($(window).scrollTop() == 0)
        $('#scroll').fadeOut();
    else
        $('#scroll').fadeIn();

});
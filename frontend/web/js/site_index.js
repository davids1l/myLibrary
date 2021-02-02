$(document).ready(function(){

    $(function voltarTopoFunction () {
        $(window).scroll(function () {
            if($(window).scrollTop() > 400) {
                $('#btnTopo').show();
            } else {
                $('#btnTopo').hide();
            }
        })
    });

    $('#btnTopo').click(function () {
        $('html, body').animate({scrollTop : 0}, 800);
    })

});
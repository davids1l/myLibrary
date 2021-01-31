$('.filtros-pesquisa').hide();

$(document).ready(function(){
    $("#pesquisaAvancada").on("click", function () {
        if($(".filtros-pesquisa").is(':visible')){
            if($("#mostrarFiltrosPesquisa").hasClass('fa-caret-down')){
                $("#mostrarFiltrosPesquisa").toggleClass('fa-caret-up');
            } else {
                $("#mostrarFiltrosPesquisa").toggleClass('fa-caret-down');
            }

            $('.filtros-pesquisa').hide();

        } else if ($(".filtros-pesquisa").not(':visible')) {
            $("#mostrarFiltrosPesquisa").toggleClass('fa-caret-up');
            $('.filtros-pesquisa').show();
        }
    });

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

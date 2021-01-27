//Mostrar mais sinopse
$(document).ready(function () {
    var sizeofsinopse = $(".sinopse_more").text().length;

    if (sizeofsinopse > 800){
        $('.sinopse_more').hide();
    } else {
        $(".sinopse_less").hide();
        $(".mostrarmais").hide();
    }
});

$(".mostrarmais").on("click", function () {
    if($(".sinopse_more").is(':visible')){
        $(".mostrarmais").text('Mostrar mais');
        $('.sinopse_more').hide();
        $(".sinopse_less").show();
    } else if ($(".sinopse_less").is(':visible')) {
        $(".mostrarmais").text('Mostrar menos');
        $('.sinopse_more').show();
        $(".sinopse_less").hide();
    }
});


//Animação para o scroll dos detalhes dos livros
$('a').on('click', function (event) {

    if (this.hash !== "") {
        event.preventDefault();

        var hash = this.hash;

        $('html, body').animate({
            scrollTop: $(hash).offset().top
        }, 800, function () {

            window.location.hash = hash;
        });
    }
});

//Animação para o botão de favorito
var btnFav = document.querySelector('.fa-heart');

btnFav.addEventListener('houver', function () {
   btnFav.classList.toggle('btnFav');
});

/*$('fa-heart').on('click', function () {
    toggleClass('')
});*/




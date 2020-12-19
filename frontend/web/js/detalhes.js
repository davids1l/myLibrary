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


jQuery(function () {

    var sinopsep = $('p.sinopse');

    sinopsep.each(function () {
        var sinopse = $(this).text();
        if (sinopse.length < 400) return;

        $(this).html(
            sinopse.slice(0, 800)+'<span>... </span><a href="#" class="mais"> (mostrar mais)</a>'+
            '<span style="display: none;">'+ sinopse.slice(800, sinopse.length)+'<a href="#" class="menos">(mostrar menos)</a></span>'
        );
    });

    $('a.mais', sinopsep).click(function(event){
        event.preventDefault();
        $(this).hide().prev().hide();
        $(this).next().show();
    });

    $('a.menos', sinopsep).click(function(event){
        event.preventDefault();
        $(this).parent().hide().prev().show().prev().show();
    });
});




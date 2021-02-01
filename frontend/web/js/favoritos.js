$(function() {
    $('.dropdown').change(function() {
        $('#listarFavoritos').submit();
        var index = $('.dropdown').val();
        $('.dropdown').prop(index, true);
    });
});
$(document).ready(function () {
    $(".navbar-toggler").click(function (event) {
        event.stopPropagation();
        $('#menu-dashboard').toggle();
    });
    $(window).resize(function () {
        $("#menu-dashboard").hide();
    });
    $('body,html').click(function (e) {
        var container = $("#menu-dashboard");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
        }
    });
    $('.dropdown-menu li img').click(function () {
        let value = $('#url-image');
        value.val($(this).attr('src'));
        $('#image-selecionar').attr("src", value.val());
    });

    $('#gridImagens div img').click(function () {
        let value = $('#url-image2');
        value.val($(this).attr('src'));
        $('#image-selecionar2').attr("src", value.val());
    });
});
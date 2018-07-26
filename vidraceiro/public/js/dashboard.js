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
        $('img').removeClass('thumbnail');
        $(this).addClass('thumbnail');
    });


    $('#select-categoria').change(function () {
        let valueSelected = $('#select-categoria option:selected').val();
        let boxdiversos = $('#boxdiversos');
        let boxpadrao = $('#boxpadrao');
        let ferragem1000 = $('#ferragem1000');
        let ferragem3000 = $('#ferragem3000');
        let selecionecategoria = $('#selecione-categoria');
        selecionecategoria.css("display", "none");
        boxdiversos.css("display", "none");
        boxpadrao.css("display", "none");
        ferragem1000.css("display", "none");
        ferragem3000.css("display", "none");

        switch (valueSelected) {
            case "boxdiversos":
                boxdiversos.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                });
                break;
            case "boxpadrao":
                boxpadrao.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                });
                break;
            case "ferragem1000":
                ferragem1000.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                });

                break;
            case "ferragem3000":
                ferragem1000.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                });
                break;
            default:
                selecionecategoria.css("display", "block");
                break;
        }
    });


    // $('#form-product').on('submit',function (e) {
    //     e.preventDefault();
    //     // let formData = $('form').serializeArray();
    //     // $.ajax({
    //     //     type: "POST",
    //     //     url: window.location.href,
    //     //     data: {formData, "_token": $('#_token').val()},
    //     //     success: function( ) {
    //     //         alert('sucesso');
    //     //     },
    //     // });
    //
    // });
});
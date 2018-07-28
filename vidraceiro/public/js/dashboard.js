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
    // $('.dropdown-menu li img').click(function () {
    //     let value = $('#url-image');
    //     value.val($(this).attr('src'));
    //     $('#image-selecionar').attr("src", value.val());
    // });

    $('#gridImagens div img').click(function () {
        let value = $('#url-image');
        value.val($(this).attr('src'));
        $('#image-selecionar').attr("src", value.val());
        $('img').removeClass('thumbnail');
        $(this).addClass('thumbnail');
    });


    $('#select-categoria').change(function () {
        let base_url = window.location.protocol + "//" + window.location.host;
        base_url = base_url + "/img/semimagem.png";
        $('#url-image').val(base_url);
        $('#image-selecionar').attr("src", base_url);
        $('#gridImagens div img').removeClass('thumbnail');
        let valueSelected = $('#select-categoria option:selected').val();
        let boxdiversos = $('#boxdiversos');
        let boxpadrao = $('#boxpadrao');
        let ferragem1000 = $('#ferragem1000');
        let ferragem3000 = $('#ferragem3000');
        let kitsacada = $('#kitsacada');
        let selecionecategoria = $('#selecione-categoria');
        selecionecategoria.css("display", "none");
        boxdiversos.css("display", "none");
        boxpadrao.css("display", "none");
        ferragem1000.css("display", "none");
        ferragem3000.css("display", "none");
        kitsacada.css("display", "none");

        switch (valueSelected) {
            case "boxdiversos":
                boxdiversos.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });
                break;
            case "boxpadrao":
                boxpadrao.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });
                break;
            case "ferragem1000":
                ferragem1000.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });

                break;
            case "ferragem3000":
                ferragem1000.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });
                break;
            case "kitsacada":
                kitsacada.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });
                break;
            default:
                selecionecategoria.css("display", "block");
                break;
        }
    });
    $('#bt-material').attr("href",'/materials/create/?tipo=vidro');

    $('#bt-create-user').click(function () {
       $('#botao-create-user').click();
    });
    $('#bt-create-category').click(function () {
        $('#botao-create-category').click();
    });

    $('#nav-Orçamento-tab').click(function () {
        changeTextBtBudget("Salvar");
    });

    $('#nav-Editar-tab').click(function () {
        changeTextBtBudget("Salvar");
    });

    $('#nav-Adicionar-tab').click(function () {
        changeTextBtBudget("Salvar");
    });

    $('#nav-Material-tab').click(function () {
        changeTextBtBudget("Salvar");
    });

    $('#nav-Total-tab').click(function () {
        changeTextBtBudget("Gerar PDF");
    });


    $('#nav-adicionar-Vidros-tab').click(function () {
        $('#bt-material').attr("href",'/materials/create/?tipo=vidro');
    });
    $('#nav-adicionar-Aluminios-tab').click(function () {
        $('#bt-material').attr("href",'/materials/create/?tipo=aluminio');
    });
    $('#nav-adicionar-Componentes-tab').click(function () {
        $('#bt-material').attr("href",'/materials/create/?tipo=componente');
    });

    function changeTextBtBudget($texto) {
        $('#bt-budget-pdf').text($texto);
    }
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
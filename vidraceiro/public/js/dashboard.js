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
    $('#bt-material').attr("href", '/materials/glass/create');

    $('#bt-user-visible').click(function () {
        $('#bt-user-invisible').click();
    });
    $('#bt-category-visible').click(function () {
        $('#bt-category-invisible').click();
    });

    // forms dos materiais
    $('#bt-glass-visible').click(function () {
        $('#bt-glass-invisible').click();
    });

    $('#bt-aluminum-visible').click(function () {
        $('#bt-aluminum-invisible').click();
    });

    $('#bt-component-visible').click(function () {
        $('#bt-component-invisible').click();
    });
    // fim dos materiais

    $('#bt-order-visible').click(function () {
        let input = $('.id_orcamento').val();
        if (input) {
            $('#bt-order-invisible').click();
        } else {
            mensagemAlerta('Adicione um orçamento a ordem de serviço');
        }

    });

    //inicio produto form
    $('#bt-product-visible').click(function () {
        if ($('#nav-Produto-tab').hasClass('active')) {
            //form tab produto
            $('#bt-produto-product-invisible').click();
        } else {
            //form tab material
            $('#bt-material-product-invisible').click();
        }
    });
    //fim produto form

    //inicio orçamento form
    $('#bt-budget-visible').click(function () {

        switch (true) {
            case $('#nav-Orçamento-tab').hasClass('active'):

                $('#bt-orcamento-budget-invisible').click();

                break;
            case $('#nav-Editar-tab').hasClass('active'):

                $('#bt-edit-budget-invisible').click();

                break;
            case $('#nav-Adicionar-tab').hasClass('active'):

                $('#bt-add-budget-invisible').click();

                break;
            case $('#nav-Material-tab').hasClass('active'):

                $('#bt-material-budget-invisible').click();

                break;
            case $('#nav-Total-tab').hasClass('active'):

                $('#bt-total-budget-invisible').click();

                break;
        }

    });
    //fim orçamento form


    $('#bt-provider-visible').click(function () {
        $('#bt-provider-invisible').click();
    });

    $('#bt-company-visible').click(function () {
        $('#bt-company-invisible').click();
    });

    $('#bt-pdf-visible').click(function () {
        $('#bt-pdf-invisible').click();
    });


    $('#nav-Vidros-tab').click(function () {
        $('#bt-material').attr("href", '/materials/glass/create');
    });
    $('#nav-Aluminios-tab').click(function () {
        $('#bt-material').attr("href", '/materials/aluminum/create');
    });
    $('#nav-Componentes-tab').click(function () {
        $('#bt-material').attr("href", '/materials/component/create');
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


    function changeTextBtBudget($texto) {
        $('#bt-budget-visible').text($texto);
    }

    //codigo para atualzar tabela ordem de serviço
    let button = document.getElementsByClassName("deletar-tabela");
    for (let i = 0; i < button.length; i++) {
        button[i].addEventListener('click', function (e) {
            let valorTotal = $('#total');
            let total = parseInt($('#option-' + e.target.id).attr('name'));
            valorTotal.val(parseFloat(parseInt(valorTotal.val()) - total).toFixed(2));
            $('#' + e.target.id).remove();
            $('.' + e.target.id).remove();
        }, false);
    }


    $('#bt-add-orcamento-order').click(function () {
        let idorcamento = $('#select-orcamentos').val();
        let nomeorcamento = $('#select-orcamentos option:selected').text();
        let totalorcamento = $('#select-orcamentos option:selected').attr('name');
        let idorcamentoinput = $('.id_orcamento').attr('value');
        let table = $('tbody');
        let pegaIdLinha = $('#linha-' + idorcamento).attr('id');
        let criaid = 'linha-' + idorcamento;
        if (idorcamento.length === 0) {
            mensagemAlerta('Selecione um orçamento para adicionar!');
        } else if (idorcamentoinput !== idorcamento && pegaIdLinha !== criaid) {
            $('#ids').append(
                '<input type="number" class="id_orcamento ' + criaid + '" name="id_orcamento[]" value="' + idorcamento + '" style="display: none;" />' +
                '');
            table.append(
                '<tr id="' + criaid + '">' +
                '<th scope="row">' + idorcamento + '</th>' +
                '<td>' + nomeorcamento + '</td>' +
                '<td>' + totalorcamento + '</td>' +
                '<td>' +
                "<button id=" + criaid + " class='deletar-tabela btn btn-danger mb-1' type='button'>Delete</button>" +
                "</td>" +
                "</tr>"
            );
            let total = parseFloat($('#option-linha-' + idorcamento).attr('name'));
            let valorTotal = $('#total');
            let inputTotal = isNaN(parseFloat(valorTotal.val())) ? 0 : parseFloat(valorTotal.val());
            valorTotal.val(parseFloat(inputTotal + total).toFixed(2));
            let button = document.getElementsByClassName("deletar-tabela");
            for (let i = 0; i < button.length; i++) {
                button[i].addEventListener('click', function (e) {
                    if (e.target.id === criaid) {
                        valorTotal.val(parseFloat(valorTotal.val()).toFixed(2) - total);
                        $('#' + criaid).remove();
                        $('.' + criaid).remove();
                    }
                }, false);
            }

        } else {
            mensagemAlerta('Orçamento ja foi adicionado!');
        }

    });


    function mensagemAlerta(mensagem) {
        $('#alertaMensagem').text(mensagem);
        $('#bt-alert-modal').click();
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
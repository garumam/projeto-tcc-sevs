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
        let imagem = $(this).attr('src');
        let value = $('#url-image');
        let imgpath = imagem.substring(imagem.lastIndexOf('img/'),imagem.length);
        value.val(imgpath);
        $('#image-selecionar').attr("src", imagem);
        $('img').removeClass('thumbnail');
        $(this).addClass('thumbnail');
    });


    $('#select-categoria').change(function () {
        let base_url = "img/semimagem.png";
        $('#url-image').val(base_url);
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
            case '6':
            case '1':
                boxdiversos.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });
                if (valueSelected != '6')
                    break;
            case '2':
                boxpadrao.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });
                if (valueSelected != '6')
                    break;
            case '3':
                ferragem1000.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });

                if (valueSelected != '6')
                    break;
            case '4':
                ferragem3000.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });
                if (valueSelected != '6')
                    break;
            case '5':
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
    $('#select-categoria').trigger('change');

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
            let total = $('#option-' + e.target.id).attr('name');
            valorTotal.val(parseFloat(parseFloat(valorTotal.val()) - total).toFixed(2));
            $('#' + e.target.id).remove();
            $('.' + e.target.id).remove();
        }, false);
    }

    $('#bt-add-material-mproduct').click(function () {
        let selectvidro = $('#select-vidro');
        let selectaluminio = $('#select-aluminio');
        let selectcomponente = $('#select-componente');
        if (selectvidro.is(":visible")){
            alert("vidro visivel");
        }
        if (selectaluminio.is(":visible")){
            alert("aluminio visivel");
        }
        if (selectcomponente.is(":visible")){
            alert("componente visivel");
        }
    });

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
            let total = $('#option-linha-' + idorcamento).attr('name');
            let valorTotal = $('#total');
            let inputTotal = isNaN(parseFloat(valorTotal.val())) ? 0 : parseFloat(valorTotal.val());
            valorTotal.val(parseFloat(inputTotal + parseFloat(total)).toFixed(2));
            let button = document.getElementsByClassName("deletar-tabela");
            for (let i = 0; i < button.length; i++) {
                button[i].addEventListener('click', function (e) {
                    if (e.target.id === criaid) {
                        valorTotal.val(parseFloat(parseFloat(valorTotal.val()) - total).toFixed(2));
                        $('#' + criaid).remove();
                        $('.' + criaid).remove();
                    }
                }, false);
            }

        } else {
            mensagemAlerta('Orçamento ja foi adicionado!');
        }

    });

    $('#select-material').change(function (e) {
        let selecionado = $('#select-material option:selected').val();
        let label = $('#label_categoria');

        switch (selecionado) {
            case '0':
                label.text('Vidros');
                $('.titulo').text('Vidros');
                $('#select-vidro').show();
                $('#select-componente').hide();
                $('#select-aluminio').hide();
                $('#topo-vidro').show();
                $('#topo-aluminio').hide();
                $('#topo-componente').hide();
                $('#tabela-vidro').show();
                $('#tabela-aluminio').hide();
                $('#tabela-componente').hide();
                break;
            case '1':
                label.text('Aluminios');
                $('.titulo').text('Aluminios');
                $('#select-vidro').hide();
                $('#select-componente').hide();
                $('#select-aluminio').show();
                $('#topo-vidro').hide();
                $('#topo-aluminio').show();
                $('#topo-componente').hide();
                $('#tabela-vidro').hide();
                $('#tabela-aluminio').show();
                $('#tabela-componente').hide();
                break;
            case '2':
                label.text('Componentes');
                $('.titulo').text('Componentes');
                $('#select-vidro').hide();
                $('#select-componente').show();
                $('#select-aluminio').hide();
                $('#topo-vidro').hide();
                $('#topo-aluminio').hide();
                $('#topo-componente').show();
                $('#tabela-vidro').hide();
                $('#tabela-aluminio').hide();
                $('#tabela-componente').show();
                break;
        }
    });

    $('#select-tipo-produto').change(function (e) {
        let categoryselected = $('#select-tipo-produto option:selected').val();

        $('.mprodutos-options').each(function () {

            if (categoryselected == $(this).data('categoria')) {
                $(this).show();
            } else {
                $('#option-vazia').prop('selected', true);
                trocarImagem($('#image-mproduto'), 'img/semimagem.png');
                $('#descricao-mprod').val('');
                $(this).hide();
            }
        })

    });

    $('#select-mproduto').change(function (e) {
        let pathimg;
        let descricao;
        if ($('#select-mproduto').val() != "") {
            pathimg = $('#select-mproduto option:selected').data('image');
            descricao = $('#select-mproduto option:selected').data('descricao');
        } else {
            pathimg = 'img/semimagem.png';
            descricao = '';
        }
        trocarImagem($('#image-mproduto'), pathimg);
        $('#descricao-mprod').val(descricao);
    });


    function trocarImagem(imgcontainer, imgpath) {
        let base_url = window.location.protocol + "//" + window.location.host;
        base_url = base_url + "/" + imgpath;
        imgcontainer.attr("src", base_url);
    }


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
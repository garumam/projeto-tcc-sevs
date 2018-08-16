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

    $('#gridImagens div img').click(function () {
        let imagem = $(this).attr('src');
        let value = $('#url-image');
        value.val(imagem);
        $('#image-selecionar').attr("src", imagem);
        $('img').removeClass('thumbnail');
        $(this).addClass('thumbnail');
    });

    var contadorCategoria = 0;

    $('#select-categoria').change(function () {
        let base_url = "/img/semimagem.png";
        let imagemselecionar = $('#image-selecionar');

        if (imagemselecionar.attr('src') !== base_url && imagemselecionar.data('produto') === false) {
            $('#url-image').val(base_url);
            $('#image-selecionar').attr("src", base_url);
        } else {
            contadorCategoria++;
            if (contadorCategoria !== 1) {
                $('#url-image').val(base_url);
                $('#image-selecionar').attr("src", base_url);
            }else{
                $('#url-image').val(imagemselecionar.attr('src'));
            }
        }

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

    $('tbody').on('click', '.deletar-material-tabela', function (e) {
        alert(e.target.id);
        $('#' + e.target.id).remove();
        $('.' + e.target.id).remove();
    });

    $('tbody').on('click', '.deletar-orcamento-tabela', function (e) {
        let valorTotal = $('#total');
        let total = $('#option-' + e.target.id).attr('name');
        valorTotal.val(parseFloat(parseFloat(valorTotal.val()) - total).toFixed(2));
        $('#' + e.target.id).remove();
        $('.' + e.target.id).remove();
    });

    var contador = 1;

    $('#bt-add-material-mproduct').click(function () {
        let selectvidro = $('#select-vidro');
        let selectaluminio = $('#select-aluminio');
        let selectcomponente = $('#select-componente');
        let idselect, nomeselect, tbody, pegaIdLinha, criaId;
        let idinput;
        let produtoselecionado = $('#select-produto-material option:selected').val();
        if (produtoselecionado == '') {
            mensagemAlerta('Selecione um produto!');
        } else {
            produtoselecionado = produtoselecionado != undefined ? produtoselecionado : '';
            if (selectvidro.is(":visible")) {
                if (selectvidro.val().length !== 0) {
                    idselect = selectvidro.val();
                    nomeselect = selectvidro.find('option:selected').text();
                    let precovidro = selectvidro.find('option:selected').data('preco');
                    let comparador = selectvidro.find('option:selected').data('comparador');
                    let inputcomparar = $('#' + comparador);
                    tbody = $('#tabela-vidro');
                    criaId = 'linha-vidro-' + idselect;
                    if (inputcomparar.val() == undefined) {
                        $('#ids').append(
                            '<input id="' + comparador + '" type="number" class="id-material ' + criaId + '" name="id_vidro_' + produtoselecionado + '[]" value="' + idselect + '" style="display: none;" />' +
                            '');
                        tbody.append(
                            '<tr id="' + criaId + '" data-produtoid="' + produtoselecionado + '">' +
                            '<th scope="row">' + idselect + '</th>' +
                            '<td>' + nomeselect + '</td>' +
                            '<td>' + 'R$' + precovidro + '</td>' +
                            '<td>' +
                            "<button id=" + criaId + " class='deletar-material-tabela btn btn-danger mb-1' type='button'>Delete</button>" +
                            "</td>" +
                            "</tr>"
                        );
                    } else {
                        mensagemAlerta('Material ja foi adicionado!');
                        //     contador = tbody.find('tr').length + 1;
                        //     criaId = 'linha-vidro-' + idselect + '-' + contador++;
                        //     $('#ids').append(
                        //         '<input type="number" class="id-material ' + criaId + '" name="id_vidro_' + produtoselecionado + '[]" value="' + idselect + '" style="display: none;" />' +
                        //         '');
                        //     tbody.append(
                        //         '<tr id="' + criaId + '" data-produtoid="' + produtoselecionado + '">' +
                        //         '<th scope="row">' + idselect + '</th>' +
                        //         '<td>' + nomeselect + '</td>' +
                        //         '<td>' + 'R$' + precovidro + '</td>' +
                        //         '<td>' +
                        //         "<button id=" + criaId + " class='deletar-material-tabela btn btn-danger mb-1' type='button'>Delete</button>" +
                        //         "</td>" +
                        //         "</tr>"
                        //     );
                    }
                } else {
                    mensagemAlerta('Selecione um material para adicionar!');
                }

            }
            if (selectaluminio.is(":visible")) {

                if (selectaluminio.val().length !== 0) {
                    idselect = selectaluminio.val();
                    nomeselect = selectaluminio.find('option:selected').text();
                    idinput = $('.id-material-aluminio').attr('value');
                    let medida = selectaluminio.find('option:selected').data('medida');
                    let peso = selectaluminio.find('option:selected').data('peso');
                    let precoaluminio = selectaluminio.find('option:selected').data('preco');
                    tbody = $('#tabela-aluminio');
                    pegaIdLinha = $('#linha-aluminio-' + idselect).attr('id');
                    criaId = 'linha-aluminio-' + idselect + '-' + contador++;
                    if (idinput !== idselect && pegaIdLinha !== criaId) {
                        $('#ids').append(
                            '<input type="number" class="id-material ' + criaId + '" name="id_aluminio_' + produtoselecionado + '[]" value="' + idselect + '" style="display: none;" />' +
                            '');
                        tbody.append(
                            '<tr id="' + criaId + '" data-produtoid="' + produtoselecionado + '">' +
                            '<th scope="row">' + idselect + '</th>' +
                            '<td>' + nomeselect + '</td>' +
                            '<td>' + medida + '</td>' +
                            '<td>' + peso + '</td>' +
                            '<td>' + 'R$' + precoaluminio + '</td>' +
                            '<td>' +
                            "<button id=" + criaId + " class='deletar-material-tabela btn btn-danger mb-1' type='button'>Delete</button>" +
                            "</td>" +
                            "</tr>"
                        );
                    } else {
                        // mensagemAlerta('Material ja foi adicionado!');
                        contador = tbody.find('tr').length + 1;
                        criaId = 'linha-aluminio-' + idselect + '-' + contador++;
                        $('#ids').append(
                            '<input type="number" class="id-material ' + criaId + '" name="id_aluminio_' + produtoselecionado + '[]" value="' + idselect + '" style="display: none;" />' +
                            '');
                        tbody.append(
                            '<tr id="' + criaId + '" data-produtoid="' + produtoselecionado + '">' +
                            '<th scope="row">' + idselect + '</th>' +
                            '<td>' + nomeselect + '</td>' +
                            '<td>' + medida + '</td>' +
                            '<td>' + peso + '</td>' +
                            '<td>' + 'R$' + precoaluminio + '</td>' +
                            '<td>' +
                            "<button id=" + criaId + " class='deletar-material-tabela btn btn-danger mb-1' type='button'>Delete</button>" +
                            "</td>" +
                            "</tr>"
                        );
                    }
                } else {
                    mensagemAlerta('Selecione um material para adicionar!');
                }

            }
            if (selectcomponente.is(":visible")) {

                if (selectcomponente.val().length !== 0) {
                    idselect = selectcomponente.val();
                    nomeselect = selectcomponente.find('option:selected').text();
                    idinput = $('.id-material-componente').attr('value');
                    let qtd = selectcomponente.find('option:selected').data('qtd');
                    let precocomponente = selectcomponente.find('option:selected').data('preco');
                    tbody = $('#tabela-componente');
                    pegaIdLinha = $('#linha-componente-' + idselect).attr('id');
                    criaId = 'linha-componente-' + idselect + '-' + contador++;
                    if (idinput !== idselect && pegaIdLinha !== criaId) {
                        $('#ids').append(
                            '<input type="number" class="id-material ' + criaId + '" name="id_componente_' + produtoselecionado + '[]" value="' + idselect + '" style="display: none;" />' +
                            '');
                        tbody.append(
                            '<tr id="' + criaId + '" data-produtoid="' + produtoselecionado + '">' +
                            '<th scope="row">' + idselect + '</th>' +
                            '<td>' + nomeselect + '</td>' +
                            '<td>' + 'R$' + precocomponente + '</td>' +
                            '<td>' + qtd + '</td>' +
                            '<td>' +
                            "<button id=" + criaId + " class='deletar-material-tabela btn btn-danger mb-1' type='button'>Delete</button>" +
                            "</td>" +
                            "</tr>"
                        );
                    } else {
                        // mensagemAlerta('Material ja foi adicionado!');
                        contador = tbody.find('tr').length + 1;
                        criaId = 'linha-componente-' + idselect + '-' + contador++;
                        $('#ids').append(
                            '<input type="number" class="id-material ' + criaId + '" name="id_componente_' + produtoselecionado + '[]" value="' + idselect + '" style="display: none;" />' +
                            '');
                        tbody.append(
                            '<tr id="' + criaId + '" data-produtoid="' + produtoselecionado + '">' +
                            '<th scope="row">' + idselect + '</th>' +
                            '<td>' + nomeselect + '</td>' +
                            '<td>' + 'R$' + precocomponente + '</td>' +
                            '<td>' + qtd + '</td>' +
                            '<td>' +
                            "<button id=" + criaId + " class='deletar-material-tabela btn btn-danger mb-1' type='button'>Delete</button>" +
                            "</td>" +
                            "</tr>"
                        );
                    }
                } else {
                    mensagemAlerta('Selecione um material para adicionar!');
                }
            }
        }
    });

    $('#bt-add-orcamento-order').click(function () {
        let idorcamento = $('#select-orcamentos').val();
        let nomeorcamento = $('#select-orcamentos option:selected').text();
        let totalorcamento = $('#select-orcamentos option:selected').attr('name');
        let idorcamentoinput = $('.id_orcamento').attr('value');
        let table = $('tbody');
        let pegaIdLinha = $('#linha-' + idorcamento).attr('id');
        let criaId = 'linha-' + idorcamento;
        if (idorcamento.length === 0) {
            mensagemAlerta('Selecione um orçamento para adicionar!');
        } else if (idorcamentoinput !== idorcamento && pegaIdLinha !== criaId) {
            $('#ids').append(
                '<input type="number" class="id_orcamento ' + criaId + '" name="id_orcamento[]" value="' + idorcamento + '" style="display: none;" />' +
                '');
            table.append(
                '<tr id="' + criaId + '">' +
                '<th scope="row">' + idorcamento + '</th>' +
                '<td>' + nomeorcamento + '</td>' +
                '<td>' + totalorcamento + '</td>' +
                '<td>' +
                "<button id=" + criaId + " class='deletar-orcamento-tabela btn btn-danger mb-1' type='button'>Delete</button>" +
                "</td>" +
                "</tr>"
            );
            let total = $('#option-linha-' + idorcamento).attr('name');
            let valorTotal = $('#total');
            let inputTotal = isNaN(parseFloat(valorTotal.val())) ? 0 : parseFloat(valorTotal.val());
            valorTotal.val(parseFloat(inputTotal + parseFloat(total)).toFixed(2));
            // let button = document.getElementsByClassName("deletar-orcamento-tabela");
            // for (let i = 0; i < button.length; i++) {
            //     button[i].addEventListener('click', function (e) {
            //         if (e.target.id === criaId) {
            //             valorTotal.val(parseFloat(parseFloat(valorTotal.val()) - total).toFixed(2));
            //             $('#' + criaId).remove();
            //             $('.' + criaId).remove();
            //         }
            //     }, false);
            // }

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
                trocarImagem($('#image-mproduto'), '/img/semimagem.png');
                $('#descricao-mprod').val('');
                $(this).hide();
            }
        });

    });

    $('#select-mproduto').change(function (e) {
        let pathimg;
        let descricao;
        if ($('#select-mproduto').val() != "") {
            pathimg = $('#select-mproduto option:selected').data('image');
            descricao = $('#select-mproduto option:selected').data('descricao');
        } else {
            pathimg = '/img/semimagem.png';
            descricao = '';
        }
        trocarImagem($('#image-mproduto'), pathimg);
        $('#descricao-mprod').val(descricao);
    });


    $('#select-produto-edit').change(function (e) {
        let produtoselecionado = $('#select-produto-edit option:selected');
        let altura, largura, imagem, descricao, qtd, localizacao, maoObra;

        if (produtoselecionado.val() != "") {

            imagem = produtoselecionado.data('image');
            descricao = produtoselecionado.data('descricao');
            altura = produtoselecionado.data('altura');
            largura = produtoselecionado.data('largura');
            qtd = produtoselecionado.data('qtd');
            localizacao = produtoselecionado.data('localizacao');
            maoObra = produtoselecionado.data('valor_mao_obra');

        } else {
            imagem = '/img/semimagem.png';
            descricao = altura = largura = qtd = localizacao = maoObra = '';
        }

        $('#image-produto-editar').attr('src', imagem);
        $('#descricao-edit').val(descricao);
        $('#altura-edit').val(altura);
        $('#largura-edit').val(largura);
        $('#qtd-edit').val(qtd);
        $('#localizacao-edit').val(localizacao);
        $('#valor_mao_obra-edit').val(maoObra);

    });

    $('#select-produto-material').change(function (e) {
        let produtoselecionado = $('#select-produto-material option:selected');
        let imagem;

        if (produtoselecionado.val() != "") {
            imagem = produtoselecionado.data('image');
        } else {
            imagem = '/img/semimagem.png';
        }

        $('#image-produto-material').attr('src', imagem);

        linhaProdutoAtualiza($('#tabela-vidro').find('tr'), produtoselecionado);
        linhaProdutoAtualiza($('#tabela-aluminio').find('tr'), produtoselecionado);
        linhaProdutoAtualiza($('#tabela-componente').find('tr'), produtoselecionado);

    });

    function linhaProdutoAtualiza(tr, produtoselecionado) {
        tr.each(function () {
            if ($(this).data('produtoid') == produtoselecionado.val()) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    function trocarImagem(imgcontainer, imgpath) {
        imgcontainer.attr("src", imgpath);
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
$(document).ready(function () {

    $('#opensubmenu ul li').each(function () {
        let ativo = $(this).attr("class");
        if (ativo === "active"){
            $('#opensubmenu').css('height',"auto");
            $('.submenu').slideToggle("slow");
        }
    });
    $('#opensubmenu a').click(function () {
        $('#opensubmenu').css('height',"auto");
        $('.submenu').slideToggle("slow");
    });



    //Adicionar procura nas tabelas e modificando mensagens
    $('.search-table').each(function(){
        $('#htmlqtditens_search').remove();
        $('#htmlqtditens_pagination').remove();
        $(this).DataTable({
            language: {
                search: "Procurar:",
                lengthMenu:    "Mostrar _MENU_ itens",
                info:           "",
                infoEmpty:      "",
                infoFiltered:   "",
                infoPostFix:    "",
                loadingRecords: "Chargement en cours...",
                zeroRecords:    "Nenhum item encontrado com esses termos!",
                emptyTable:     "Nenhum item cadastrado!",
                paginate: {
                    first:      "Primeira",
                    previous:   "Anterior",
                    next:       "Próxima",
                    last:       "Última"
                },
                aria: {
                    sortAscending:  "",
                    sortDescending: ""
                }
            }
        });
    });

    //Iniciando selects com search dentro
    $('.form-control-chosen').chosen({
        // Chosen options here
    });


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
            } else {
                $('#url-image').val(imagemselecionar.attr('src'));
            }
        }

        $('#gridImagens div img').removeClass('thumbnail');
        let valueSelected = $('#select-categoria option:selected').data('grupoimagem');
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
            case 'todasimagens':
            case 'boxdiversos':
                boxdiversos.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });
                if (valueSelected != 'todasimagens')
                    break;
            case 'boxpadrao':
                boxpadrao.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });
                if (valueSelected != 'todasimagens')
                    break;
            case 'ferragem1000':
                ferragem1000.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });

                if (valueSelected != 'todasimagens')
                    break;
            case 'ferragem3000':
                ferragem3000.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });
                if (valueSelected != 'todasimagens')
                    break;
            case 'kitsacada':
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

    $('#bt-client-visible').click(function () {

        if($('#nome').val().length !== 0
            && $('#cep').val().length === 9
            && ($('#cpf').val().length === 14 || $('#cnpj').val().length === 18)){
            $('#cep').unmask();
            $('#cpf').unmask();
            $('#cnpj').unmask();
            $('#telefone').unmask();
            $('#celular').unmask();

            $('#bt-client-invisible').click();
        }else{
            if(($('#cpf').val().length === 14 || $('#cnpj').val().length === 18)){
                $('#bt-client-invisible').click();
            }else{
                $('#erro-js').attr('class','alert alert-danger');
                $('#erro-js').text('Documento fornecido é inválido');
            }
        }



    });

    $('#bt-sale-visible').click(function () {
        if($('#select-orcamento-venda').val() !== ''){
            $('#bt-sale-invisible').click();
        }else{
            $('#erro-js').attr('class','alert alert-danger');
            $('#erro-js').text('Selecione um orçamento');
        }

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

                if($('#nome').val().length !== 0 && $('#cep').val().length === 9){
                    $('#cep').unmask();
                    $('#telefone').unmask();
                }

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

    //inicio orcamento troca de tab esconder botão delete
    $('.tabs-budget').each(function (index) {
        $(this).on("click", function () {

            if ($('#nav-Editar-tab').attr('id') == $(this).attr('id') && !$(this).hasClass('disabled')) {
                $('.bt-budget-deletar-produto').show();
            } else {
                $('.bt-budget-deletar-produto').hide();
            }

        });
    });
    //fim orcamento troca de tab esconder botão delete


    $('#bt-provider-visible').click(function () {
        if($('#nome').val().length !== 0)
        {
            if($('#cep').val().length === 9){
                $('#cep').unmask();
                $('#telefone').unmask();
                $('#cnpj').unmask();
                $('#celular').unmask();
            }

        }


        $('#bt-provider-invisible').click();
    });

    $('#bt-company-visible').click(function () {
        if($('#nome').val().length !== 0
            && $('#endereco').val().length !== 0
            && $('#cidade').val().length !== 0
            && $('#bairro').val().length !== 0
            && $('#uf').val().length !== 0
            && $('#email').val().length !== 0
            && $('#telefone').val().length !== 0){

            $('#cep').unmask();
            $('#telefone').unmask();
        }


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
        //Todos as variaveis terminadas com false são os selects do plugin chosen
        //O select real fica invisivel, mas ainda funcional por isso os selectvidro,
        //selectaluminio e selectcomponente ainda existem
        let selectvidro = $('#select-vidro');
        let selectvidrofalse = $('#select_vidro_chosen');
        let selectaluminio = $('#select-aluminio');
        let selectaluminiofalse = $('#select_aluminio_chosen');
        let selectcomponente = $('#select-componente');
        let selectcomponentefalse = $('#select_componente_chosen');
        let idselect, nomeselect, tbody, pegaIdLinha, criaId;
        let idinput;
        let produtoselecionado = $('#select-produto-material option:selected').val();
        if (produtoselecionado == '') {
            mensagemAlerta('Selecione um produto!');
        } else {
            produtoselecionado = produtoselecionado != undefined ? produtoselecionado : '';
            if (selectvidrofalse.is(":visible")) {
                if (selectvidro.val().length !== 0) {
                    idselect = selectvidro.val();
                    nomeselect = selectvidro.find('option:selected').text();
                    let precovidro = selectvidro.find('option:selected').data('preco');
                    let comparador = selectvidro.find('option:selected').data('comparador');
                    let inputcomparar = $('#' + comparador + produtoselecionado);
                    tbody = $('#tabela-vidro');
                    criaId = 'linha-vidro-' + idselect;
                    if (inputcomparar.val() == undefined) {
                        $('#ids').append(
                            '<input id="' + comparador + produtoselecionado + '" type="number" class="id-material ' + criaId + '" name="id_vidro_' + produtoselecionado + '[]" value="' + idselect + '" style="display: none;" />' +
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
            if (selectaluminiofalse.is(":visible")) {

                if (selectaluminio.val().length !== 0) {
                    idselect = selectaluminio.val();
                    nomeselect = selectaluminio.find('option:selected').text();
                    idinput = $('.id-material-aluminio').attr('value');
                    let medida = selectaluminio.find('option:selected').data('medida');
                    let peso = selectaluminio.find('option:selected').data('peso');
                    let produto = $('#select-produto-material option:selected');
                    if(produto.data('largura') !== undefined){
                        let tipo_medida = selectaluminio.find('option:selected').data('tipomedida');
                        let largura = produto.data('largura');
                        let altura = produto.data('altura');
                        let aluminioMedida = tipo_medida === 'largura'?largura :
                            ( tipo_medida === 'altura'? altura : medida ) ;
                        let aluminioPeso = (peso/medida)* aluminioMedida;
                        aluminioPeso = parseFloat(aluminioPeso).toFixed(3);
                        medida = aluminioMedida;
                        peso = aluminioPeso;
                    }
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
                            '<td>' + medida + 'M' + '</td>' +
                            '<td>' + peso + 'Kg' + '</td>' +
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
                            '<td>' + medida + 'M' + '</td>' +
                            '<td>' + peso + 'Kg' + '</td>' +
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
            if (selectcomponentefalse.is(":visible")) {

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
                //$('#select-vidro').show();
                $('#select_vidro_chosen').show();
                //$('#select-componente').hide();
                $('#select_componente_chosen').hide();
                //$('#select-aluminio').hide();
                $('#select_aluminio_chosen').hide();
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
                //$('#select-vidro').hide();
                $('#select_vidro_chosen').hide();
                //$('#select-componente').hide();
                $('#select_componente_chosen').hide();
                //$('#select-aluminio').show();
                $('#select_aluminio_chosen').show();
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
                //$('#select-vidro').hide();
                $('#select_vidro_chosen').hide();
                //$('#select-componente').show();
                $('#select_componente_chosen').show();
                //$('#select-aluminio').hide();
                $('#select_aluminio_chosen').hide();
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

            $('.bt-budget-deletar-produto').attr('id', produtoselecionado.val());
            imagem = produtoselecionado.data('image');
            descricao = produtoselecionado.data('descricao');
            altura = produtoselecionado.data('altura');
            //altura = parseFloat(Math.round(altura * 1000) / 1000).toFixed(3);
            largura = produtoselecionado.data('largura');
            //largura = parseFloat(Math.round(largura * 1000) / 1000).toFixed(3);
            qtd = produtoselecionado.data('qtd');
            localizacao = produtoselecionado.data('localizacao');
            maoObra = produtoselecionado.data('valor_mao_obra');

        } else {
            $('.bt-budget-deletar-produto').attr('id', 'vazio');
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

    $('#opcao-pdf').change(function (e) {
        $('#opcao').prop('selectedIndex',0);

        let opcaoselecionada = $('#opcao-pdf option:selected');

        if(opcaoselecionada.val() == 'orcamento'){

            $('.orcamento-select-pdf').show();
            $('.ordem-select-pdf').hide();
            $('#opcao').attr('name', 'idorcamento');

        }else{

            $('.ordem-select-pdf').show();
            $('.orcamento-select-pdf').hide();
            $('#opcao').attr('name', 'idordem');

        }

    });

    $('#select-cliente').change(function (e) {

        let clienteselecionado = $('#select-cliente option:selected');

        $('#endereco').val(clienteselecionado.data('endereco'));
        $('#bairro').val(clienteselecionado.data('bairro'));
        $('#cidade').val(clienteselecionado.data('cidade'));
        $('#complemento').val(clienteselecionado.data('complemento'));
        let cep =  $('#cep');
        cep.val(cep.masked(clienteselecionado.data('cep')));
        let tel = $('#telefone');
        tel.val(tel.masked(clienteselecionado.data('telefone')));
        $('#select-UF').prop('selectedIndex',$("#select-UF option[value=" + clienteselecionado.data('uf') + "]").index());

    });

    $('#select-documento').change(function (e) {
        let documentoselecionado = $('#select-documento option:selected');
        if(documentoselecionado.val() === 'cpf'){
            $('#doc-cpf-input').show();
            $('#cpf').attr({ required: true , name: 'cpf' });
            $('#doc-cnpj-input').hide();
            $('#cnpj').attr({ required: false , name: ''}).val('');

        }else if(documentoselecionado.val() === 'cnpj'){
            $('#doc-cpf-input').hide();
            $('#cpf').attr({ required: false , name: '' }).val('');
            $('#doc-cnpj-input').show();
            $('#cnpj').attr({ required: true , name: 'cnpj'});
        }else{
            $('#doc-cpf-input').hide();
            $('#doc-cnpj-input').hide();
            alert('Problema inesperado reinicie a página!');
        }

    });


    $('#select-orcamento-venda').change(function (e) {
        $('#select-tipo-pagamento').val('A VISTA').trigger('change');
        let orcamentoselecionado = $('#select-orcamento-venda option:selected');

        if(orcamentoselecionado.val() === '') {
            $('#total').val('');
            $('#valor_parc').val('');
        }else{
            $('#total').val(orcamentoselecionado.data('total'));
        }

    });


    $('#select-tipo-pagamento').change(function (e) {

        let orcamentoselecionado = $('#select-orcamento-venda option:selected');

        if(!orcamentoselecionado.data('cliente') && orcamentoselecionado.val() !== '' && $('#select-tipo-pagamento option:selected').val() === 'A PRAZO'){
            $('#erro-js').attr('class','alert alert-danger')
                .text('Selecione um orçamento com cliente cadastrado para liberar o pagamento a prazo!');
            $('#select-tipo-pagamento').val('A VISTA');
        }

        let tipopagamentoselecionado = $('#select-tipo-pagamento option:selected');

        if(tipopagamentoselecionado.val() === 'A VISTA'){

            $('#qtd_parcelas').hide();
            $('#valor_parcela').hide();
            $('#valor_parc').attr('name','').val('');
            $('#qtd_parc').attr('name','');

        }else if(tipopagamentoselecionado.val() === 'A PRAZO'){

            $('#qtd_parcelas').show();
            $('#valor_parcela').show();
            $('#valor_parc').attr('name','valor_parcela');
            $('#qtd_parc').attr('name','qtd_parcelas');
            if(orcamentoselecionado.val() !== '' && $('#qtd_parc').val() !== ''){
                $('#valor_parc').val(parseFloat(orcamentoselecionado.data('total')/$('#qtd_parc').val()).toFixed(2));
            }


        }else{
            alert('Problema inesperado reinicie a página!');
        }

    });

    $('#qtd_parc').change(function (e) {

        if($(this).val !== '' && $('#total').val() !== ''){
            $('#valor_parc').val(parseFloat($('#total').val()/$(this).val()).toFixed(2));
        }

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

    $('#telefone').mask('(00) 0000-0000');
    $('.telefone').mask('(00) 0000-0000');
    $('#cep').mask('00000-000');

    var maskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        },
        options = {
            onKeyPress: function (val, e, field, options) {
                field.mask(maskBehavior.apply({}, arguments), options);
            }
        };

    $('#celular').mask(maskBehavior, options);
    $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('#cpf').mask('000.000.000-00', {reverse: true});


    $('.altura').each(function (index) {
        $(this).keyup(function () {
            $(this).val(mskDigitos($(this).val()));
        });
    });

    $('.largura').each(function (index) {
        $(this).keyup(function () {
            $(this).val(mskDigitos($(this).val()));
        });
    });

    function mskDigitos(v) {
        v = v.replace(/\D/g, "");
        v = v.replace(/(\d)(\d{1,3}$)/, "$1.$2");
        return v;
    }

    //Deixando novos selects do plugin chosen invisíveis
    $('#select_aluminio_chosen').hide();
    $('#select_componente_chosen').hide();

});
$(document).ready(function () {
    var isSmartphone = false;  //VARIÁVEL QUE MOSTRA SE O PROGRAMA ESTÁ SENDO ABERTO EM UM DISPOSITIVO MÓVEL
    //VERIFICAÇÃO DE SUPORTE DO PLUGIN CHOSEN NOS NAVEGADORES,
    // SE NÃO SUPORTAR EXIBE OS SELECT BÁSICOS PARA SEREM UTILIZADOS
    if (!("Microsoft Internet Explorer" === window.navigator.appName ? document.documentMode >= 8 : !(/iP(od|hone)/i.test(window.navigator.userAgent) || /IEMobile/i.test(window.navigator.userAgent) || /Windows Phone/i.test(window.navigator.userAgent) || /BlackBerry/i.test(window.navigator.userAgent) || /BB10/i.test(window.navigator.userAgent) || /Android.*Mobile/i.test(window.navigator.userAgent)))) {
        var materialSelecionado = $('#select-material').val();
        isSmartphone = true;

        $('.form-control-chosen').each(function(){
            let id = $(this).attr('id');
            if(id == 'select-vidro' || id == 'select-aluminio' || id == 'select-componente'){

                if(materialSelecionado == 0){
                    $('#select-vidro').show();
                }else if(materialSelecionado == 1){
                    $('#select-aluminio').show();
                }else if(materialSelecionado == 2){
                    $('#select-componente').show();
                }

            }else{
                $(this).show();
            }
        });
        
         
    } else {

        //Iniciando selects com search dentro
        $('.form-control-chosen').chosen({
            // Chosen options here
        });


    }
    
    //Deixando novos selects do plugin chosen invisíveis orçamento material e mproduct material
    $('#select_aluminio_chosen').hide();
    $('#select_componente_chosen').hide();


    $('#nav-tab a').click(function () {
        var tab_id = $(this).attr('data-tab');
        
        if (tab_id !== undefined) {
            switch (tab_id) {
                case "nav-Total-tab":
                    changeTextBtBudget("Gerar PDF");
                    break;
                case "nav-Vidros-tab":
                    
                    $('#bt-material').attr("href", '/materials/glass/create');
                    if(isSmartphone){
                        $('#select-componente').hide();
                        $('#select-aluminio').hide();
                        $('#select-vidro').show();
                    }else{
                        $('#select_componente_chosen').hide();
                        $('#select_aluminio_chosen').hide();
                        $('#select_vidro_chosen').show();
                    }
                    
                    
                    break;
                case "nav-Aluminios-tab":
                    
                    $('#bt-material').attr("href", '/materials/aluminum/create');
                    
                    if(isSmartphone){
                        $('#select-componente').hide();
                        $('#select-aluminio').show();
                        $('#select-vidro').hide();
                    }else{
                        $('#select_componente_chosen').hide();
                        $('#select_aluminio_chosen').show();
                        $('#select_vidro_chosen').hide();
                    }
                    
                    break;
                case "nav-Componentes-tab":
                    
                    $('#bt-material').attr("href", '/materials/component/create');
                    
                    if(isSmartphone){
                        $('#select-componente').show();
                        $('#select-aluminio').hide();
                        $('#select-vidro').hide();
                    }else{
                        $('#select_componente_chosen').show();
                        $('#select_aluminio_chosen').hide();
                        $('#select_vidro_chosen').hide();
                    }

                    break;
                default:
                    changeTextBtBudget("Salvar");
                    break;
            }
            $('#nav-tab a').removeClass('current');
            $('.tab-content').removeClass('current');

            $(this).addClass('current');
            $("#" + tab_id).addClass('current');
        }

    });


    if ($('#tabSession').data('value') != '') {

        var tabsarray = $('.tabs-budget');
        var budgetTabs = true;
        
        if(tabsarray.length == 0){
            tabsarray = $('.tabs-storage');
            budgetTabs = false;
        }

        if(tabsarray.length == 0){
            tabsarray = $('.tabs-financial');
        }

        switch ($('#tabSession').data('value')) {
            case 1:
                tabsarray[0].click();
                break;
            case 2:
                tabsarray[1].click();
                break;
            case 3:
                tabsarray[2].click();
                if(budgetTabs)
                    $('.bt-budget-deletar-produto').show();
                break;
            case 4:
                tabsarray[3].click();
                break;
        }

    }


    $('.opensubmenu ul li').each(function () {
        let ativo = $(this).attr("class");
        if (ativo === "active") {
            let submenu = $(this).parent();
            submenu.closest('li').css('height', "auto");
            submenu.slideToggle("slow");
        }
    });
    $('.opensubmenu').click(function () {
        let submenu = $(this).children('ul');
        submenu.closest('li').css('height', "auto");
        submenu.slideToggle("slow");
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
        let portaeportoes = $('#portaeportoes');
        let suprema = $('#suprema');
        let temperado8mm = $('#temperado8mm');
        let componentes = $('#componentes');
        let selecionecategoria = $('#selecione-categoria');
        selecionecategoria.css("display", "none");
        boxdiversos.css("display", "none");
        boxpadrao.css("display", "none");
        ferragem1000.css("display", "none");
        ferragem3000.css("display", "none");
        kitsacada.css("display", "none");
        portaeportoes.css("display", "none");
        suprema.css("display", "none");
        temperado8mm.css("display", "none");
        componentes.css("display", "none");

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
                if (valueSelected != 'todasimagens')
                    break;
            case 'portaeportoes':
                portaeportoes.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });
                if (valueSelected != 'todasimagens')
                    break;
            case 'suprema':
                suprema.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });
                if (valueSelected != 'todasimagens')
                    break;
            case 'temperado8mm':
                temperado8mm.css({
                    'display': 'flex',
                    'flex-wrap': 'wrap',
                    'justify-content': 'space-between',
                });
                if (valueSelected != 'todasimagens')
                    break;
            case 'componentes':
                componentes.css({
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

    let contadorTipoCategoria = 0;
    $('#select-tipo-categoria').change(function () {
        let valueSelected = $('#select-tipo-categoria option:selected').val();

        if (contadorTipoCategoria > 0) {
            $('#option-vazia').prop('selected', true);
        }
        contadorTipoCategoria++;

        $('#selectimagegroup').attr('required', true);
        $('#image-group').css("display", "block");

        $('.produtocategoria').each(function () {
            $(this).css("display", "none");
        });

        $('.aluminiocategoria').each(function () {
            $(this).css("display", "none");
        });

        $('.componentecategoria').each(function () {
            $(this).css("display", "none");
        });

        switch (valueSelected) {
            case 'produto':
                $('.produtocategoria').each(function () {
                    $(this).css("display", "block");
                });
                break;
            case 'vidro':
                $('#selectimagegroup').attr('required', false);
                $('#image-group').css("display", "none");
                break;
            case 'aluminio':
                $('.aluminiocategoria').each(function () {
                    $(this).css("display", "block");
                });
                break;
            case 'componente':
                $('.componentecategoria').each(function () {
                    $(this).css("display", "block");
                });
                break;
        }

    });
    $('#select-tipo-categoria').trigger('change');

    $('#bt-material').attr("href", '/materials/glass/create');

    $('#bt-user-visible').click(function () {
        $('#bt-user-invisible').click();
    });

    $('#bt-client-visible').click(function () {

        if ($('#nome').val().length !== 0
            && $('#cep').val().length === 9
            && ($('#cpf').val().length === 14 || $('#cnpj').val().length === 18)) {
            $('#cep').unmask();
            $('#cpf').unmask();
            $('#cnpj').unmask();
            $('#telefone').unmask();
            $('#celular').unmask();

            $('#bt-client-invisible').click();
        } else {
            if (($('#cpf').val().length === 14 || $('#cnpj').val().length === 18)) {
                $('#bt-client-invisible').click();
            } else {
                $('#erro-js').attr('class', 'alert alert-danger');
                $('#erro-js').text('Documento fornecido é inválido');
            }
        }


    });

    $('#bt-sale-visible').click(function () {
        if ($('#select-orcamento-venda').val() !== '') {
            $('#bt-sale-invisible').click();
        } else {
            $('#erro-js').attr('class', 'alert alert-danger');
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
        if ($('#nav-Produto-tab').hasClass('current')) {
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
            case $('#nav-Orçamento-tab').hasClass('current'):

                if ($('#nome').val().length !== 0 && $('#cep').val().length === 9) {
                    $('#cep').unmask();
                    $('#telefone').unmask();
                }

                $('#bt-orcamento-budget-invisible').click();

                break;
            case $('#nav-Editar-tab').hasClass('current'):

                $('#bt-edit-budget-invisible').click();

                break;
            case $('#nav-Adicionar-tab').hasClass('current'):

                $('#bt-add-budget-invisible').click();

                break;
            case $('#nav-Material-tab').hasClass('current'):

                $('#bt-material-budget-invisible').click();

                break;
            case $('#nav-Total-tab').hasClass('current'):

                $('#bt-total-budget-invisible').click();

                break;
        }

    });
    //fim orçamento form

    //inicio orcamento troca de tab esconder botão delete
    $('.tabs-budget').each(function (index) {
        $(this).on("click", function () {

            if ('nav-Editar-tab' == $(this).data('tab') && !$(this).hasClass('disabled')) {
                $('.bt-budget-deletar-produto').show();
            } else {
                $('.bt-budget-deletar-produto').hide();
            }

        });
    });
    //fim orcamento troca de tab esconder botão delete


    $('#bt-provider-visible').click(function () {
        if ($('#nome').val().length !== 0) {
            if ($('#cep').val().length === 9) {
                $('#cep').unmask();
                $('#telefone').unmask();
                $('#cnpj').unmask();
                $('#celular').unmask();
            }

        }


        $('#bt-provider-invisible').click();
    });

    $('#bt-company-visible').click(function () {
        if ($('#nome').val().length !== 0
            && $('#endereco').val().length !== 0
            && $('#cidade').val().length !== 0
            && $('#bairro').val().length !== 0
            && $('#uf').val().length !== 0
            && $('#email').val().length !== 0
            && $('#telefone').val().length !== 0) {

            $('#cep').unmask();
            $('#telefone').unmask();
        }


        $('#bt-company-invisible').click();
    });

    $('#bt-configuration-visible').click(function () {
        $('#bt-configuration-invisible').click();
    });

    $('#bt-pdf-visible').click(function () {
        $('#bt-pdf-invisible').click();
    });

    // $('#nav-Vidros-tab').click(function () {
    //     $('#bt-material').attr("href", '/materials/glass/create');
    // });
    // $('#nav-Aluminios-tab').click(function () {
    //     $('#bt-material').attr("href", '/materials/aluminum/create');
    // });
    // $('#nav-Componentes-tab').click(function () {
    //     $('#bt-material').attr("href", '/materials/component/create');
    // });

    // $('#nav-Orçamento-tab').click(function () {
    //     changeTextBtBudget("Salvar");
    // });
    //
    // $('#nav-Editar-tab').click(function () {
    //     changeTextBtBudget("Salvar");
    // });
    //
    // $('#nav-Adicionar-tab').click(function () {
    //     changeTextBtBudget("Salvar");
    // });
    //
    // $('#nav-Material-tab').click(function () {
    //     changeTextBtBudget("Salvar");
    // });
    //
    // $('#nav-Total-tab').click(function () {
    //     changeTextBtBudget("Gerar PDF");
    // });

    function changeTextBtBudget($texto) {
        $('#bt-budget-visible').text($texto);
    }

    $('tbody').on('click', '.deletar-material-tabela', function (e) {
        //alert(e.target.id);
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
            if (selectvidrofalse.is(":visible") || selectvidro.is(":visible")) {
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
            if (selectaluminiofalse.is(":visible") || selectaluminio.is(":visible")) {

                if (selectaluminio.val().length !== 0) {
                    idselect = selectaluminio.val();
                    nomeselect = selectaluminio.find('option:selected').text();
                    idinput = $('.id-material-aluminio').attr('value');
                    let medida = selectaluminio.find('option:selected').data('medida');
                    let peso = selectaluminio.find('option:selected').data('peso');
                    let qtdaluminio = selectaluminio.find('option:selected').data('qtd');
                    let imagemaluminio = selectaluminio.find('option:selected').data('imagem');
                    let produto = $('#select-produto-material option:selected');
                    if (produto.data('largura') !== undefined) {
                        //MEDIDA M LINEAR GERADA ASSIM (largura * 2 + altura * 2)
                        let tipo_medida = selectaluminio.find('option:selected').data('tipomedida');
                        let largura = produto.data('largura');
                        let altura = produto.data('altura');
                        let aluminioMedida = 0;

                        switch (tipo_medida) {
                            case 'largura':
                                aluminioMedida = largura;
                                break;
                            case 'altura':
                                aluminioMedida = altura;
                                break;
                            case 'mlinear':
                                aluminioMedida = (largura * 2 + altura * 2);
                                break;
                        }

                        let aluminioPeso = (peso / medida) * aluminioMedida;
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
                            "<td class='text-center'><img style='height: 5rem;' src=" + imagemaluminio + " class='img-fluid img-thumbnail'> </td>" +
                            '<td>' + nomeselect + '</td>' +
                            '<td>' + medida + 'M' + '</td>' +
                            '<td>' + peso + 'Kg' + '</td>' +
                            '<td>' + 'R$' + precoaluminio + '</td>' +
                            '<td>' + qtdaluminio + '</td>' +
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
                            "<td class='text-center'><img style='height: 5rem;' src=" + imagemaluminio + " class='img-fluid img-thumbnail'> </td>" +
                            '<td>' + nomeselect + '</td>' +
                            '<td>' + medida + 'M' + '</td>' +
                            '<td>' + peso + 'Kg' + '</td>' +
                            '<td>' + 'R$' + precoaluminio + '</td>' +
                            '<td>' + qtdaluminio + '</td>' +
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
            if (selectcomponentefalse.is(":visible") || selectcomponente.is(":visible")) {

                if (selectcomponente.val().length !== 0) {
                    idselect = selectcomponente.val();
                    nomeselect = selectcomponente.find('option:selected').text();
                    idinput = $('.id-material-componente').attr('value');
                    let qtd = selectcomponente.find('option:selected').data('qtd');
                    let precocomponente = selectcomponente.find('option:selected').data('preco');
                    let imagemcomponente = selectcomponente.find('option:selected').data('imagem');
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
                            "<td class='text-center'><img style='height: 5rem;' src=" + imagemcomponente + " class='img-fluid img-thumbnail'> </td>" +
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
                            "<td class='text-center'><img style='height: 5rem;' src=" + imagemcomponente + " class='img-fluid img-thumbnail'> </td>" +
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

    // $('#nav-Vidros-tab').on('click', function () {

    //     $('#select_componente_chosen').hide();
    //     $('#select_aluminio_chosen').hide();
    //     $('#select_vidro_chosen').show();

    // });

    // $('#nav-Aluminios-tab').on('click', function () {


    //     $('#select_vidro_chosen').hide();
    //     $('#select_componente_chosen').hide();
    //     $('#select_aluminio_chosen').show();

    // });

    // $('#nav-Componentes-tab').on('click', function () {

    //     $('#select_vidro_chosen').hide();
    //     $('#select_aluminio_chosen').hide();
    //     $('#select_componente_chosen').show();

    // });

    $('#select-material').change(function (e) {
        let selecionado = $('#select-material option:selected').val();
        let label = $('#label_categoria');
        
        switch (selecionado) {
            case '0':
                label.text('Vidros');
                $('.titulo').text('Vidros');
                if(isSmartphone){
                    $('#select-componente').hide();
                    $('#select-aluminio').hide();
                    $('#select-vidro').show();
                }else{
                    $('#select_componente_chosen').hide();
                    $('#select_aluminio_chosen').hide();
                    $('#select_vidro_chosen').show();
                }
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
                if(isSmartphone){
                    $('#select-componente').hide();
                    $('#select-aluminio').show();
                    $('#select-vidro').hide();
                }else{
                    $('#select_componente_chosen').hide();
                    $('#select_aluminio_chosen').show();
                    $('#select_vidro_chosen').hide();
                }
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
                if(isSmartphone){
                    $('#select-componente').show();
                    $('#select-aluminio').hide();
                    $('#select-vidro').hide();
                }else{
                    $('#select_componente_chosen').show();
                    $('#select_aluminio_chosen').hide();
                    $('#select_vidro_chosen').hide();
                }
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
                $('#descricao-mprod').text('');
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
        $('#descricao-mprod').text(descricao);
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
        $('#opcao').prop('selectedIndex', 0);

        let opcaoselecionada = $('#opcao-pdf option:selected');

        if (opcaoselecionada.val() == 'orcamento') {

            $('.orcamento-select-pdf').show();
            $('.ordem-select-pdf').hide();
            $('#opcao').attr('name', 'idorcamento');

        } else {

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
        let cep = $('#cep');
        cep.val(cep.masked(clienteselecionado.data('cep')));
        let tel = $('#telefone');
        tel.val(tel.masked(clienteselecionado.data('telefone')));
        $('#select-UF').prop('selectedIndex', $("#select-UF option[value=" + clienteselecionado.data('uf') + "]").index());

    });

    $('#select-documento').change(function (e) {
        let documentoselecionado = $('#select-documento option:selected');
        if (documentoselecionado.val() === 'cpf') {
            $('#doc-cpf-input').show();
            $('#cpf').attr({required: true, name: 'documento'});
            $('#doc-cnpj-input').hide();
            $('#cnpj').attr({required: false, name: ''}).val('');

        } else if (documentoselecionado.val() === 'cnpj') {
            $('#doc-cpf-input').hide();
            $('#cpf').attr({required: false, name: ''}).val('');
            $('#doc-cnpj-input').show();
            $('#cnpj').attr({required: true, name: 'documento'});
        } else {
            $('#doc-cpf-input').hide();
            $('#doc-cnpj-input').hide();
            alert('Problema inesperado reinicie a página!');
        }

    });


    $('#select-orcamento-venda').change(function (e) {
        $('#select-tipo-pagamento').val('A VISTA').trigger('change');
        let orcamentoselecionado = $('#select-orcamento-venda option:selected');

        if (orcamentoselecionado.val() === '') {
            $('#total').val('');
            $('#valor_parc').val('');
        } else {
            $('#total').val(orcamentoselecionado.data('total'));
        }
        $('#desconto').val('');
        $('#entrada').val('');
    });


    $('#entrada').on("keyup", function () {

        $(this).val(mskDigitosDoisDecimais($(this).val()));
        calcularEntradaDesconto($(this));
        
    });


    $('#desconto').on("keyup", function () {

        $(this).val(mskDigitosDoisDecimais($(this).val()));
        calcularEntradaDesconto($(this));
        
    });

    //checkbox usar desconto como venda

    $('#usar_desconto').click(function (){
        let tipoPagamento = $('#select-tipo-pagamento option:selected').val() == "A VISTA" ? true : false;
        if(tipoPagamento){
            let orcamentoselecionado = $('#select-orcamento-venda option:selected');
            $('#total').val(orcamentoselecionado.data('total'));
            $('#desconto').val('');
            let valorTotal = $('#total').val();
            let desconto =  $('#desconto').val();
            if(valorTotal.length !== 0 && desconto.length == 0){
                if($('#usar_desconto').is(":checked")){
                     $('#desconto').val(valorTotal);
                     $('#total').val('');
                }
            }else{
                $('#usar_desconto').prop("checked", false);
                $('#total').val(desconto);
                $('#desconto').val('');
            }
        }else{
            $('#usar_desconto').prop("checked", false);
        }
        
        
    });


    $('#select-tipo-pagamento').change(function (e) {

        let orcamentoselecionado = $('#select-orcamento-venda option:selected');

        if (!orcamentoselecionado.data('cliente') && $('#select-tipo-pagamento option:selected').val() === 'A PRAZO') {
            $('#erro-js').attr('class', 'alert alert-danger')
                .text('Selecione um orçamento com cliente cadastrado para liberar o pagamento a prazo!');
            $('#select-tipo-pagamento').val('A VISTA');
        }

        let tipopagamentoselecionado = $('#select-tipo-pagamento option:selected');

        $('#entrada').val('');
        $('#desconto').val('');
        $('#qtd_parc').val('1');
        $('#sem_juros').prop( "checked", false);
        $('#usar_desconto').prop( "checked", false);

        if (tipopagamentoselecionado.val() === 'A VISTA') {

            $('#qtd_parcelas').hide();
            $('#valor_parcela').hide();
            $('#entradadisplay').hide();
            $('#semjurosdisplay').hide();
            $('#userdescontodisplay').show();
            $('#valor_parc').attr('name', '').val('');
            $('#qtd_parc').attr('name', '');
            $('#entrada').attr('name', '').val('');
            $('#sem_juros').attr('name', '')
            let totalOrcamento = orcamentoselecionado.data('total') == 0 ? '' : orcamentoselecionado.data('total');
            $('#total').val(totalOrcamento);

        } else if (tipopagamentoselecionado.val() === 'A PRAZO') {
            
            $('#qtd_parcelas').show();
            $('#valor_parcela').show();
            $('#entradadisplay').show();
            $('#semjurosdisplay').show();
            $('#userdescontodisplay').hide();
            $('#valor_parc').attr('name', 'valor_parcela');
            $('#qtd_parc').attr('name', 'qtd_parcelas');
            $('#entrada').attr('name', 'entrada');
            $('#sem_juros').attr('name', 'sem_juros')
            if (orcamentoselecionado.val() !== '' && $('#qtd_parc').val() !== '') {
                calcularJuros(0, false);
            }


        } else {
            alert('Problema inesperado atualize a página!');
        }

        
    });

    $('#qtd_parc').change(function (e) {

        if ($(this).val !== '' && $('#total').val() !== '') {
            

            calcularEntradaDesconto($('#desconto'), true);

            
        }

    });

    $('#sem_juros').change(function() {

        $('#entrada').val('');
        $('#desconto').val('');
        $('#qtd_parc').val('1');
        
        if(this.checked) {
            calcularJuros(0,true);
        }else{
            calcularJuros(0,false);
        }       
    });

    function calcularJuros(descontoEentrada, semJuros){
        let orcamentoselecionado = $('#select-orcamento-venda option:selected');
        let total = '';
        if(semJuros){
            total = parseFloat(orcamentoselecionado.data('total') - descontoEentrada).toFixed(2);
        }else{
            total = parseFloat((parseFloat(orcamentoselecionado.data('total')) * Math.pow(1 + $('#sem_juros').data('juros'), $('#qtd_parc').val()) - descontoEentrada)).toFixed(2);
        }
        total = total == -0? 0.00 : total;
        $('#total').val(total);
        
        $('#valor_parc').val(parseFloat(total / $('#qtd_parc').val()).toFixed(2));
    }

    function calcularEntradaDesconto(input, reset = false) {
        let desconto = $('#desconto');
        let entrada = $('#entrada');

        let orcamentoselecionado = $('#select-orcamento-venda option:selected');

        if (orcamentoselecionado.val() === '') {

            $('#erro-js').attr('class', 'alert alert-danger')
                .text('Selecione um orçamento antes!');
            desconto.val('');
            entrada.val('');

        } else {
            let valorDesconto = desconto.val();
            valorDesconto = valorDesconto == '' ? 0 : valorDesconto;
            let valorEntrada = entrada.val();
            valorEntrada = valorEntrada == '' ? 0 : valorEntrada;
            let total = '';

            let somaDescontoEntrada = parseFloat(valorDesconto) + parseFloat(valorEntrada);

            let tipopagamentoselecionado = $('#select-tipo-pagamento option:selected');

            if (tipopagamentoselecionado.val() === 'A PRAZO' && !$('#sem_juros').prop("checked")) {
                total = parseFloat((orcamentoselecionado.data('total')) * Math.pow(1 + $('#sem_juros').data('juros'), $('#qtd_parc').val())).toFixed(2)
            }else{
                total = orcamentoselecionado.data('total');
            }
            
            if (somaDescontoEntrada > 0 && somaDescontoEntrada <= total) {

                if (tipopagamentoselecionado.val() === 'A VISTA') {

                    $('#total').val(parseFloat(total - valorDesconto).toFixed(2));

                } else if (tipopagamentoselecionado.val() === 'A PRAZO') {
                    
                    if ($('#qtd_parc').val() !== '') {
                        if($('#sem_juros').prop("checked")) {
                            calcularJuros(somaDescontoEntrada,true);
                        }else{
                            calcularJuros(somaDescontoEntrada,false);
                        } 
                    } else {
                        alert('Problema inesperado reinicie a página!');
                    }

                } else {
                    alert('Problema inesperado reinicie a página!');
                }


            } else {


                if (input.val() != '0') {
                    if (input.val() != '') {
                        $('#erro-js').attr('class', 'alert alert-danger')
                            .text('Valor inválido ou maior que o total!');
                    }
                    if(reset){
                        desconto.val('');
                        entrada.val('');
                        somaDescontoEntrada = 0;
                    }else{
                        somaDescontoEntrada = somaDescontoEntrada - input.val();
                    }
                    
                    if (tipopagamentoselecionado.val() === 'A PRAZO') {
                        if($('#sem_juros').prop("checked")) {
                            calcularJuros(somaDescontoEntrada,true);
                        }else{
                            calcularJuros(somaDescontoEntrada,false);
                        } 
                        
                    }else{
                        total = orcamentoselecionado.data('total');
                        $('#total').val(total);
                    }
                    
                    input.val('');
                }

            }
        }
    }


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


    // $('#pesquisar').on('keyup',function (e) {
    //     e.preventDefault();
    //     ajaxPesquisaLoad();
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
            $(this).val(mskDigitosTresDecimais($(this).val()));
        });
    });

    $('.largura').each(function (index) {
        $(this).keyup(function () {
            $(this).val(mskDigitosTresDecimais($(this).val()));
        });
    });

    function mskDigitosTresDecimais(v) {
        v = v.replace(/\D/g, "");
        v = v.replace(/(\d)(\d{1,3}$)/, "$1.$2");
        return v;
    }

    function mskDigitosDoisDecimais(v) {
        v = v.replace(/\D/g, "");
        v = v.replace(/(\d)(\d{1,2}$)/, "$1.$2");
        return v;
    }

    $('#image').on('change', function () {
        var reader = new FileReader();
        if ($(this).prop('files')[0].size > 7244183) {
            $('#formAlert').append("<div class='alert alert-danger'>Tamanho do arquivo muito grande</div>");
            $(this).val("");
        } else {
            $('#formAlert').html("");
            reader.readAsDataURL($(this).prop('files')[0]);
            reader.onload = function (event) {
                $('#image-user').attr('src', event.target.result);
            }
        }

    });

    $('body').on('click', '.pagination a', function (e) {
        e.preventDefault();
        let idtab = $('.nav-tabs a.current').attr('data-id');
        let divclicada = $(this).parent().parent().parent();
        console.log(divclicada);
        if (idtab === undefined) {
            $('.tabelasrestaurar').each(function () {
                // if($(this).hasClass('show')){
                let id = $(this).data('tipo');
                if (divclicada.attr('id') === id) {
                    idtab = id;
                }

                // }
            });
        }
        // $('#load a').css('color', '#dfecf6');
        // $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');
        let numeroleftright = $(this).attr('data-page');
        let numeropaginacao = $(this).text();
        let paginacao = 0;
        if (numeroleftright !== undefined) {
            paginacao = numeroleftright;
        } else {
            paginacao = numeropaginacao;
        }
        let search = null;
        let paginate = null;
        let period = null;
        let host = window.location.href;
        let novaurl = null;
        if (idtab !== undefined) {
            paginate = $('#paginate' + idtab).val();
            search = $('#search' + idtab).val();
            period = $('#period').val();
            novaurl = host + '?' + idtab + '=1&search=' + search + '&paginate=' + paginate + '&period=' + period + '&page=' + paginacao;
            ajaxPesquisaLoad(novaurl, idtab);
        } else {
            search = $('#search').val();
            paginate = $('#paginate').val();
            period = $('#period').val();
            novaurl = host + '?search=' + search + '&paginate=' + paginate + '&period=' + period + '&page=' + paginacao;
            ajaxPesquisaLoad(novaurl);
        }
        // window.history.pushState("", "", url);
    });


});

//
// function getFromPagination(url) {
//     $.ajax({
//         url: url
//     }).done(function (data) {
//         $('#content').html(data);
//     }).fail(function () {
//         alert('Erro ao carregar');
//     });
// }

function ajaxPesquisaLoad(url, id = null) {
    // console.log(input.value);
    console.log(url);
    // let novaurl = url + '=' + input.value;
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if (id !== null) {
                console.log(id);
                $('#' + id).html(data);
            } else {
                $('#content').html(data);
            }
        }
    });
}

var meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
var periodos = ['360 dias', '180 dias', '30 dias', '7 dias', 'hoje'];
var host = window.location.origin;

graficoVendas();
graficoProdutos();
graficofinanceiro();
graficoOrdens();
graficoClientes();
graficoOrcamentos();
graficoCaixaFuturo();

function graficoVendas() {
    var ctxVendas = document.getElementById("vendas");
    if (ctxVendas) {
        fetch(host + '/dashboard/sales')
            .then(result => result.json())
            .then((data) => {
                var graficoVendas = new Chart(ctxVendas, {
                    type: "line",
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Qtd Vendas',
                            data: data,
                            backgroundColor: 'rgba(51,153,255,0.5)',
                            borderColor: 'rgba(51,153,255,1)',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                    }
                });
            });
    }
}


function graficoProdutos() {
    var ctxProdutos = document.getElementById("produtos");
    if (ctxProdutos) {
        fetch(host + '/dashboard/products')
            .then(response => response.json())
            .then((data) => {
                var graficoProdutos = new Chart(ctxProdutos, {
                    type: "horizontalBar",
                    data: {
                        labels: data.nomes,
                        datasets: [
                        
                            {
                                label: 'qtd',
                                data: data.qtds,
                                backgroundColor: ["#800103DE","#8072F175", "#80A832F2", "#80DF6AA3", "#803244C6", "#8089644B", "#80BD8DE8", "#80C5A4C7", "#80E3D688", "#802353D6"],
                                hoverBackgroundColor: 'rgba(204, 255, 255,0.5)',
                                borderColor: ["#800103","#8072F1", "#80A832", "#80DF6A", "#803244", "#808964", "#80BD8D", "#80C5A4", "#80E3D6", "#802353"],
                                borderWidth: 2
                            }
                        
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            xAxes: [{
                                display: true,
                                ticks: {
                                    suggestedMin: 0,
                                    stepSize: 1
                                }
                            }]
                        }
                    }
                });
            });
    }
}

function graficofinanceiro() {
    var ctxFinanceiro = document.getElementById("financeiro");
    if (ctxFinanceiro) {
        fetch(host + '/dashboard/financial')
            .then(response => response.json())
            .then((data) => {
                var graficoFinanceiro = new Chart(ctxFinanceiro, {
                    type: "line",
                    data: {
                        labels: periodos,
                        datasets: [{
                            label: 'Receitas(R$)',
                            data: data.receitas,
                            backgroundColor: 'rgba(51,153,255,0.5)',
                            borderColor: 'rgba(51,153,255,1)',
                            borderWidth: 2
                        },
                            {
                                label: 'Despesas(R$)',
                                data: data.despesas,
                                backgroundColor: 'rgba(255,0,0,0.5)',
                                borderColor: 'rgba(255,0,0,1)',
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                    }
                });
            });
    }
}

function graficoOrdens() {
    var ctxOrdens = document.getElementById("ordensgraph");
    if (ctxOrdens) {
        fetch(host + '/dashboard/orders')
            .then(response => response.json())
            .then((data) => {
                var graficoOrdens = new Chart(ctxOrdens, {
                    type: "bar",
                    data: {
                        labels: periodos,
                        datasets: [{
                            label: 'Concluídas',
                            data: data.concluidas,
                            backgroundColor: 'rgba(51,153,255,0.5)',
                            borderColor: 'rgba(51,153,255,1)',
                            borderWidth: 2
                        },
                            {
                                label: 'Canceladas',
                                data: data.canceladas,
                                backgroundColor: 'rgba(255,0,0,0.5)',
                                borderColor: 'rgba(255,0,0,1)',
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                display: true,
                                ticks: {
                                    suggestedMin: 0
                                }
                            }]
                        }
                    }
                });
            });
    }
}


function graficoOrcamentos() {
    var ctxOrcamentos = document.getElementById("orcamentosgraph");
    if (ctxOrcamentos) {
        fetch(host + '/dashboard/budgets')
            .then(response => response.json())
            .then((data) => {
                var graficoOrcamentos = new Chart(ctxOrcamentos, {
                    type: "bar",
                    data: {
                        labels: periodos,
                        datasets: [{
                            label: 'Aprovados',
                            data: data.aprovados,
                            backgroundColor: 'rgba(100,255,50,0.5)',
                            borderColor: 'rgba(100,255,50,1)',
                            borderWidth: 2
                        },
                            {
                                label: 'Finalizados',
                                data: data.finalizados,
                                backgroundColor: 'rgba(51,153,255,0.5)',
                                borderColor: 'rgba(51,153,255,1)',
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                display: true,
                                ticks: {
                                    suggestedMin: 0
                                }
                            }]
                        }
                    }
                });
            });
    }
}

function graficoClientes() {
    var ctxClientes = document.getElementById("clientes");
    if (ctxClientes) {
        fetch(host + '/dashboard/clients')
            .then(result => result.json())
            .then((data) => {
                var graficoClientes = new Chart(ctxClientes, {
                    type: "pie",
                    data: {
                        datasets: [{
                            data: data.clientes,
                            backgroundColor: ['rgba(51,153,255,0.5)', 'rgba(255,0,0,0.5)'],
                            borderColor: ['rgba(51,153,255,1)', 'rgba(255,0,0,1)'],
                            borderWidth: 2
                        }
                        ],

                        labels: [
                            'Qtd em dia',
                            'Qtd devendo'
                        ]

                    },
                    options: {
                        responsive: true,
                    }
                });
            });
    }
}

function graficoCaixaFuturo() {
    var ctxCaixaFuturo = document.getElementById("caixafuturo");
    if (ctxCaixaFuturo) {
        fetch(host + '/dashboard/futurefinancial')
            .then(response => response.json())
            .then((data) => {
                var saldofuturo = new Array();
                for(let i = 0; i < data.receitas.length; i++){
                    saldofuturo.push((data.receitas[i] - data.despesas[i]).toFixed(2));
                }
                var graficoCaixaFuturo = new Chart(ctxCaixaFuturo, {
                    type: "line",
                    data: {
                        labels: periodos.reverse(),
                        datasets: [{
                            label: 'Receitas(R$)',
                            data: data.receitas,
                            backgroundColor: 'rgba(51,153,255,0)',
                            borderColor: 'rgba(51,153,255,1)',
                            borderWidth: 2
                        },
                            {
                                label: 'Despesas(R$)',
                                data: data.despesas,
                                backgroundColor: 'rgba(255,0,0,0)',
                                borderColor: 'rgba(255,0,0,1)',
                                borderWidth: 2
                            },
                            {
                                label: 'Saldo(R$)',
                                data: saldofuturo,
                                backgroundColor: 'rgba(100,255,50,0)',
                                borderColor: 'rgba(100,255,50,1)',
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                    }
                });
            });
    }
}
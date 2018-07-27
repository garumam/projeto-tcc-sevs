@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <!-- Inicio tab de Produto-->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">

                    <a class="nav-item nav-link active noborder-left" id="nav-orcamento-tab" data-toggle="tab"
                       href="#nav-orcamento" role="tab" aria-controls="nav-orcamento"
                       aria-selected="true">Orçamento</a>

                    <!-- INICIO ABA EXTRA AO EDITAR ORÇAMENTO -->

                    <a class="nav-item nav-link" id="nav-editar-tab" data-toggle="tab"
                       href="#nav-editar" role="tab" aria-controls="nav-editar"
                       aria-selected="false" >Editar</a>

                    <!-- FIM ABA EXTRA AO EDITAR ORÇAMENTO -->

                    <a class="nav-item nav-link" id="nav-adicionar-tab" data-toggle="tab"
                       href="#nav-adicionar" role="tab" aria-controls="nav-adicionar"
                       aria-selected="false">Adicionar</a>

                    <a class="nav-item nav-link" id="nav-material-tab" data-toggle="tab"
                       href="#nav-material" role="tab" aria-controls="nav-material"
                       aria-selected="false">Material</a>

                    <a class="nav-item nav-link" id="nav-total-tab" data-toggle="tab"
                       href="#nav-total" role="tab" aria-controls="nav-total"
                       aria-selected="false">Total</a>

                    <div class="topo-tab">
                        <a id="bt-budget-pdf" class="btn-link" href="">
                            <button class="btn btn-primary btn-block btn-custom" type="submit">Gerar PDF</button>
                        </a>
                    </div>
                </div>
            </nav>
            <!-- Fim tab de Produto-->

            <!--Inicio Conteudo de cada tab -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-orcamento" role="tabpanel"
                     aria-labelledby="nav-orcamento-tab">

                    <form id="form-product" class="formulario" method="POST" role="form"
                          action="{{route('budgets.create')}}">
                        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label>Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Data</label>
                                <input type="date" class="form-control" id="data" name="data" placeholder="00/00/0000"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Telefone</label>
                                <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="(00)0000-0000"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Rua</label>
                                <input type="text" class="form-control" id="rua" name="rua" placeholder="av. de algum lugar"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Cep</label>
                                <input type="number" class="form-control" id="cep" name="cep" placeholder="00000-000"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>N°</label>
                                <input type="number" class="form-control" id="numero-rua" name="numero-rua" placeholder="100"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro"
                                       placeholder="bairro" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="select-UF">UF</label>
                                <select id="select-UF" name="select" class="custom-select">
                                    <option value="0" selected>Selecione uma UF</option>
                                    <option value="">RJ</option>
                                    <option value="">MG</option>
                                    <option value="">SP</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade"
                                       placeholder="cidade" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Complemento</label>
                                <input type="text" class="form-control" id="complemento" name="complemento"
                                       placeholder="complemento">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Margem de lucro</label>
                                <input type="number" class="form-control" id="margem-lucro" name="margem-lucro"
                                       placeholder="100" required>
                            </div>


                        </div>
                        <button class="btn btn-lg btn-primary btn-custom w-50" type="submit">Criar
                        </button>

                    </form>

                </div>

                <!-- INICIO CONTEUDO ABA EXTRA AO EDITAR ORÇAMENTO -->
                <div class="tab-pane fade" id="nav-editar" role="tabpanel"
                     aria-labelledby="nav-editar-tab">

                    <form class="formulario" method="POST" role="form">

                        <div class="form-row align-items-center">
                            <div class="form-group col-">
                                <img id="image-produto" src="{{ asset('img/boxdiversos/bxa1.png') }}" class="img-fluid"
                                     alt="Responsive image" style="height: 110px!important;">
                                <label for="url-image-produto"></label>
                                <input type="text" id="url-image-produto" name="url-image-produto" style="display: none;">
                            </div>

                            <div class="form-group col-md">
                                <label for="select-produto">Selecione o produto</label>
                                <select id="select-produto" name="select" class="custom-select">
                                    <option value="0" selected>Selecione um produto</option>
                                    <option value="">bx-a1</option>
                                    <option value="">bx-c1</option>
                                    <option value="">r2-d2</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Descrição</label>
                                <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Altura</label>
                                <input type="number" class="form-control" id="altura" name="altura" placeholder="2,200"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Largura</label>
                                <input type="number" class="form-control" id="largura" name="largura" placeholder="1,200"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Quantidade</label>
                                <input type="number" class="form-control" id="quantidade" name="quantidade" placeholder="quantidade"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Localização</label>
                                <input type="text" class="form-control" id="localizacao" name="localizacao" placeholder="Localização"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Valor da mão de obra</label>
                                <input type="number" class="form-control" id="mao-de-obra" name="mao-de-obra" placeholder=""
                                       required>
                            </div>

                        </div>

                    </form>

                </div>
                <!-- FIM CONTEUDO ABA EXTRA AO EDITAR ORÇAMENTO -->

                <div class="tab-pane fade" id="nav-adicionar" role="tabpanel"
                     aria-labelledby="nav-adicionar-tab">

                    <form class="formulario" method="POST" role="form">

                        <div class="form-row">

                            <div class="form-group col-md">
                                <label for="select-tipo">Selecione um tipo</label>
                                <select id="select-tipo" name="select" class="custom-select">
                                    <option value="0" selected>Selecione um tipo</option>
                                    <option value="">box diversos</option>
                                    <option value="">box padrão</option>
                                    <option value="">ferragem 1000</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-row align-items-center">
                            <div class="form-group col-">
                                <img id="image-produto" src="{{ asset('img/boxdiversos/bxa1.png') }}" class="img-fluid"
                                     alt="Responsive image" style="height: 110px!important;">
                                <label for="url-image-produto"></label>
                                <input type="text" id="url-image-produto" name="url-image-produto" style="display: none;">
                            </div>

                            <div class="form-group col-md">
                                <label for="select-produto">Selecione o produto</label>
                                <select id="select-produto" name="select" class="custom-select">
                                    <option value="0" selected>Selecione um produto</option>
                                    <option value="">bx-a1</option>
                                    <option value="">bx-c1</option>
                                    <option value="">r2-d2</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Descrição</label>
                                <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Altura</label>
                                <input type="number" class="form-control" id="altura" name="altura" placeholder="2,200"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Largura</label>
                                <input type="number" class="form-control" id="largura" name="largura" placeholder="1,200"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Quantidade</label>
                                <input type="number" class="form-control" id="quantidade" name="quantidade" placeholder="quantidade"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Localização</label>
                                <input type="text" class="form-control" id="localizacao" name="localizacao" placeholder="Localização"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Valor da mão de obra</label>
                                <input type="number" class="form-control" id="mao-de-obra" name="mao-de-obra" placeholder=""
                                       required>
                            </div>

                        </div>

                    </form>

                </div>
                <div class="tab-pane fade" id="nav-material" role="tabpanel"
                           aria-labelledby="nav-material-tab">

                    <form class="formulario" method="POST" role="form">

                        <div class="form-row align-items-center">
                            <div class="form-group col-">
                                <img id="image-produto" src="{{ asset('img/boxdiversos/bxa1.png') }}" class="img-fluid"
                                     alt="Responsive image" style="height: 110px!important;">
                                <label for="url-image-produto"></label>
                                <input type="text" id="url-image-produto" name="url-image-produto" style="display: none;">
                            </div>

                            <div class="form-group col-md">
                                <label for="select-produto">Selecione o produto</label>
                                <select id="select-produto" name="select" class="custom-select">
                                    <option value="0" selected>Selecione um produto</option>
                                    <option value="">bx-a1</option>
                                    <option value="">bx-c1</option>
                                    <option value="">r2-d2</option>
                                </select>
                            </div>
                        </div>


                        <!-- INICIO RADIO BUTTON DE MATERIAIS -->
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                    <label class="btn btn-primary active w-33">
                                        <input type="radio" name="options" id="option1" autocomplete="off" checked> Vidro
                                    </label>
                                    <label class="btn btn-primary w-33">
                                        <input type="radio" name="options" id="option2" autocomplete="off"> Alumínio
                                    </label>
                                    <label class="btn btn-primary w-33">
                                        <input type="radio" name="options" id="option3" autocomplete="off"> Componente
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- FIM RADIO BUTTON DE MATERIAIS -->

                        <!-- INICIO SELECT DO MATERIAL -->
                        <div class="form-row mt-3 align-items-end">

                            <div class="form-group col-md-4">
                                <label for="select-categoria">Vidros</label>
                                <select id="select-categoria" class="custom-select">
                                    <option value="0" selected>Selecione um vidro</option>
                                    <option value="">Vidro temperado</option>
                                    <option value="">Vidro azul</option>
                                    <option value="">Vidro blindado</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <a class="btn-link mb-3" href="{{ route('budgets.create') }}">
                                    <button class="btn btn-primary btn-block btn-custom" type="submit">Adicionar</button>
                                </a>
                            </div>
                        </div>
                        <!-- FIM SELECT DO MATERIAL -->

                        <!-- INICIO DA TABELA DE MATERIAL DO MATERIAL -->
                        <div class="form-row">

                            <div class="form-group col-12">
                                <div class="topo">
                                    <h4 class="titulo">Vidros</h4>
                                </div>

                                @if(session('success'))
                                    <div class="alerta">
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @elseif(session('error'))
                                    <div class="alerta">
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <!--INICIO HEAD DO VIDRO-->
                                        <tr class="tabela-vidro">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Nome</th>
                                            <th class="noborder" scope="col">Preço m²</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO VIDRO-->

                                        <!--INICIO HEAD DO ALUMINIO-->
                                        <tr class="tabela-aluminio" style="display: none;">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Perfil</th>
                                            <th class="noborder" scope="col">Medida</th>
                                            <th class="noborder" scope="col">Peso</th>
                                            <th class="noborder" scope="col">Preço</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO ALUMINIO-->

                                        <!--INICIO HEAD DO COMPONENTE-->
                                        <tr class="tabela-componente" style="display: none;">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Nome</th>
                                            <th class="noborder" scope="col">Preço</th>
                                            <th class="noborder" scope="col">Qtd</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO COMPONENTE-->

                                        </thead>
                                        <tbody>
                                        <!--INICIO BODY DO VIDRO-->
                                        <tr class="tabela-vidro">
                                            <th scope="row">1</th>
                                            <td>Vidro temperado 08mm</td>
                                            <td>100.0</td>
                                            <td>

                                                <a class="btn-link" href="#">
                                                    <button class="btn btn-warning mb-1">Edit</button>
                                                </a>
                                                <a class="btn-link">
                                                    <button class="btn btn-danger mb-1">Delete</button>
                                                </a>

                                            </td>
                                        </tr>
                                        <!--FIM BODY DO VIDRO-->

                                        <!--INICIO BODY DO ALUMINIO-->
                                        <tr class="tabela-aluminio" style="display: none;">
                                            <th scope="row">1</th>
                                            <td>xt-201</td>
                                            <td>6000.0m</td>
                                            <td>1.6kg</td>
                                            <td>22.0</td>
                                            <td>

                                                <a class="btn-link" href="#">
                                                    <button class="btn btn-warning mb-1">Edit</button>
                                                </a>
                                                <a class="btn-link">
                                                    <button class="btn btn-danger mb-1">Delete</button>
                                                </a>

                                            </td>
                                        </tr>
                                        <!--FIM BODY DO ALUMINIO-->

                                        <!--INICIO BODY DO COMPONENTE-->
                                        <tr class="tabela-componente" style="display: none;">
                                            <th scope="row">1</th>
                                            <td>Roldana</td>
                                            <td>1.0</td>
                                            <td>1</td>
                                            <td>

                                                <a class="btn-link" href="#">
                                                    <button class="btn btn-warning mb-1">Edit</button>
                                                </a>
                                                <a class="btn-link">
                                                    <button class="btn btn-danger mb-1">Delete</button>
                                                </a>

                                            </td>
                                        </tr>
                                        <!--FIM BODY DO COMPONENTE-->
                                        </tbody>
                                    </table>


                                </div>
                            </div>

                        </div>
                        <!-- FIM DA TABELA DE MATERIAL DO MATERIAL -->


                    </form>

                </div>

                <div class="tab-pane fade" id="nav-total" role="tabpanel"
                     aria-labelledby="nav-total-tab">

                    <form class="formulario" method="POST" role="form">


                        <div class="form-row">
                            <div class="card-material custom-card custom-card-total col-md p-3">
                                <h4 class="card-title text-primary">Total</h4>
                                <span class="card-shadow-1dp col-md mb-2"></span>
                                <label class="card-text">Produto BX-01</label>
                                <label class="card-text">Produto BX-01</label>
                                <label class="card-text">Produto BX-01</label>
                                <label class="card-text">Produto BX-01</label>
                                <label class="card-text">Produto BX-01</label>
                                <label class="card-text">Produto BX-01</label>

                            </div>

                        </div>
                        <div class="form-row">

                            <div class="card-material custom-card custom-card-total col-md p-3">
                                <h4 class="card-title text-primary">Materiais</h4>
                                <span class="card-shadow-1dp col-md mb-2"></span>
                                <label class="card-text">Vidro 1</label>
                                <label class="card-text">Vidro 1</label>
                                <label class="card-text">Vidro 1</label>
                                <label class="card-text">Vidro 1</label>
                                <label class="card-text">Vidro 1</label>

                            </div>

                        </div>

                        <div class="form-row">

                            <div class="card-material custom-card custom-card-total col-md p-3">
                                <h4 class="card-title text-primary">Componentes</h4>
                                <span class="card-shadow-1dp col-md mb-2"></span>
                                <label class="card-text">Roldana</label>
                                <label class="card-text">Roldana</label>
                                <label class="card-text">Roldana</label>
                            </div>

                        </div>


                    </form>

                </div>

            </div>
            <!--Fim Conteudo de cada tab -->

        </div>
    </div>
@endsection
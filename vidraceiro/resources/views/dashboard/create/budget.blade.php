@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <!-- Inicio tab de Produto-->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @for($i = 0; $i < count($titulotabs); $i++)
                        @if($i == 0)
                            <a class="nav-item nav-link {{ empty(session('budgetcriado')) ? 'active' : 'disabled' }} noborder-left" id="nav-{{$titulotabs[$i]}}-tab"
                               data-toggle="tab"
                               href="#nav-{{$titulotabs[$i]}}" role="tab" aria-controls="nav-{{$titulotabs[$i]}}"
                               aria-selected="true">{{$titulotabs[$i]}}</a>
                        @elseif($i == 1)
                                <a class="nav-item nav-link {{ empty(session('budgetcriado')) ? 'disabled' : 'active' }}" id="nav-{{$titulotabs[$i]}}-tab" data-toggle="tab"
                                   href="#nav-{{$titulotabs[$i]}}" role="tab" aria-controls="nav-{{$titulotabs[$i]}}"
                                   aria-selected="false">{{$titulotabs[$i]}}</a>
                            @else
                                <a class="nav-item nav-link {{ empty(session('budgetcriado')) ? 'disabled' : '' }}" id="nav-{{$titulotabs[$i]}}-tab" data-toggle="tab"
                                   href="#nav-{{$titulotabs[$i]}}" role="tab" aria-controls="nav-{{$titulotabs[$i]}}"
                                   aria-selected="false">{{$titulotabs[$i]}}</a>
                        @endif
                    @endfor

                    {{--<!-- INICIO ABA EXTRA AO EDITAR ORÇAMENTO -->--}}

                    {{--<a class="nav-item nav-link" id="nav-editar-tab" data-toggle="tab"--}}
                    {{--href="#nav-editar" role="tab" aria-controls="nav-editar"--}}
                    {{--aria-selected="false">Editar</a>--}}

                    {{--<!-- FIM ABA EXTRA AO EDITAR ORÇAMENTO -->--}}

                    {{--<a class="nav-item nav-link" id="nav-adicionar-tab" data-toggle="tab"--}}
                    {{--href="#nav-adicionar" role="tab" aria-controls="nav-adicionar"--}}
                    {{--aria-selected="false">Adicionar</a>--}}

                    {{--<a class="nav-item nav-link" id="nav-material-tab" data-toggle="tab"--}}
                    {{--href="#nav-material" role="tab" aria-controls="nav-material"--}}
                    {{--aria-selected="false">Material</a>--}}

                    {{--<a class="nav-item nav-link" id="nav-total-tab" data-toggle="tab"--}}
                    {{--href="#nav-total" role="tab" aria-controls="nav-total"--}}
                    {{--aria-selected="false">Total</a>--}}

                    <div class="topo-tab">
                        <button id="bt-budget-visible" class="btn btn-primary btn-custom" type="submit">
                            Salvar
                        </button>
                    </div>
                </div>
            </nav>
            <!-- Fim tab de Produto-->

            <!--Inicio Conteudo de cada tab -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade {{ empty(session('budgetcriado')) ? 'show active' : '' }} " id="nav-{{$titulotabs[0]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[0]}}-tab">

                    <form id="form-product" class="formulario" method="POST" role="form"
                          action="{{ !empty($budget) ?  route('budgets.update',['id'=>$budget->id,'tag' => '1']) :  route('budgets.store',['tag' => '1'])}}">
                        @if(!empty($budget))
                            <input type="hidden" name="_method" value="PATCH">
                        @endif
                        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                       value="{{$budget->nome or old('nome')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="data">Data</label>
                                <input type="date" class="form-control" id="data" name="data" placeholder="00/00/0000"
                                       value="{{$budget->data or old('data')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="telefone">Telefone</label>
                                <input type="tel" class="form-control" id="telefone" name="telefone"
                                       placeholder="(00)0000-0000"
                                       value="{{$budget->telefone or old('telefone')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="rua">Rua</label>
                                <input type="text" class="form-control" id="rua" name="rua"
                                       placeholder="av. de algum lugar"
                                       value="{{$budget->rua or old('rua')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="cep">Cep</label>
                                <input type="number" class="form-control" id="cep" name="cep" placeholder="00000-000"
                                       value="{{$budget->cep or old('cep')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="numero_endereco">N°</label>
                                <input type="number" class="form-control" id="numero_endereco" name="numero_endereco"
                                       placeholder="100"
                                       value="{{$budget->numero_endereco or old('numero_endereco')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="bairro">Bairro</label>
                                <input type="text" class="form-control" id="bairro" name="bairro"
                                       placeholder="bairro" value="{{$budget->bairro or old('bairro')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="select-UF">UF</label>
                                <select id="select-UF" name="uf" class="custom-select">
                                    @foreach ($states as $uf => $estado)
                                        <option value="{{$uf}}"
                                        @if(!empty($budget)){{ $budget->uf == $uf ? 'selected' :''}} @endif>{{$estado}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="cidade">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade"
                                       placeholder="cidade" value="{{$budget->cidade or old('cidade')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="complemento">Complemento</label>
                                <input type="text" class="form-control" id="complemento" name="complemento"
                                       placeholder="complemento" value="{{$budget->complemento or old('complemento')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="margem_lucro">Margem de lucro</label>
                                <input type="number" class="form-control" id="margem_lucro" name="margem_lucro"
                                       placeholder="100" value="{{$budget->margem_lucro or old('margem_lucro')}}">
                            </div>


                        </div>

                        <button id="bt-orcamento-budget-invisible" class="d-none" type="submit"></button>

                    </form>

                </div>

                <!-- INICIO CONTEUDO ABA EXTRA AO EDITAR ORÇAMENTO -->
                <div class="tab-pane fade {{ !empty(session('budgetcriado')) ? 'show active' : '' }}" id="nav-{{$titulotabs[1]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[1]}}-tab">

                    <form class="formulario" method="POST" role="form"
                          action="{{ !empty($budget) ?  route('budgets.update',['id'=>$budget->id,'tag' => '2']) :  route('budgets.store',['tag' => '2'])}}">
                        @if(!empty($budget))
                            <input type="hidden" name="_method" value="PATCH">
                        @endif
                        @csrf
                        <div class="form-row align-items-center">
                            <div class="form-group col-">
                                <img id="image-produto" src="{{ asset('img/boxdiversos/bxa1.png') }}" class="img-fluid"
                                     alt="Responsive image" style="height: 110px!important;">
                            </div>

                            <div class="form-group col-md">
                                <label for="select-produto">Selecione o produto</label>
                                <select id="select-produto" class="custom-select" required>
                                    <option value="" selected>Selecione um produto</option>
                                    <option value="">bx-a1</option>
                                    <option value="">bx-c1</option>
                                    <option value="">r2-d2</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Descrição</label>
                                <input type="text" class="form-control" id="descricao" name="descricao"
                                       placeholder="Descrição"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Altura</label>
                                <input type="number" class="form-control" id="altura" name="altura" placeholder="2,200"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Largura</label>
                                <input type="number" class="form-control" id="largura" name="largura"
                                       placeholder="1,200"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Quantidade</label>
                                <input type="number" class="form-control" id="quantidade" name="quantidade"
                                       placeholder="quantidade"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Localização</label>
                                <input type="text" class="form-control" id="localizacao" name="localizacao"
                                       placeholder="Localização"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Valor da mão de obra</label>
                                <input type="number" class="form-control" id="mao-de-obra" name="mao-de-obra"
                                       placeholder=""
                                       required>
                            </div>

                        </div>

                        <button id="bt-edit-budget-invisible" class="d-none" type="submit"></button>

                    </form>

                </div>
                <!-- FIM CONTEUDO ABA EXTRA AO EDITAR ORÇAMENTO -->

                <div class="tab-pane fade" id="nav-{{$titulotabs[2]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[2]}}-tab">

                    <form class="formulario" method="POST" role="form"
                          action="{{ !empty($budget) ?  route('budgets.update',['id'=>$budget->id,'tag' => '3']) :  route('budgets.store',['tag' => '3'])}}">
                        @if(!empty($budget))
                            <input type="hidden" name="_method" value="PATCH">
                        @endif
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md">
                                <label for="select-tipo-produto">Selecione um tipo</label>
                                <select id="select-tipo-produto" class="custom-select" required>
                                    <option value="" selected>Selecione uma categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->nome}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="form-row align-items-center">
                            <div class="form-group col-">
                                <img id="image-mproduto" src="{{ asset('img/semimagem.png') }}" class="img-fluid"
                                     alt="Responsive image" style="height: 110px!important;">
                            </div>

                            <div class="form-group col-md">
                                <label for="select-mproduto">Selecione o produto</label>
                                <select id="select-mproduto" name="m_produto_id" class="custom-select" required>
                                    <option id="option-vazia" value="" selected>Selecione um produto</option>
                                    @foreach($mproducts as $mproduct)
                                        <option data-descricao="{{$mproduct->descricao}}"
                                                data-image="{{$mproduct->imagem}}"
                                                data-categoria="{{$mproduct->categoria_produto_id}}"
                                                class="mprodutos-options" value="{{$mproduct->id}}"
                                                style="display: none;">{{$mproduct->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="descricao-mprod">Descrição</label>
                                <input type="text" class="form-control" id="descricao-mprod" name="descricao"
                                       placeholder="Descrição"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Altura</label>
                                <input type="number" class="form-control" id="altura" name="altura" placeholder="2,200"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Largura</label>
                                <input type="number" class="form-control" id="largura" name="largura"
                                       placeholder="1,200"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Quantidade</label>
                                <input type="number" class="form-control" id="quantidade" name="quantidade"
                                       placeholder="quantidade"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Localização</label>
                                <input type="text" class="form-control" id="localizacao" name="localizacao"
                                       placeholder="Localização"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Valor da mão de obra</label>
                                <input type="number" class="form-control" id="mao-de-obra" name="mao-de-obra"
                                       placeholder=""
                                       required>
                            </div>

                        </div>

                        <button id="bt-add-budget-invisible" class="d-none" type="submit"></button>

                    </form>

                </div>
                <div class="tab-pane fade" id="nav-{{$titulotabs[3]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[3]}}-tab">

                    <form class="formulario" method="POST" role="form"
                          action="{{ !empty($budget) ?  route('budgets.update',['id'=>$budget->id,'tag' => '4']) :  route('budgets.store',['tag' => '4'])}}">
                        @if(!empty($budget))
                            <input type="hidden" name="_method" value="PATCH">
                        @endif
                        @csrf
                        <div class="form-row align-items-center">
                            <div class="form-group col-">
                                <img id="image-produto" src="{{ asset('img/boxdiversos/bxa1.png') }}" class="img-fluid"
                                     alt="Responsive image" style="height: 110px!important;">
                            </div>

                            <div class="form-group col-md">
                                <label for="select-produto">Selecione o produto</label>
                                <select id="select-produto" class="custom-select" required>
                                    <option value="" selected>Selecione um produto</option>
                                    <option value="">bx-a1</option>
                                    <option value="">bx-c1</option>
                                    <option value="">r2-d2</option>
                                </select>
                            </div>
                        </div>


                        <!-- INICIO SELECT DE MATERIAIS -->
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <label for="select-material">Materiais</label>
                                <select id="select-material" class="custom-select">
                                    <option value="0">Vidros</option>
                                    <option value="1">Aluminios</option>
                                    <option value="2">Componentes</option>
                                </select>
                            </div>
                        </div>
                        <!-- FIM SELECT DE MATERIAIS -->

                        <!-- INICIO SELECT DO MATERIAL -->
                        <div class="form-row mt-3 align-items-end">

                            <div class="form-group col-md-4">
                                <label for="select-vidro" id="label_categoria">Vidros</label>
                                <select id="select-vidro" name="id_vidro" class="custom-select" required>
                                    <option value="" selected>Selecione um vidro</option>
                                    @foreach($glasses as $glass)
                                        <option value="{{$glass->id}}">{{$glass->nome}}</option>
                                    @endforeach
                                </select>
                                <select id="select-aluminio" name="id_aluminio" class="custom-select"
                                        style="display: none;" required>
                                    <option value="" selected>Selecione um aluminio</option>
                                    @foreach($aluminums as $aluminum)
                                        <option value="{{$aluminum->id}}">{{$aluminum->perfil}}</option>
                                    @endforeach
                                </select>
                                <select id="select-componente" name="id_componente" class="custom-select"
                                        style="display: none;" required>
                                    <option value="" selected>Selecione um componente</option>
                                    @foreach($components as $component)
                                        <option value="{{$component->id}}">{{$component->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <a class="btn-link mb-3" href="{{ route('mproducts.create') }}">
                                    <button class="btn btn-primary btn-block btn-custom" type="submit">Adicionar
                                    </button>
                                </a>
                            </div>

                        </div>
                        <!-- FIM SELECT DO MATERIAL -->

                        <!-- INICIO DA TABELA DE MATERIAL DO MATERIAL -->
                        <div class="form-row">

                            <div class="form-group col-12">
                                <div class="topo pl-0">
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
                                        <tr id="topo-vidro">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Nome</th>
                                            <th class="noborder" scope="col">Preço m²</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO VIDRO-->

                                        <!--INICIO HEAD DO ALUMINIO-->
                                        <tr id="topo-aluminio" style="display: none;">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Perfil</th>
                                            <th class="noborder" scope="col">Medida</th>
                                            <th class="noborder" scope="col">Peso</th>
                                            <th class="noborder" scope="col">Preço</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO ALUMINIO-->

                                        <!--INICIO HEAD DO COMPONENTE-->
                                        <tr id="topo-componente" style="display: none;">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Nome</th>
                                            <th class="noborder" scope="col">Preço</th>
                                            <th class="noborder" scope="col">Qtd</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO COMPONENTE-->

                                        </thead>

                                        <!--INICIO BODY DO VIDRO-->
                                        <tbody id="tabela-vidro">
                                            @if(!empty($budget))
                                                @foreach($glassesProduct as $glassP)
                                                    <tr>
                                                        <th scope="row">{{$glassP->id}}</th>
                                                        <td>{{$glassP->nome}}</td>
                                                        <td>R${{$glassP->preco}}</td>
                                                        <td>
                                                            <a class="btn-link">
                                                                <button class="btn btn-danger mb-1">Delete</button>
                                                            </a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <!--FIM BODY DO VIDRO-->

                                        <!--INICIO BODY DO ALUMINIO-->
                                        <tbody id="tabela-aluminio" style="display: none;">
                                            @if(!empty($budget))
                                                @foreach($aluminumsProduct as $aluminumP)
                                                    <tr>
                                                        <th scope="row">{{$aluminumP->id}}</th>
                                                        <td>{{$aluminumP->perfil}}</td>
                                                        <td>{{$aluminumP->medida}}</td>
                                                        <td>{{$aluminumP->peso}}</td>
                                                        <td>{{$aluminumP->preco}}</td>
                                                        <td>
                                                            <a class="btn-link">
                                                                <button class="btn btn-danger mb-1">Delete</button>
                                                            </a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <!--FIM BODY DO ALUMINIO-->

                                        <!--INICIO BODY DO COMPONENTE-->
                                        <tbody id="tabela-componente" style="display: none;">
                                            @if(!empty($budget))
                                                @foreach($componentsProduct as $componentP)
                                                    <tr>
                                                        <th scope="row">{{$componentP->id}}</th>
                                                        <td>{{$componentP->nome}}</td>
                                                        <td>{{$componentP->preco}}</td>
                                                        <td>{{$componentP->qtd}}</td>
                                                        <td>
                                                            <a class="btn-link">
                                                                <button class="btn btn-danger mb-1">Delete</button>
                                                            </a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <!--FIM BODY DO COMPONENTE-->

                                    </table>


                                </div>
                            </div>

                        </div>
                        <!-- FIM DA TABELA DE MATERIAL DO MATERIAL -->

                        <button id="bt-material-budget-invisible" class="d-none" type="submit"></button>

                    </form>

                </div>

                <div class="tab-pane fade" id="nav-{{$titulotabs[4]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[4]}}-tab">

                    <form class="formulario" method="POST" role="form"
                          action="{{ !empty($budget) ?  route('budgets.update',['id'=>$budget->id,'tag' => '5']) :  route('budgets.store',['tag' => '5'])}}">
                        @if(!empty($budget))
                            <input type="hidden" name="_method" value="PATCH">
                        @endif
                        @csrf
                        <div class="form-row">
                            <div class="card-material custom-card custom-card-total col-md p-3">
                                <div class="topo px-0 py-0 h-auto">
                                    <h4 class="card-title cor-texto">Total</h4>
                                </div>
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
                                <div class="topo px-0 py-0 h-auto">
                                    <h4 class="card-title cor-texto">Materiais</h4>
                                </div>
                                <label class="card-text">Vidro 1</label>
                                <label class="card-text">Vidro 1</label>
                                <label class="card-text">Vidro 1</label>
                                <label class="card-text">Vidro 1</label>
                                <label class="card-text">Vidro 1</label>

                            </div>

                        </div>

                        <div class="form-row">

                            <div class="card-material custom-card custom-card-total col-md p-3">
                                <div class="topo px-0 py-0 h-auto">
                                    <h4 class="card-title cor-texto">Componentes</h4>
                                </div>
                                <label class="card-text">Roldana</label>
                                <label class="card-text">Roldana</label>
                                <label class="card-text">Roldana</label>
                            </div>

                        </div>

                        <button id="bt-total-budget-invisible" class="d-none" type="submit"></button>

                    </form>

                </div>

            </div>
            <!--Fim Conteudo de cada tab -->

        </div>
    </div>
@endsection
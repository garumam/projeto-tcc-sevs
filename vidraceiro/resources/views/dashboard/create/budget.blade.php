@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

        <input type="hidden" id="tabSession" data-value="{{session('tab')? session('tab') : ''}}" />
            <div class="nav nav-tabs" id="nav-tab">
                @for($i = 0; $i < count($titulotabs); $i++)
                    @if($i == 0)
                        <a class="tabs-budget nav-item nav-link {{ session('tab')? '' : 'current' }}"
                           data-tab="nav-{{$titulotabs[$i]}}-tab">{{$titulotabs[$i]}}</a>
                    @elseif($i != 0)
                        <a class="tabs-budget nav-item nav-link {{ !empty($budgetedit)? '':'disabled' }}"
                           data-tab="nav-{{$titulotabs[$i]}}-tab">{{$titulotabs[$i]}}</a>
                    @endif
                @endfor
                <div class="topo-tab">
                    <a class="btn-link bt-budget-deletar-produto" onclick="deletar(event,this.id,'budgets/product')"
                       id="vazio" style="display: none;">
                        <button class="btn btn-danger">Deletar</button>
                    </a>
                    <button id="bt-budget-visible" class="btn btn-primary btn-custom" type="submit">
                        Salvar
                    </button>
                </div>
            </div>


        {{--<!-- Inicio tab de Produto-->--}}
        {{--<nav>--}}
        {{--<div class="nav nav-tabs" id="nav-tab" role="tablist">--}}
        {{--@for($i = 0; $i < count($titulotabs); $i++)--}}
        {{--@if($i == 0)--}}
        {{--<a class="tabs-budget nav-item nav-link active noborder-left"--}}
        {{--id="nav-{{$titulotabs[$i]}}-tab"--}}
        {{--data-toggle="tab"--}}
        {{--href="#nav-{{$titulotabs[$i]}}" role="tab" aria-controls="nav-{{$titulotabs[$i]}}"--}}
        {{--aria-selected="true">{{$titulotabs[$i]}}</a>--}}
        {{--@elseif($i == 1)--}}
        {{--<a class="tabs-budget nav-item nav-link {{ !empty($budgetedit)? '':'disabled' }}"--}}
        {{--id="nav-{{$titulotabs[$i]}}-tab" data-toggle="tab"--}}
        {{--href="#nav-{{$titulotabs[$i]}}" role="tab" aria-controls="nav-{{$titulotabs[$i]}}"--}}
        {{--aria-selected="false">{{$titulotabs[$i]}}</a>--}}
        {{--@else--}}
        {{--<a class="tabs-budget nav-item nav-link {{ empty($budgetedit) ? 'disabled' : '' }}"--}}
        {{--id="nav-{{$titulotabs[$i]}}-tab" data-toggle="tab"--}}
        {{--href="#nav-{{$titulotabs[$i]}}" role="tab" aria-controls="nav-{{$titulotabs[$i]}}"--}}
        {{--aria-selected="false">{{$titulotabs[$i]}}</a>--}}
        {{--@endif--}}
        {{--@endfor--}}


        {{--<div class="topo-tab">--}}
        {{--<a class="btn-link bt-budget-deletar-produto" onclick="deletar(event,this.id,'budgets/product')"--}}
        {{--id="vazio" style="display: none;">--}}
        {{--<button class="btn btn-danger">Deletar</button>--}}
        {{--</a>--}}
        {{--<button id="bt-budget-visible" class="btn btn-primary btn-custom" type="submit">--}}
        {{--Salvar--}}
        {{--</button>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</nav>--}}
        <!-- Fim tab de Produto-->

            <!--Inicio Conteudo de cada tab -->
            <div id="nav-{{$titulotabs[0]}}-tab" class="tab-content current">
                {{--<div class="tab-pane fade show active"--}}
                {{--id="nav-{{$titulotabs[0]}}" role="tabpanel"--}}
                {{--aria-labelledby="nav-{{$titulotabs[0]}}-tab">--}}

                <form id="form-product" class="formulario" method="POST" role="form"
                      action="{{ !empty($budgetedit) ?  route('budgets.update',['id'=>$budgetedit->id,'tag' => '1']) :  route('budgets.store')}}">
                    @if(!empty($budgetedit))
                        <input type="hidden" name="_method" value="PATCH">
                    @endif
                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                    <div class="form-row">

                        <div class="col-12">
                            @if(session('success'))
                                <div class="alerta p-0">
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
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group col-md-4">
                            <label for="select-cliente">Cliente</label>
                            <select id="select-cliente" class="form-control form-control-chosen" name="cliente_id"
                                    data-placeholder="Selecie um cliente(opcional)" style="display: none;">
                                <option value="">Nada selecionado</option>
                                @foreach ($clients as $client)
                                    <option value="{{$client->id}}"
                                            data-endereco="{{$client->endereco}}"
                                            data-cep="{{$client->cep}}"
                                            data-bairro="{{$client->bairro}}"
                                            data-cidade="{{$client->cidade}}"
                                            data-uf="{{$client->uf}}"
                                            data-complemento="{{$client->complemento}}"
                                            data-telefone="{{$client->telefone}}"
                                    @if(!empty($budgetedit)){{ $budgetedit->cliente_id == $client->id ? 'selected' :''}} @endif>{{$client->nome}}@if($client->cpf !== null){{', cpf: '.$client->cpf}}@else {{', cnpj: '.$client->cnpj}} @endif</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="nome" class="obrigatorio">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                   value="{{$budgetedit->nome or old('nome')}}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="data">Data</label>
                            <input type="date" class="form-control" id="data" name="data" placeholder="00/00/0000"
                                   value="{{$budgetedit->data or date('Y-m-d', time())}}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="telefone">Telefone</label>
                            <input type="tel" class="form-control" id="telefone" name="telefone"
                                   placeholder="(00)0000-0000"
                                   value="{{$budgetedit->telefone or old('telefone')}}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="endereco">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco"
                                   placeholder="Av. exemplo, n° 250"
                                   value="{{$budgetedit->endereco or old('endereco')}}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="cep" class="obrigatorio">Cep</label>
                            <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000"
                                   value="{{$budgetedit->cep or old('cep')}}" minlength="9" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="bairro">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro"
                                   placeholder="bairro" value="{{$budgetedit->bairro or old('bairro')}}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="select-UF">UF</label>
                            <select id="select-UF" name="uf" class="custom-select">
                                @foreach ($states as $uf => $estado)
                                    <option value="{{$uf}}"
                                    @if(!empty($budgetedit)){{ $budgetedit->uf == $uf ? 'selected' :''}} @endif>{{$estado}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="cidade">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade"
                                   placeholder="cidade" value="{{$budgetedit->cidade or old('cidade')}}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="complemento">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento"
                                   placeholder="complemento"
                                   value="{{$budgetedit->complemento or old('complemento')}}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="margem_lucro">Margem de lucro</label>
                            <input type="number" class="form-control" id="margem_lucro" name="margem_lucro"
                                   placeholder="100" value="{{$budgetedit->margem_lucro or old('margem_lucro')}}">
                        </div>


                    </div>

                    <button id="bt-orcamento-budget-invisible" class="d-none" type="submit"></button>

                </form>

            </div>
            @if(!empty($budgetedit))
                <div id="nav-{{$titulotabs[1]}}-tab" class="tab-content">

                    <form class="formulario" method="POST" role="form"
                          action="{{route('budgets.update',['id'=>$budgetedit->id,'tag' => '2'])}}">

                        <input type="hidden" name="_method" value="PATCH">

                        @csrf
                        <div class="form-row">

                            <div class="col-12">
                                @if(session('success'))
                                    <div class="alerta p-0">
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @elseif(session('error'))
                                    <div class="alerta p-0">
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif

                                @foreach($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group col-md">
                                <label for="select-tipo-produto" class="obrigatorio">Selecione um tipo</label>
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
                                <img id="image-mproduto" src="{{ '/img/semimagem.png' }}" class="img-fluid"
                                     alt="Responsive image" style="height: 110px!important;">
                            </div>

                            <div class="form-group col-md">
                                <label for="select-mproduto" class="obrigatorio">Selecione o produto</label>
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
                                <input type="text" class="form-control" id="descricao-mprod" placeholder="Descrição">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="altura" class="obrigatorio">Altura</label>
                                <input type="text" class="form-control altura" id="altura" name="altura"
                                       placeholder="0.000"
                                       value="{{old('altura')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="largura" class="obrigatorio">Largura</label>
                                <input type="text" class="form-control largura" id="largura" name="largura"
                                       placeholder="0.000" value="{{old('largura')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="qtd" class="obrigatorio">Quantidade</label>
                                <input type="number" class="form-control" id="qtd" name="qtd"
                                       placeholder="quantidade" value="{{old('qtd')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="localizacao">Localização</label>
                                <input type="text" class="form-control" id="localizacao" name="localizacao"
                                       placeholder="Localização" value="{{old('localizacao')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="valor_mao_obra">Valor da mão de obra</label>
                                <input type="number" step=".01" class="form-control" id="valor_mao_obra"
                                       name="valor_mao_obra"
                                       placeholder="" value="{{old('valor_mao_obra')}}">
                            </div>

                        </div>

                        <button id="bt-add-budget-invisible" class="d-none" type="submit"></button>

                    </form>

                </div>

                <!-- INICIO CONTEUDO ABA EXTRA AO EDITAR ORÇAMENTO -->
                <div id="nav-{{$titulotabs[2]}}-tab" class="tab-content">

                    <form class="formulario" method="POST" role="form"
                          action="{{route('budgets.update',['id'=>$budgetedit->id,'tag' => '3'])}}">

                        <input type="hidden" name="_method" value="PATCH">

                        @csrf
                        <div class="form-row align-items-center">

                            <div class="col-12">
                                @if(session('success'))
                                    <div class="alerta p-0">
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
                                @foreach($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group col-">
                                <img id="image-produto-editar" src="{{ '/img/semimagem.png' }}" class="img-fluid"
                                     alt="Responsive image" style="height: 110px!important;">
                            </div>

                            <div class="form-group col-md">
                                <label for="select-produto" class="obrigatorio">Selecione o produto</label>
                                <select id="select-produto-edit" name="produtoid" class="custom-select" required>
                                    <option value="" selected>Selecione um produto</option>

                                    @if(!empty($products))
                                        @foreach($products as $product)

                                            <option data-descricao="{{$product->mproduct->descricao}}"
                                                    data-image="{{$product->mproduct->imagem}}"
                                                    data-altura="{{$product->altura}}"
                                                    data-largura="{{$product->largura}}"
                                                    data-qtd="{{$product->qtd}}"
                                                    data-localizacao="{{$product->localizacao}}"
                                                    data-valor_mao_obra="{{$product->valor_mao_obra}}"
                                                    value="{{$product->id}}"
                                            >{{$product->mproduct->nome .' | M²: '.number_format(($product->altura*$product->largura), 3, '.', '' ) .' | M Linear: '.number_format((($product->altura * 2) + ($product->largura * 2)), 3, '.', '' )}}</option>

                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="descricao-edit">Descrição</label>
                                <input type="text" class="form-control" id="descricao-edit" placeholder="Descrição">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="altura-edit" class="obrigatorio">Altura</label>
                                <input type="text" class="form-control altura" id="altura-edit" name="altura"
                                       placeholder="0,000"
                                       value="{{old('altura')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="largura-edit" class="obrigatorio">Largura</label>
                                <input type="text" class="form-control largura" id="largura-edit" name="largura"
                                       placeholder="0,000" value="{{old('largura')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="qtd-edit" class="obrigatorio">Quantidade</label>
                                <input type="number" class="form-control" id="qtd-edit" name="qtd"
                                       placeholder="quantidade" value="{{old('qtd')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="localizacao-edit">Localização</label>
                                <input type="text" class="form-control" id="localizacao-edit" name="localizacao"
                                       placeholder="Localização" value="{{old('localizacao')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="valor_mao_obra-edit">Valor da mão de obra</label>
                                <input type="number" step=".01" class="form-control" id="valor_mao_obra-edit"
                                       name="valor_mao_obra"
                                       placeholder="" value="{{old('valor_mao_obra')}}">
                            </div>

                        </div>

                        <button id="bt-edit-budget-invisible" class="d-none" type="submit"></button>

                    </form>

                </div>
                <!-- FIM CONTEUDO ABA EXTRA AO EDITAR ORÇAMENTO -->

                <div id="nav-{{$titulotabs[3]}}-tab" class="tab-content pb-5">

                    <form class="formulario" method="POST" role="form"
                          action="{{route('budgets.update',['id'=>$budgetedit->id,'tag' => '4'])}}">

                        <input type="hidden" name="_method" value="PATCH">

                        @csrf
                        <div class="form-row align-items-center">

                            <div class="col-12">
                                @if(session('success'))
                                    <div class="alerta p-0">
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
                            </div>

                            <div class="form-group col-">
                                <img id="image-produto-material" src="{{ '/img/semimagem.png' }}" class="img-fluid"
                                     alt="Responsive image" style="height: 110px!important;">
                            </div>

                            <div class="form-group col-md">
                                <label for="select-produto" class="obrigatorio">Selecione o produto</label>
                                <select id="select-produto-material" class="custom-select" required>
                                    <option value="" selected>Selecione um produto</option>

                                    @if(!empty($products))
                                        @foreach($products as $product)

                                            <option data-image="{{$product->mproduct->imagem}}"
                                                    data-largura="{{$product->largura}}"
                                                    data-altura="{{$product->altura}}"
                                                    value="{{$product->id}}">{{$product->mproduct->nome .' | M²: '.number_format(($product->altura*$product->largura), 3, '.', '') .' | M Linear: '.number_format((($product->altura * 2) + ($product->largura * 2)), 3, '.', '' )}}</option>

                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>


                        @include('layouts.listarmaterial')


                        <button id="bt-material-budget-invisible" class="d-none" type="submit"></button>

                    </form>

                </div>

                <div id="nav-{{$titulotabs[4]}}-tab" class="tab-content">
                    @php $id = $budgetedit->id @endphp
                    <form class="formulario" method="GET" role="form" target="_blank"
                          action="{{ route('pdf.show',['tipo'=>'budget','id'=>$id]) }}">

                        <div class="form-row">

                            <div class="card-material custom-card custom-card-total col-md p-3">
                                <div class="topo px-0 py-0 h-auto">
                                    <h4 class="card-title cor-texto">Total</h4>
                                </div>

                                @if(!empty($products))
                                    <div class="card-text">
                                        @foreach($products as $product)
                                            <label>Produto: {{$product->mproduct->nome}}
                                                M²: {{ number_format($product['altura']*$product['largura'],2)}}
                                                | M Linear: {{($product['altura'] * 2) + ($product['largura'] * 2)}}
                                                Qtd: {{$product['qtd']}}</label>
                                        @endforeach

                                        <label><b>Valor do orçamento sem lucro:
                                                R$ {{ number_format($budgetedit['total']/(1+$budgetedit['margem_lucro']/100),2,'.','') }}</b></label>
                                        <label><b>Valor do orçamento: R$ {{ $budgetedit['total'] }}</b></label>

                                    </div>
                                @endif


                            </div>

                        </div>
                        <div class="form-row">

                            <div class="card-material custom-card custom-card-total col-md p-3">
                                <div class="topo px-0 py-0 h-auto">
                                    <h4 class="card-title cor-texto">Vidros</h4>
                                </div>
                                @if(!empty($products))
                                    <div class="card-text">
                                        @foreach($products as $product)
                                            <label><b>Vidros do produto: {{$product->mproduct->nome}}</b></label>
                                            @foreach($product->glasses as $glass)
                                                <label>Nome: {{$glass->nome .' '. $glass->tipo .' | Preço(m²): R$'. $glass->preco}}{{' | Preço total: R$'.number_format((($product->largura * $product->altura) * $glass->preco),2,'.','')}}</label>
                                            @endforeach
                                        @endforeach
                                    </div>
                                @endif

                            </div>

                        </div>

                        <div class="form-row">

                            <div class="card-material custom-card custom-card-total col-md p-3">
                                <div class="topo px-0 py-0 h-auto">
                                    <h4 class="card-title cor-texto">Aluminios</h4>
                                </div>
                                @if(!empty($products))
                                    <div class="card-text">
                                        @foreach($products as $product)
                                            <label><b>Alumínios do produto: {{$product->mproduct->nome}}</b></label>
                                            @foreach($product->aluminums as $aluminum)
                                                <label>Perfil: {{$aluminum->perfil .' '. $aluminum->descricao .' | Peso: '.$aluminum->peso.' | Qtd: '.$aluminum->qtd . ' | Preço(kg): R$ '.$aluminum->preco.' | Preço total: R$'.number_format((($aluminum->preco * $aluminum->peso) * $aluminum->qtd),2,'.','')}}</label>
                                            @endforeach
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="form-row">

                            <div class="card-material custom-card custom-card-total col-md p-3">
                                <div class="topo px-0 py-0 h-auto">
                                    <h4 class="card-title cor-texto">Componentes</h4>
                                </div>
                                @if(!empty($products))
                                    <div class="card-text">
                                        @foreach($products as $product)
                                            <label><b>Componentes do produto: {{$product->mproduct->nome}}</b></label>
                                            @foreach($product->components as $component)
                                                <label>Nome: {{$component->nome.' | Qtd: '.$component->qtd .' | Preço(uni): R$ '.$component->preco.' | Preço total: R$'.number_format(($component->preco * $component->qtd),2,'.','')}}</label>
                                            @endforeach
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                        </div>

                        <button id="bt-total-budget-invisible" class="d-none" type="submit"></button>

                    </form>

                </div>
        </div>
    </div>
    <!--Fim Conteudo de cada tab -->
    @endif


@endsection
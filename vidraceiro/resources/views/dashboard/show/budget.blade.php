@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card text-dark">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn btn-primary btn-custom" target="_blank"
                   href="{{route('pdf.show',['tipo'=>'budget','id'=>$budget->id])}}">Gerar PDF</a>
            </div>

            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Detalhes do orçamento
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            @php $client = $budget->client()->first();@endphp
                            <b>Nome do cliente: </b> {{$client->nome or ' Anônimo'}}
                            @if(!empty($client))
                                {{' | '}}
                                <a class="btn-link ml-2" target="_blank" href="{{ route('clients.show',['id'=> $client->id]) }}">
                                    <button class="btn btn-info mb-1 card-shadow-1dp" title="Ver">Veja...</button>
                                </a>
                            @endif

                            <hr>
                            <b>Nome do orçamento: </b> {{$budget->nome or 'Não cadastrado!'}}
                            <hr>
                            <b>Status: </b> {{$budget->status or 'Não cadastrado!'}}
                            <hr>
                            <b>Data: </b> {{$budget->data !== null?date_format(date_create($budget->data), 'd/m/Y'):'Não cadastrada!'}}
                            <hr>
                            <b>Margem de lucro: </b> {{$budget->margem_lucro.'%'}}
                            <hr>
                            <b>Total: </b> R${{$budget->total or ''}}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Formas de contato
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <b>Telefone: </b><label id="{{$budget->telefone !== null?'telefone':''}}"> {{$budget->telefone or 'não cadastrado!'}}</label>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Endereço
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            <b>Endereço: </b> {{$budget->endereco or 'não cadastrado!'}}
                            <hr>
                            <b>Bairro: </b> {{$budget->bairro or 'não cadastrado!'}}
                            <hr>
                            <b>Cidade: </b> {{$budget->cidade or 'não cadastrado!'}}
                            <hr>
                            <b>Uf: </b> {{$budget->uf or 'não cadastrado!'}}
                            <hr>
                            <b>Cep: </b><label id="{{$budget->cep !== null?'cep':''}}"> {{$budget->cep or 'não cadastrado!'}}</label>
                            <hr>
                            <b>Complemento: </b> {{$budget->complemento or 'não cadastrado!'}}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFour">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Produtos
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">
                            @forelse($budget->products()->get() as $product)
                                <b>Id: </b> {{$product->id}}{{' | '}}
                                <b>Nome: </b> {{$product->mproduct()->first()->nome or 'não cadastrado!'}}{{' | '}}
                                <b>Descrição: </b> {{$product->mproduct()->first()->descricao or 'não cadastrado!'}}{{' | '}}
                                <b>Linha: </b> {{$product->mproduct()->first()->category()->first()->nome or 'não cadastrado!'}}{{' | '}}
                                <b>Largura: </b> {{$product->largura or 'não cadastrado!'}}{{' | '}}
                                <b>Altura: </b> {{$product->altura or 'não cadastrado!'}}{{' | '}}
                                <b>Qtd: </b> {{$product->qtd or 'não cadastrado!'}}{{' | '}}
                                <b>Localização: </b> {{$product->localizacao or 'não cadastrado!'}}{{' | '}}
                                <b>Mão de obra: </b> R${{$product->valor_mao_obra or ''}}
                                <hr>
                            @empty
                                Nenhum produto neste orçamento!
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFive">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Materiais
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                        <div class="card-body">
                            @forelse($budget->products()->get() as $product)
                                <p><b>Id do produto: </b> {{$product->id}}{{' | '}}
                                <b>Nome do produto: </b> {{$product->mproduct()->first()->nome or 'não cadastrado!'}}</p>
                                <hr>
                                <p><b>Vidros: </b>
                                @forelse($product->glasses()->get() as $glass)
                                    {{$glass->nome.' '. $glass->tipo .' | '}}
                                @empty
                                    Nenhum vidro!
                                @endforelse
                                </p>
                                <p><b>Alumínios: </b>
                                    @forelse($product->aluminums()->get() as $aluminum)
                                        {{$aluminum->perfil.' '. $aluminum->descricao .' qtd:'.$aluminum->qtd.' | '}}
                                    @empty
                                        Nenhum Alumínio!
                                    @endforelse
                                </p>
                                <p><b>Componentes: </b>
                                    @forelse($product->components()->get() as $component)
                                        {{$component->nome.' qtd:'.$component->qtd.' | '}}
                                    @empty
                                        Nenhum componente!
                                    @endforelse
                                </p>
                                <hr>
                            @empty
                                Nenhum material neste orçamento!
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingSix">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Venda relacionada
                            </button>
                        </h5>
                    </div>
                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                        <div class="card-body">
                            @php $sale = $budget->sale()->first(); @endphp
                            @if(!empty($sale))
                                <p>
                                   <b>Id da venda: </b> {{$sale->id}}{{' | '}}
                                   <b>Tipo de pagamento: </b> {{$sale->tipo_pagamento}}
                                   <b>Data da venda: </b> {{date_format(date_create($sale->data_venda), 'd/m/Y')}}{{' | '}}
                                    <a class="btn-link ml-2" target="_blank" href="{{ route('sales.show',['id'=> $sale->id]) }}">
                                        <button class="btn btn-info mb-1 card-shadow-1dp" title="Ver">Veja...</button>
                                    </a>
                                </p>
                                <hr>
                            @else
                                Este orçamento ainda não tem relacionamento com uma venda!
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
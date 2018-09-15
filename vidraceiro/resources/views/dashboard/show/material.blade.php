@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card text-dark">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
            </div>

            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Dados do material
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <b>Categoria: </b> {{$material->category()->first()->nome or 'não cadastrado!'}}
                            <hr>
                            @switch($type)
                                @case('glass')
                                <b>Nome: </b> {{$material->nome or 'não cadastrado!'}}
                                <hr>
                                <b>Cor: </b> {{$material->cor or 'não cadastrado!'}}
                                <hr>
                                <b>Tipo: </b> {{$material->tipo or 'não cadastrado!'}}
                                <hr>
                                <b>Espessura: </b> {{$material->espessura or ''}}mm
                                <hr>
                                <b>Preço: </b> R${{$material->preco or ''}}
                                @break
                                @case('aluminum')
                                <b>Perfil: </b> {{$material->perfil or 'não cadastrado!'}}
                                <hr>
                                <b>Descrição: </b> {{$material->descricao or 'não cadastrado!'}}
                                <hr>
                                <b>Medida: </b> {{$material->medida or ''}}m
                                <hr>
                                <b>Qtd: </b> {{$material->qtd or 'não cadastrado!'}}
                                <hr>
                                <b>Peso: </b> {{$material->peso or ''}}Kg
                                <hr>
                                <b>Preço do Kg: </b> R${{$material->preco or ''}}
                                <hr>
                                <b>Espessura: </b> {{$material->espessura or ''}}mm
                                <hr>
                                <b>Tipo de medida: </b> {{$material->tipo_medida or 'não cadastrado!'}}
                                @break
                                @case('component')
                                <b>Nome: </b> {{$material->nome or 'não cadastrado!'}}
                                <hr>
                                <b>Qtd: </b> {{$material->qtd or 'não cadastrado!'}}
                                <hr>
                                <b>Preço: </b> R${{$material->preco or ''}}
                                @break
                            @endswitch
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Fornecedores
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            @forelse($material->providers()->get() as $provider)
                                <b>Fornecedor: </b> {{$provider->nome or 'não cadastrado!'}}{{' | '}}
                                <a class="btn-link ml-2" target="_blank" href="{{ route('providers.show',['id'=> $provider->id]) }}">
                                    <button class="btn btn-info mb-1 card-shadow-1dp" title="Ver">Veja mais sobre...</button>
                                </a>
                                <hr>
                            @empty
                                Nenhum fornecedor vinculado a este material!
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
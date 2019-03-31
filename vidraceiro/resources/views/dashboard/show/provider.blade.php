@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card text-dark">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn btn-primary btn-custom" target="_blank"
                   href="{{route('pdf.show',['tipo'=>'provider','id'=>$provider->id])}}">Gerar PDF</a>
            </div>

            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Dados do fornecedor
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <b>Nome: </b> {{$provider->nome or 'não cadastrado!'}}
                            <hr>
                            <b>Situação: </b> {{$provider->situacao or 'não cadastrado!'}}
                            <hr>
                            <b>Cnpj: </b> {{ App\Http\Controllers\PdfController::mask($provider->cnpj,'##.###.###/####-##') }}
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
                            @php 
                            $location = $provider->location()->first(); 
                            $contact = $provider->contact()->first();
                            @endphp
                            <b>Telefone: </b><label id="{{$contact->telefone !== null?'telefone':''}}"> {{$contact->telefone or 'não cadastrado!'}}</label>
                            <hr>
                            <b>Celular: </b><label id="{{$contact->celular !== null?'celular':''}}"> {{$contact->celular or 'não cadastrado!'}}</label>
                            <hr>
                            <b>Email: </b> {{$contact->email or 'não cadastrado!'}}
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
                            <b>Endereço: </b> {{$location->endereco or 'não cadastrado!'}}
                            <hr>
                            <b>Bairro: </b> {{$location->bairro or 'não cadastrado!'}}
                            <hr>
                            <b>Cidade: </b> {{$location->cidade or 'não cadastrado!'}}
                            <hr>
                            <b>Uf: </b> {{$location->uf or 'não cadastrado!'}}
                            <hr>
                            <b>Cep: </b><label id="{{$location->cep !== null?'cep':''}}"> {{$location->cep or 'não cadastrado!'}}</label>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFour">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Materiais fornecidos
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">
                            <b>Vidros: </b> 
                            @forelse($provider->glasses()->get() as $glass)
                            {{$glass->nome .' '.$glass->tipo.' | '}}
                            @empty
                            Nenhum vidro!
                            @endforelse
                            <hr>
                            <b>Alumínios: </b> 
                            @forelse($provider->aluminums()->get() as $aluminum)
                            {{$aluminum->perfil.' | '}}
                            @empty
                            Nenhum alumínio!
                            @endforelse
                            <hr>
                            <b>Componentes: </b>
                            @forelse($provider->components()->get() as $component)
                            {{$component->nome.' | '}}
                            @empty
                            Nenhum componente!
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
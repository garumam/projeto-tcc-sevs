@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card text-dark">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <div>
                    <a class="btn btn-primary btn-custom" target="_blank"
                       href="{{route('pdf.show',['tipo'=>'order','id'=>$order->id])}}">Gerar PDF</a>
                    <a class="btn btn-primary btn-custom" target="_blank"
                       href="{{route('pdf.show',['tipo'=>'order-comprar','id'=>$order->id])}}">Gerar pdf de compra</a>
                </div>
            </div>

            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Detalhes da ordem de serviço
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <b>Nome: </b> {{$order->nome or 'não cadastrado!'}}
                            <hr>
                            <b>Data inicial: </b> {{$order->data_inicial !== null?date_format(date_create($order->data_inicial), 'd/m/Y'):'Não cadastrada!'}}
                            <hr>
                            <b>Data final: </b> {{$order->data_final !== null?date_format(date_create($order->data_final), 'd/m/Y'):'Não cadastrada!'}}
                            <hr>
                            <b>Situação: </b> {{$order->situacao or 'não cadastrado!'}}
                            <hr>
                            <b>Valor total: </b> R${{$order->total or ''}}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Orçamentos relacionados
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            @forelse($order->budgets()->get() as $budget)
                                <b>Id: </b> {{$budget->id}}{{' | '}}
                                <b>Nome: </b> {{$budget->nome or 'não cadastrado!'}}{{' | '}}
                                <b>Valor: </b> R${{$budget->total or ''}}{{' | '}}
                                <a class="btn-link ml-2" target="_blank" href="{{ route('budgets.show',['id'=> $budget->id]) }}">
                                    <button class="btn btn-info mb-1 card-shadow-1dp" title="Ver">Veja...</button>
                                </a>
                                <hr>
                            @empty
                                Nenhum orçamento encontrado!
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
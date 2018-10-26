@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card text-dark">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn btn-primary btn-custom" target="_blank"
                   href="{{route('pdf.show',['tipo'=>'sale','id'=>$sale->id])}}">Gerar PDF</a>
            </div>

            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Detalhes da venda
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            @php $tipoPagamento = $sale->tipo_pagamento; @endphp
                            <b>Orçamento: </b> {{$sale->budget()->first()->nome or 'não cadastrado!'}}{{' | '}}
                            <a class="btn-link ml-2" target="_blank" href="{{ route('budgets.show',['id'=> $sale->budget()->first()->id]) }}">
                                <button class="btn btn-info mb-1 card-shadow-1dp" title="Ver">Veja...</button>
                            </a>
                            <hr>
                            <b>Total: </b> R${{$sale->budget()->first()->total or ''}}
                            <hr>
                            <b>Tipo de pagamento: </b> {{$tipoPagamento or 'não cadastrado!'}}
                            <hr>
                            @if($tipoPagamento === 'A PRAZO')
                                <b>Número de parcelas: </b> {{$sale->qtd_parcelas or 'não cadastrado!'}}
                                <hr>
                            @endif
                            <b>Data da venda: </b> {{$sale->data_venda !== null?date_format(date_create($sale->data_venda), 'd/m/Y'):'Não cadastrada!'}}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Pagamentos recebidos
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            @forelse($sale->payments()->get() as $payment)
                                <b>Valor pago: </b> R${{$payment->valor_pago or ''}}{{' | '}}
                                <b>Data de pagamento: </b> {{date_format(date_create($payment->data_pagamento), 'd/m/Y')}}
                                <hr>
                            @empty
                                Está venda não recebeu nenhum pagamento!
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Pagamentos pendentes
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            @forelse($sale->installments()->where('status_parcela','ABERTO')->get() as $installment)
                                <b>Valor da parcela: </b> R${{$installment->valor_parcela or ''}}{{' | '}}
                                <b>Valor da multa: </b> R${{$installment->multa or ''}}{{' | '}}
                                @php $valorTotal = number_format(($installment->valor_parcela + $installment->multa),2,'.',''); @endphp
                                <b>Total(parcela+multa): </b> R${{$valorTotal or ''}}{{' | '}}
                                <b>Vencimento: </b> {{date_format(date_create($installment->data_vencimento), 'd/m/Y')}}{{' | '}}
                                <a class="btn-link ml-2" target="_blank" href="{{ route('sales.pay',['id'=> $sale->id]) }}">
                                    <button class="btn btn-info mb-1 card-shadow-1dp" title="Ver">Veja...</button>
                                </a>
                                <hr>
                            @empty
                                Está venda não possui pagamentos pendentes!
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFour">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Ordem de serviço associada
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">
                            @php
                                $order = $sale->budget()->first()->order()->first();
                            @endphp
                            @if(!empty($order))
                                <b>Nome: </b> {{$order->nome or 'Não cadastrado!'}}{{' | '}}
                                <b>Data inicial: </b> {{date_format(date_create($order->data_inicial), 'd/m/Y')}}{{' | '}}
                                <b>Data final: </b> {{date_format(date_create($order->data_final), 'd/m/Y')}}{{' | '}}
                                <b>Situação: </b> {{$order->situacao or ''}}{{' | '}}
                                <a class="btn-link ml-2" target="_blank" href="{{ route('orders.show',['id'=> $order->id]) }}">
                                    <button class="btn btn-info mb-1 card-shadow-1dp" title="Ver">Veja...</button>
                                </a>
                                <hr>
                            @else
                                O orçamento desta venda não está associado a uma ordem de serviço!
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
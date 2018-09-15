@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card text-dark">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn btn-primary btn-custom" target="_blank"
                   href="{{route('pdf.show',['tipo'=>'sale_pdf','id'=>$sale->id])}}">Gerar PDF</a>
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
                            <b>Orçamento: </b> {{$sale->budget()->first()->nome or 'não cadastrado!'}}
                            <hr>
                            <b>Total: </b> {{$sale->budget()->first()->total or 'não cadastrado!'}}
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
                                <b>Valor pago: </b> R${{$payment->valor_pago or 'não cadastrado!'}}{{' | '}}
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
                                <b>Vencimento: </b> {{date_format(date_create($installment->data_vencimento), 'd/m/Y')}}
                                <hr>
                            @empty
                                Está venda não possui pagamentos pendentes!
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
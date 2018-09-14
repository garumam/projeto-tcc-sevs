@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card text-dark">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn btn-primary btn-custom" target="_blank"
                   href="{{route('pdf.show',['tipo'=>'client_pdf','id'=>$client->id])}}">Gerar PDF</a>
            </div>

            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Dados pessoais
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <b>Nome: </b> {{$client->nome}}
                            <hr>
                            <b>{{$client->cpf !== null?'Cpf:':'Cnpj:' }} </b><label id="{{$client->cpf !== null?'cpf':'cnpj'}}"> {{$client->cpf or $client->cnpj}}</label>
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
                            <b>Telefone: </b><label id="{{$client->telefone !== null?'telefone':''}}"> {{$client->telefone or 'não cadastrado!'}}</label>
                            <hr>
                            <b>Celular: </b><label id="{{$client->celular !== null?'celular':''}}"> {{$client->celular or 'não cadastrado!'}}</label>
                            <hr>
                            <b>Email: </b> {{$client->email or 'não cadastrado!'}}
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
                            <b>Endereço: </b> {{$client->endereco or 'não cadastrado!'}}
                            <hr>
                            <b>Bairro: </b> {{$client->bairro or 'não cadastrado!'}}
                            <hr>
                            <b>Cidade: </b> {{$client->cidade or 'não cadastrado!'}}
                            <hr>
                            <b>Uf: </b> {{$client->uf or 'não cadastrado!'}}
                            <hr>
                            <b>Cep: </b><label id="{{$client->cep !== null?'cep':''}}"> {{$client->cep or 'não cadastrado!'}}</label>
                            <hr>
                            <b>Complemento: </b> {{$client->complemento or 'não cadastrado!'}}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFour">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Orçamentos
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">
                            @forelse($client->budgets()->get() as $budget)
                                <b>Nome: </b> {{$budget->nome or 'não cadastrado!'}}{{'  '}}
                                <b>Status: </b> {{$budget->status or 'não cadastrado!'}}{{'  '}}
                                <b>Total: </b> R${{$budget->total or ''}}
                                <hr>
                            @empty
                                Este cliente não tem orçamentos!
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFive">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Parcelas pendentes
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                        <div class="card-body">
                            @php $possuiParcelasPendentes = false;@endphp
                            @foreach($client->budgets()->whereIn('status',['FINALIZADO','APROVADO'])->get() as $budget)
                                @php
                                    $installments = [];
                                    $sale = $budget->sale()->first();
                                    if($sale){
                                        $installments = $sale->installments()->where('status_parcela','ABERTO')->get();
                                    }

                                @endphp
                                @foreach($installments as $installment)
                                    <b>Orçamento: </b> {{$budget->nome or 'não cadastrado!'}}{{'  '}}
                                    <b>Valor da parcela: </b> R${{$installment->valor_parcela or ''}}{{'  '}}
                                    <b>Vencimento: </b> {{date_format(date_create($installment->data_vencimento), 'd/m/Y')}}
                                    <hr>
                                    @php $possuiParcelasPendentes = true; @endphp
                                @endforeach

                            @endforeach
                            @if(!$possuiParcelasPendentes)
                                Este cliente não possui parcelas pendentes!
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingSix">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Pagamentos realizados
                            </button>
                        </h5>
                    </div>
                    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                        <div class="card-body">
                            @php $possuiPagamento = false; @endphp
                            @foreach($client->budgets()->whereIn('status',['FINALIZADO','APROVADO'])->get() as $budget)
                                @php
                                    $payments = [];
                                    $sale = $budget->sale()->first();
                                    if($sale){
                                        $payments = $sale->payments()->get();
                                    }
                                @endphp
                                @foreach($payments as $payment)
                                    <b>Orçamento: </b> {{$budget->nome or 'não cadastrado!'}}{{'  '}}
                                    <b>Valor pago: </b> R${{$payment->valor_pago or 'não cadastrado!'}}{{'  '}}
                                    <b>Data de pagamento: </b> {{date_format(date_create($payment->data_pagamento), 'd/m/Y')}}
                                    <hr>
                                    @php $possuiPagamento = true; @endphp
                                @endforeach

                            @endforeach
                            @if(!$possuiPagamento)
                                Este cliente não possui pagamentos!
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
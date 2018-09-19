<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cliente - Vidraceiro</title>

    <!--Custon CSS (está em /public/assets/site/css/certificate.css)-->
    {{--<link rel="stylesheet" href="{{ url('assets/site/css/certificate.css') }}">--}}
    <style>
        p, h3 {
            font-weight: 700;
            font-family: 'Raleway', sans-serif;
        }

        .line {
            border-bottom: 2px solid #e5e5e5;
            height: 2px;
        }

        h3 {
            background-color: #DFEBFF;
            padding: .4rem;
        }

        .flex {
            width: 100%;
        }

        .image-produto {
            position: relative;
            display: block;
            margin-top: 20px;
            width: 15%;
            height: 140px;
        }

        .tabela-produto {
            margin-top: 10px;
            width: 80%;
            height: 140px;
            float: right;
            border: 1px solid #1b1e21;
            font-family: 'Raleway', sans-serif;
            font-size: .9rem;
            border-spacing: 0;
            padding: 0;
        }
        .tabela-produto tr,td{
            border-spacing: 0;
            padding: .6rem;
        }
        .indice {
            width: 40px;
            padding-top: 60px;
            text-align: center;
            vertical-align: center;
            border-right: 1px solid #1b1e21;

        }
        .texto {
            margin: 0 auto;
            text-align: left;
            vertical-align: center;
        }
        .total{
            width: 100%;
            height: 35px;
        }
        .total p {
            margin: 0;
            padding: 0;
        }
        #texto-left{
            float: left;
        }
        #texto-right{
            float: right;
        }
    </style>
</head>
<body>

<p>{{$company->nome}}</p>
<p>{{$company->endereco .' - '. $company->bairro}}</p>
<p>{{$company->cidade .' - '. $company->uf}}</p>
<p>E-mail: {{$company->email}}</p>

@php
    $telefone = $company->telefone;
    if($telefone !== null){
    // primeiro substr pega apenas o DDD e coloca dentro do (), segundo subtr pega os números do 3º até faltar 4, insere o hifem, e o ultimo pega apenas o 4 ultimos digitos
    $telefone="(".substr($telefone,0,2).") ".substr($telefone,2,-4)." - ".substr($telefone,-4);
    }

@endphp

<p>Telefone: {{$telefone}}</p>
<div class="line"></div>

<h3>Dados do cliente</h3>
<p>Nome: {{$client->nome}}</p>
<p>Endereço: {{$client->endereco .' - '. $client->bairro}}</p>
<p>Uf: {{$client->uf}}</p>
<p>Cep: {{$client->cep}}</p>
<p>Complemento: {{$client->complemento}}</p>
@php
    $telefone = $client->telefone;
    $celular = $client->celular;
    if($telefone !== null){
    // primeiro substr pega apenas o DDD e coloca dentro do (), segundo subtr pega os números do 3º até faltar 4, insere o hifem, e o ultimo pega apenas o 4 ultimos digitos
    $telefone="(".substr($telefone,0,2).") ".substr($telefone,2,-4)." - ".substr($telefone,-4);
    }

    if($celular !== null){
    $celular="(".substr($celular,0,2).") ".substr($celular,2,-4)." - ".substr($celular,-4);
    }

@endphp
<p>Telefone: {{$telefone or 'não cadastrado!'}}</p>
<p>Celular: {{$celular or 'não cadastrado!'}}</p>
<p>Email: {{$client->email or 'não cadastrado!'}}</p>

<h3>Orçamentos</h3>

@forelse($client->budgets()->get() as $budget)
    <b>Nome: </b> {{$budget->nome or 'não cadastrado!'}}{{' | '}}
    <b>Status: </b> {{$budget->status or 'não cadastrado!'}}{{' | '}}
    <b>Total: </b> R${{$budget->total or ''}}
    <hr>
@empty
    Este cliente não tem orçamentos!
@endforelse

<h3>Pagamentos realizados</h3>

@php $possuiPagamento = false; $totalPago = 0; @endphp
@foreach($client->budgets()->whereIn('status',['FINALIZADO','APROVADO'])->get() as $budget)
    @php
        $payments = [];
        $sale = $budget->sale()->first();
        if($sale){
            $payments = $sale->payments()->get();
        }
    @endphp
    @foreach($payments as $payment)
        <b>Orçamento: </b> {{$budget->nome or 'não cadastrado!'}}{{' | '}}
        <b>Valor pago: </b> R${{$payment->valor_pago or 'não cadastrado!'}}{{' | '}}
        <b>Data de pagamento: </b> {{date_format(date_create($payment->data_pagamento), 'd/m/Y')}}
        <hr>
        @php $possuiPagamento = true; $totalPago += $payment->valor_pago; @endphp
    @endforeach

@endforeach
@if(!$possuiPagamento)
    <div>Este cliente não possui pagamentos!</div><br>
@endif

<div class="total">
    <p id="texto-left">Valor total pago: </p>
    <p id="texto-right">R$ {{$totalPago}}</p>
</div>

<h3>Pagamentos pendentes</h3>

@php $possuiParcelasPendentes = false; $totalPendente = 0;@endphp
@foreach($client->budgets()->whereIn('status',['FINALIZADO','APROVADO'])->get() as $budget)
    @php
        $installments = [];
        $sale = $budget->sale()->first();
        if($sale){
            $installments = $sale->installments()->where('status_parcela','ABERTO')->get();
        }

    @endphp
    @foreach($installments as $installment)
        <b>Orçamento: </b> {{$budget->nome or 'não cadastrado!'}}{{' | '}}
        <b>Valor da parcela: </b> R${{$installment->valor_parcela or ''}}{{' | '}}
        <b>Vencimento: </b> {{date_format(date_create($installment->data_vencimento), 'd/m/Y')}}
        <hr>
        @php $possuiParcelasPendentes = true; $totalPendente += $installment->valor_parcela;@endphp
    @endforeach

@endforeach
@if(!$possuiParcelasPendentes)
    <div>Este cliente não possui parcelas pendentes!</div><br>
@endif

<div class="total">
    <p id="texto-left">Valor total pendente: </p>
    <p id="texto-right">R$ {{$totalPendente}}</p>
</div>
</body>
</html>
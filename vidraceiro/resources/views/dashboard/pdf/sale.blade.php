<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cliente - Vidraceiro</title>

    <style>
        p,
        b,
        h3 {
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

        .tabela-produto tr,
        td {
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

        .total {
            width: 100%;
            height: 35px;
        }

        .total p {
            margin: 0;
            padding: 0;
        }

        #texto-left {
            float: left;
        }

        #texto-right {
            float: right;
        }
    </style>
</head>

<body>

    @if(!empty($company))
    @php
    $location = $company->location()->first();
    $contact = $company->contact()->first();
    $telefone = $contact->telefone;
    if($telefone !== null){
    // primeiro substr pega apenas o DDD e coloca dentro do (), segundo subtr pega os números do 3º até faltar 4, insere o hifem, e o ultimo pega apenas o 4 ultimos digitos
    $telefone="(".substr($telefone,0,2).") ".substr($telefone,2,-4)." - ".substr($telefone,-4);
    }
    @endphp
    <p>{{$company->nome}}</p>
    <p>{{$location->endereco .' - '. $location->bairro}}</p>
    <p>{{$location->cidade .' - '. $location->uf}}</p>
    <p>E-mail: {{$contact->email}}</p>
    <p>Telefone: {{$telefone}}</p>
    <div class="line"></div>
    @endif

    @php
    $tipoPagamento = $sale->tipo_pagamento;
    $budget = $sale->budget()->first();

    $totalSemDesconto = $sale->valor_venda + $sale->desconto + $sale->entrada;

    @endphp

    <h3>Dados da venda</h3>
    
    <p>Orçamento: {{$budget->nome}}</p>
    <p>Total(sem desconto): R${{$totalSemDesconto or ''}}</p>
    <p>Desconto: R${{$sale->desconto or ''}}</p>
    @if($tipoPagamento === 'A PRAZO')
    <p>Entrada: R${{$sale->entrada or ''}}</p>                   
    @endif
    <p>Total(com desconto): R${{$sale->valor_venda + $sale->entrada}}</p>
    <p>Tipo de pagamento: {{$tipoPagamento}}</p>
    <p>Data da venda: {{date_format(date_create($sale->data_venda), 'd/m/Y')}}</p>

    <h3>Pagamentos recebidos</h3>

    @php $possuiPagamento = false; $totalPago = 0; $payments = $sale->payments()->get(); @endphp

    @foreach($payments as $payment)
    <b>Valor pago: R${{$payment->valor_pago or 'não cadastrado!'}}{{' | '}}</b>
    <b>Data de pagamento: {{date_format(date_create($payment->data_pagamento), 'd/m/Y')}}</b>
    <hr>
    @php $possuiPagamento = true; $totalPago += $payment->valor_pago; @endphp
    @endforeach

    @if(!$possuiPagamento)
    <b>Esta venda não recebeu pagamentos!</b><br><br>
    @endif

    <div class="total">
        <p id="texto-left">Valor total pago: </p>
        <p id="texto-right">R$ {{number_format($totalPago,2,',','.')}}</p>
    </div>

    <h3>Pagamentos pendentes</h3>

    @php $possuiParcelasPendentes = false; $totalPendente = 0; $installments =
    $sale->installments()->where('status_parcela','ABERTO')->get();@endphp

    @foreach($installments as $installment)
    <b>Valor da parcela: R${{$installment->valor_parcela or ''}}{{' | '}}</b>
    <b>Valor da multa: R${{$installment->multa or ''}}{{' | '}}</b>
    @php $valorTotal = number_format(($installment->valor_parcela + $installment->multa),2,'.',''); @endphp
    <b>Total(parcela+multa): R${{$valorTotal or ''}}{{' | '}}</b>
    <b>Vencimento: {{date_format(date_create($installment->data_vencimento), 'd/m/Y')}} </b>
    <hr>
    @php $possuiParcelasPendentes = true; $totalPendente += $valorTotal;@endphp
    @endforeach

    @if(!$possuiParcelasPendentes)
    <b>Esta venda não possui parcelas pendentes!</b><br><br>
    @endif

    <div class="total">
        <p id="texto-left">Valor total pendente: </p>
        <p id="texto-right">R$ {{number_format($totalPendente,2,',','.')}}</p>
    </div>

    @php $order = $budget->order()->first(); @endphp

    @if(!empty($order))
    <h3>Ordem de serviço associada</h3>
    <b>Nome: {{$order->nome or 'Não cadastrado!'}}{{' | '}}</b>
    <b>Data inicial: {{date_format(date_create($order->data_inicial), 'd/m/Y')}}{{' | '}}</b>
    <b>Data final: {{date_format(date_create($order->data_final), 'd/m/Y')}}{{' | '}}</b>
    <b>Situação: {{$order->situacao or ''}}</b>

    @endif
</body>

</html>
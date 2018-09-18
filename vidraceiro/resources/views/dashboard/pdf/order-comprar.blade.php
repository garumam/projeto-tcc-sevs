<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ordem de serviço</title>

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

        h2 {
            background-color: #c4daff;
            padding: .4rem;
        }

        h3 {
            background-color: #DFEBFF;
            padding: .4rem;
        }

        h4 {
            background-color: #edf1fc;
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
<h1>Ordem de serviço - {{$order->nome or 'não cadastrado!'}}</h1>


@php $budgets = $order->budgets()->get();@endphp

@foreach($budgets as $budget)
    @php
        $sale = $budget->sale()->first();
        $reservasNoEstoque = $sale->storages()->get();
        //$reservasNoEstoque->shift()->pivot->qtd_reservada
    @endphp
    <h2>Orçamento - {{$budget->nome or 'não cadastrado!'}}</h2>
    <h3>Materiais necessários para realizar o serviço</h3>

    @forelse($budget->products()->get() as $product)
        <h4 style="background-color: #e0eafc;">Produto - {{$product->mproduct()->first()->nome}} | unidades: {{$product->qtd}}</h4>
        <h4>Vidros (Valores unitários)</h4>
        @foreach($product->glasses as $glass)
            <p>{{'* '.$glass->nome.' '.$glass->tipo.' | m²: '.($product->largura * $product->altura)}}</p>
        @endforeach
        <h4>Alumínios (Valores unitários)</h4>
        @foreach($product->aluminums as $aluminum)
            <p>{{'* '.$aluminum->perfil.' | qtd: '}}
                @if($aluminum->tipo_medida === 'largura')
                    {{ceil(($aluminum->medida * $aluminum->qtd)/6)}}
                @elseif($aluminum->tipo_medida === 'altura')
                    {{ceil(($aluminum->medida * $aluminum->qtd)/6)}}
                @elseif($aluminum->tipo_medida === 'mlinear')
                    {{(ceil($aluminum->medida/6))}}
                @endif</p>
        @endforeach
        <h4>Componentes (Valores unitários)</h4>
        @foreach($product->components as $component)
            <p>{{'* '.$component->nome.' | qtd: '.$component->qtd}}</p>
        @endforeach
        <div class="line"></div>
    @empty
        <div>Nenhum produto cadastrado neste orçamento!</div>
    @endforelse

    <h3>Reservado no estoque</h3>
    @forelse($reservasNoEstoque as $reserva)
        @if($reserva->glass_id !== null)
            @php $glass = $reserva->glass()->first(); @endphp
            <p>{{$glass->nome.' '.$glass->tipo.' | reservados: '.$reserva->pivot->qtd_reservada.'m²'}}</p>
        @elseif($reserva->aluminum_id !== null)
            @php $aluminum = $reserva->aluminum()->first(); @endphp
            <p>{{$aluminum->perfil.' '.$aluminum->descricao.' '.$aluminum->espessura.'mm'.' | Quantidade reservada: '.$reserva->pivot->qtd_reservada}}</p>
        @elseif($reserva->component_id !== null)
            @php $component = $reserva->component()->first(); @endphp
            <p>{{$component->nome.' | Quantidade reservada: '.$reserva->pivot->qtd_reservada}}</p>
        @endif
    @empty
        <div>Nada reservado no estoque para este orçamento!</div>
    @endforelse
    <div class="line" style="margin: 20px 0 0 0;"></div>
@endforeach


</body>
</html>
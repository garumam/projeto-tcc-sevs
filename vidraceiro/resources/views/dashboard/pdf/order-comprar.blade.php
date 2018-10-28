<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ordem de serviço</title>

    <!--Custon CSS (está em /public/assets/site/css/certificate.css)-->
    {{--<link rel="stylesheet" href="{{ url('assets/site/css/certificate.css') }}">--}}
    <style>
        p,b, h3 {
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

<h3>Ordem de serviço - {{$order->nome or 'não cadastrado!'}}</h3>


@php $budgets = $order->budgets()->get();@endphp

@foreach($budgets as $budget)
    @php
        $sale = $budget->sale()->first();
        $reservasNoEstoque = $sale->storages()->get();
        //$reservasNoEstoque->shift()->pivot->qtd_reservada
    @endphp
    <h3>Orçamento - {{$budget->nome or 'não cadastrado!'}}<hr>Materiais necessários por produto</h3>


    @forelse($budget->products()->get() as $product)
        <h4 style="background-color: #e0eafc; text-align: center;">Produto - {{$product->mproduct()->first()->nome}} | unidades: {{$product->qtd}}</h4>
        <h4>Vidros</h4>
        @forelse($product->glasses as $glass)
            <p style="margin-left: 20px;">{{'* '.$glass->nome.' '.$glass->tipo.' | m²(unidade): '.number_format(($product->largura * $product->altura), 3, '.', '')
                                                               .' | m²(total): '.number_format((($product->largura * $product->altura)*$product->qtd), 3, '.', '')}}</p>
        @empty
            <div style="margin-left: 20px;">Nenhum vidro neste produto!</div>
        @endforelse
        <h4>Alumínios</h4>
        @forelse($product->aluminums as $aluminum)
            <p style="margin-left: 20px;">{{'* '.$aluminum->perfil.' | qtd: '.$aluminum->qtd.' | medida(unidade): '.$aluminum->medida.' | medida(total): '.($aluminum->medida * $aluminum->qtd * $product->qtd).' | Qtd de peças de alumínio(6m) que serão utilizadas: '}}
                @if($aluminum->tipo_medida === 'largura')
                    {{ceil(($aluminum->medida * $aluminum->qtd)/6)}}
                @elseif($aluminum->tipo_medida === 'altura')
                    {{ceil(($aluminum->medida * $aluminum->qtd)/6)}}
                @elseif($aluminum->tipo_medida === 'mlinear')
                    {{(ceil($aluminum->medida/6))}}
                @endif</p>
        @empty
            <div style="margin-left: 20px;">Nenhum alumínio neste produto!</div>
        @endforelse
        <h4>Componentes</h4>
        @forelse($product->components as $component)
            <p style="margin-left: 20px;">{{'* '.$component->nome.' | qtd: '.$component->qtd.' | qtd total(vezes qtd de produtos): '.$component->qtd * $product->qtd}}</p>
        @empty
            <div style="margin-left: 20px;">Nenhum componente neste produto!</div>
        @endforelse
        <div class="line" style="margin-top: 20px;"></div>
    @empty
        <div>Nenhum produto cadastrado neste orçamento!</div>
    @endforelse

    <h3>Reservado no estoque</h3>
    @forelse($reservasNoEstoque as $reserva)
        @if($reserva->glass_id !== null)
            @php $glass = $reserva->glass()->first(); @endphp
            <p style="margin-left: 20px;">{{$glass->nome.' '.$glass->tipo.' | reservados: '.$reserva->pivot->qtd_reservada.'m²'}}</p>
        @elseif($reserva->aluminum_id !== null)
            @php $aluminum = $reserva->aluminum()->first(); @endphp
            <p style="margin-left: 20px;">{{$aluminum->perfil.' '.$aluminum->descricao.' '.$aluminum->espessura.'mm'.' | Qtd de peças de alumínio(6m) reservadas: '.$reserva->pivot->qtd_reservada}}</p>
        @elseif($reserva->component_id !== null)
            @php $component = $reserva->component()->first(); @endphp
            <p style="margin-left: 20px;">{{$component->nome.' | Quantidade reservada: '.$reserva->pivot->qtd_reservada}}</p>
        @endif
    @empty
        <div style="margin-left: 20px;">Nada reservado no estoque para este orçamento!</div>
    @endforelse
    <div class="line" style="margin: 20px 0 0 0;"></div>
@endforeach


</body>
</html>
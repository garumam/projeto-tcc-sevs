<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ordem de serviço</title>

    <style>
        p, h3,h2 {
            font-weight: 700;
            font-family: 'Raleway', sans-serif;
        }

        .line {
            border-bottom: 2px solid #e5e5e5;
            height: 2px;
        }

        h3,h2 {
            background-color: #DFEBFF;
            padding: .4rem;
        }

        .tabela-produto {
            width: 100px;
            height: auto;
            border-right: 0.4px solid #1b1e21;
        }

        .tabela-produto img {
            width: 100%;
            height: 100%;
        }

        table {
            width: 100%;
            font-family: 'Raleway', sans-serif;
            font-size: .9rem;
            border-spacing: 0;
            padding: 0;
            margin: 0 0 20px;
        }

        tr,td{
            border-spacing: 0;
            padding: .6rem;
            border: 1px solid #1b1e21;
        }

        .semborda {
            border-spacing: 0;
            padding: .6rem;
            border: none;
        }

        .indice {
            width: 10%;
            height: auto;
            text-align: center;
            border-right: 1px solid #1b1e21;
        }

        .texto {
            margin: 0 auto;
            text-align: left;
            vertical-align: center;
        }

        .total {
            display: block;
            position: relative;
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
<h2>Ordem de serviço</h2>

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

<h3>Detalhes da ordem de serviço</h3>

<p><b>Nome: </b> {{$order->nome or 'não cadastrado!'}}</p>
<p><b>Data inicial: </b>{{$order->data_inicial !== null?date_format(date_create($order->data_inicial), 'd/m/Y'):'Não cadastrada!'}}</p>
<p><b>Data final: </b> {{$order->data_final !== null?date_format(date_create($order->data_final), 'd/m/Y'):'Não cadastrada!'}}</p>
<p><b>Situação: </b> {{$order->situacao or 'não cadastrado!'}}</p>
<p><b>Valor total: </b> R${{$order->total or ''}}</p>
<div class="line"></div>
@php $budgets = $order->budgets()->get(); @endphp
<h2>Orçamentos relacionados</h2>

@foreach($budgets as $budget)

    <h3>Dados do orçamento - {{$budget->nome}}</h3>
    <p>Nome: {{$budget->nome}}</p>
    <p>Endereço: {{$budget->endereco .' - '. $budget->bairro}}</p>
    <p>Cep: {{$budget->cep}}</p>
    <p>Complemento: {{$budget->complemento}}</p>
    <h3>Produtos</h3>
    <div class="total">
        <p id="texto-left">Valor total do orçamento: </p>
        <p id="texto-right">R$ {{$budget->total}}</p>
    </div>

<div>
<table>
    @forelse($budget->products()->get() as $product)
        
                <tr>
                    <td class="tabela-produto">
                        <img src="{{ public_path().$product->mproduct->imagem}}">
                    </td>
                    
                    <td class="indice">{{$loop->index + 1}}</td>

                    <td class="texto"><b>Nome: {{$product->mproduct->nome .' - '}}</b> {{$product->mproduct->descricao}}
                        <br>
                        <b>Linha:</b> {{$product->mproduct->category->nome}}
                        <br>
                        @foreach($product->glasses as $glass)
                            <b>Vidro:</b> {{$glass->nome}}
                        @endforeach
                        <br>
                        @foreach($product->aluminums as $aluminum)
                            <b>Aluminios:</b> {{$aluminum->perfil . ' '. $aluminum->descricao}}
                        @endforeach
                        <br>
                        <b>Largura:</b> {{$product->largura . ' '}}
                        <b>Altura:</b> {{$product->altura}}
                        <b>Quantidade:</b> {{$product->qtd}}
                        <br>
                        <b>Localização:</b> {{$product->localizacao}}
                    </td>
                </tr>

                <tr><td class="semborda"></td></tr>
            
        
    @empty
        <p>Nenhum Produto Cadastrado.</p>
    @endforelse
</table>

    <div class="line"></div>
</div>
@endforeach



</body>
</html>
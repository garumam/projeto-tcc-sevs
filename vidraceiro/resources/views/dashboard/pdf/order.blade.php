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
<h1>Ordem de serviço</h1>

<p>{{$company->nome}}</p>
<p>{{$company->endereco .' - '. $company->bairro}}</p>
<p>{{$company->cidade .' - '. $company->uf}}</p>
<p>E-mail: {{$company->email}}</p>
<p>Telefone: {{$company->telefone}}</p>
<div class="line"></div>

<h3>Detalhes da ordem de serviço</h3>

<p><b>Nome: </b> {{$order->nome or 'não cadastrado!'}}</p>
<p><b>Data inicial: </b>{{$order->data_inicial !== null?date_format(date_create($order->data_inicial), 'd/m/Y'):'Não cadastrada!'}}</p>
<p><b>Data final: </b> {{$order->data_final !== null?date_format(date_create($order->data_final), 'd/m/Y'):'Não cadastrada!'}}</p>
<p><b>Situação: </b> {{$order->situacao or 'não cadastrado!'}}</p>
<p><b>Valor total: </b> R${{$order->total or ''}}</p>
<div class="line"></div>
@php $budgets = $order->budgets()->get(); @endphp
<h1>Orçamentos relacionados</h1>
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

    @forelse($budget->products()->get() as $product)
        <div class="flex">
            <img class="image-produto" src="{{ public_path().$product->mproduct->imagem}}">
            <table class="tabela-produto">
                <tr>
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


            </table>
        </div>
    @empty
        <p>Nenhum Produto Cadastrado.</p>
    @endforelse
    <div class="line"></div>
@endforeach


</body>
</html>
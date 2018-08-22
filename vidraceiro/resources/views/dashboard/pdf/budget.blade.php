<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Orçamento - Vidraceiro</title>

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
            height: 120px;
        }

        .tabela-produto {
            margin-top: 13px;
            width: 80%;
            height: 120px;
            float: right;
            border: 1px solid #1b1e21;
            font-family: 'Raleway', sans-serif;
            font-size: .9rem;
            border-spacing: 0;
        }

        .indice {
            width: 40px;
            text-align: center;
            border-right: 1px solid #1b1e21;
            padding-top: 50px;
        }

    </style>
</head>
<body>

<p>{{$company->nome}}</p>
<p>{{$company->endereco .' - '. $company->bairro}}</p>
<p>{{$company->cidade .' - '. $company->uf}}</p>
<p>E-mail: {{$company->email}}</p>
<p>Telefone: {{$company->telefone}}</p>
<div class="line"></div>

<h3>Dados do orçamento</h3>
<p>Nome: {{$budget->nome}}</p>
<p>Endereço: {{$budget->endereco .' - '. $budget->bairro}}</p>
<p>Cep: {{$budget->cep}}</p>
<p>Complemento: {{$budget->complemento}}</p>
<h3>Produtos</h3>
<p>Valor total do orçamento: {{$budget->total}}</p>


    @forelse($budget->products as $product)
        <div class="flex">
            <img class="image-produto" src="{{ public_path().$product->mproduct->imagem}}">
            <table class="tabela-produto">

                <td class="indice">{{$loop->index + 1}}</td>

                <td>{{$product->mproduct->nome . ' '. $product->mproduct->descricao}}
                    <br>
                    Linha: {{$product->mproduct->category->nome}}
                    <br>
                    @foreach($product->glasses as $glass)
                        Vidro: {{$glass->nome}}
                    @endforeach
                    <br>
                    @foreach($product->aluminums as $aluminum)
                        Aluminios: {{$aluminum->perfil . ' '. $aluminum->descricao}}
                    @endforeach
                    <br>
                    Largura: {{$product->largura . ' '}}
                    Altura: {{$product->altura}}
                    Quantidade: {{$product->qtd}}
                    <br>
                    Localização: {{$product->localizacao}}
                </td>

            </table>
        </div>
    @empty
        <p>Nenhum Produto Cadastrado.</p>
    @endforelse



</body>
</html>
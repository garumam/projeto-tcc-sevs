<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Orçamento - Vidraceiro</title>

    <!--Custon CSS (está em /public/assets/site/css/certificate.css)-->
    {{--<link rel="stylesheet" href="{{ url('assets/site/css/certificate.css') }}">--}}
    <style>
        p,h3 {
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
<ul>
    @forelse($budget->products as $product)
        <li style="color: #0acf97;">{{ $product->mproduct->nome }}</li>
    @empty
        <li>Nenhum Produto Cadastrado.</li>
    @endforelse
</ul>


</body>
</html>
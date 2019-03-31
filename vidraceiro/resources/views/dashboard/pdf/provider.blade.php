<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Fornecedor - Vidraceiro</title>

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


<h3>Dados do fornecedor</h3>
<p>Nome: {{$provider->nome or 'não cadastrado!'}}</p>
<p>Situação: {{$provider->situacao or 'não cadastrado!'}}</p>
<p>Cnpj: {{App\Http\Controllers\PdfController::mask($provider->cnpj,'##.###.###/####-##')}}</p>

<h3>Formas de contato</h3>

@php
    $contact = $provider->contact()->first();
    $telefone = $contact->telefone;
    $celular = $contact->celular;
    if($telefone !== null){
    // primeiro substr pega apenas o DDD e coloca dentro do (), segundo subtr pega os números do 3º até faltar 4, insere o hifem, e o ultimo pega apenas o 4 ultimos digitos
    $telefone="(".substr($telefone,0,2).") ".substr($telefone,2,-4)." - ".substr($telefone,-4);
    }

    if($celular !== null){
    $celular="(".substr($celular,0,2).") ".substr($celular,2,-4)." - ".substr($celular,-4);
    }

    $location = $provider->location()->first();
@endphp

<p>Telefone: {{$telefone or 'não cadastrado!'}}</p>
<p>Celular: {{$celular or 'não cadastrado!'}}</p>
<p>Email: {{$contact->email or 'não cadastrado!'}}</p>


<h3>Endereço</h3>

<p>Endereço: {{$location->endereco or 'não cadastrado!'}}</p>
<p>Bairro: {{$location->bairro or 'não cadastrado!'}}</p>
<p>Cidade: {{$location->cidade or 'não cadastrado!'}}</p>
<p>Uf: {{$location->uf or 'não cadastrado!'}}</p>
<p>Cep: {{App\Http\Controllers\PdfController::mask($provider->cnpj,'#####-###')}}</p>

<h3>Materiais fornecidos</h3>
<p>VIDROS:</p>
@forelse($provider->glasses()->get() as $glass)
<p>->{{' '.$glass->nome .' '.$glass->tipo}}</p>
@empty
<p>Nenhum vidro!</p>
@endforelse
<div class="line"></div>
<p>ALUMÍNIOS:</p>
@forelse($provider->aluminums()->get() as $aluminum)
<p>->{{' '.$aluminum->perfil}}</p>
@empty
<p>Nenhum alumínio!</p>
@endforelse
<div class="line"></div>
<p>COMPONENTES:</p>
@forelse($provider->components()->get() as $component)
<p>->{{' '.$component->nome}}</p>
@empty
<p>Nenhum componente!</p>
@endforelse



</body>
</html>
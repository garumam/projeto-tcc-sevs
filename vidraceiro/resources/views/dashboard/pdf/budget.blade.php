<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Título Opcional</title>

    <!--Custon CSS (está em /public/assets/site/css/certificate.css)-->
    {{--<link rel="stylesheet" href="{{ url('assets/site/css/certificate.css') }}">--}}
</head>
<body>


<h1>Orçamentos</h1>


<ul>
    @php

    @endphp
    @forelse($budget->products as $product)
        <li style="color: #0acf97;">{{ $product->mproduct->nome }}</li>
    @empty
        <li>Nenhum Produto Cadastrado.</li>
    @endforelse
</ul>


</body>
</html>
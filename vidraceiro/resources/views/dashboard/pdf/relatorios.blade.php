<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Relatório - Vidraceiro</title>

    <style>
        p, h3, h4 {
            font-weight: 700;
            font-family: 'Raleway', sans-serif;
        }

        .line {
            border-bottom: 2px solid #e5e5e5;
            height: 2px;
        }

        h3, h4 {
            background-color: #DFEBFF;
            padding: .4rem;
        }

        .flex {
            width: 100%;
        }

        .tabela-relatorio {
            margin-top: 10px;
            width: 100%;
            border: 1px solid #1b1e21;
            font-family: 'Raleway', sans-serif;
            font-size: .9rem;
            border-spacing: 0;
            padding: 0;
        }
        .tabela-relatorio tr,td{
            border-spacing: 0;
            padding: .6rem;
        }
        .indice {
            width: 40px;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
            border-right: 1px solid #1b1e21;

        }
        .texto {
            max-width: 80%;
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
@switch($tipo)
    @case('budgets')
    <h3>Relatório de orçamentos</h3>
    <h4>Quantidade encontrada: {{count($budgets->toArray())}}</h4>

    @forelse($budgets as $budget)
        <div class="flex">
            <table class="tabela-relatorio">
                <tr>
                    <td class="indice">{{$budget->id}}</td>
                    <td class="texto">
                        <b>Nome:</b> {{$budget->nome .' |'}}
                        <b>Status:</b> {{$budget->status .' |'}}
                        <b>Data:</b> {{date_format(date_create($budget->data), 'd/m/Y')}}
                        <b>Total:</b> {{$budget->total}}
                    </td>
                </tr>

            </table>
        </div>
    @empty
        <p>Nenhum Orçamento encontrado com as características passadas.</p>
    @endforelse

    @break

    @case('orders')

    <h3>Relatório de ordens de serviço</h3>
    <h4>Quantidade encontrada: {{count($orders->toArray())}}</h4>

    @forelse($orders as $order)
        <div class="flex">
            <table class="tabela-relatorio">
                <tr>
                    <td class="indice">{{$order->id}}</td>
                    <td class="texto">
                        <b>Nome:</b> {{$order->nome .' |'}}
                        <b>Situação:</b> {{$order->situacao .' |'}}
                        <b>Data inicial:</b> {{date_format(date_create($order->data_inicial), 'd/m/Y')}}
                        <b>Data final:</b> {{date_format(date_create($order->data_final), 'd/m/Y')}}
                        <b>Total:</b> {{$order->total}}
                    </td>
                </tr>

            </table>
        </div>
    @empty
        <p>Nenhuma Ordem de serviço encontrada com as características passadas.</p>
    @endforelse

    @break

    @case('storage')

    @php
        $quantidade = 0;
        if($glasses !== null){
            $quantidade += count($glasses->toArray());
        }

        if($aluminums !== null){
            $quantidade += count($aluminums->toArray());
        }

        if($components !== null){
            $quantidade += count($components->toArray());
        }
    @endphp

    <h3>Relatório de estoque</h3>
    <h4>Quantidade encontrada: {{$quantidade}}</h4>

    @if($glasses !== null)
    <p>Vidros:</p>

    @forelse($glasses as $glass)
        <div class="flex">
            <table class="tabela-relatorio">
                <tr>
                    <td class="indice">{{$glass->id}}</td>
                    <td class="texto">
                        <b>Nome:</b> {{$glass->glass->nome .' |'}}
                        <b>Tipo:</b> {{$glass->glass->tipo .' |'}}
                        <b>Em estoque:</b> {{$glass->qtd . ' m²'}}
                    </td>
                </tr>

            </table>
        </div>
    @empty
        <p>Nenhum vidro encontrado com as características passadas.</p>
    @endforelse
    @endif
    @if($aluminums !== null)
        <p>Alumínios:</p>

    @forelse($aluminums as $aluminum)
        <div class="flex">
            <table class="tabela-relatorio">
                <tr>
                    <td class="indice">{{$aluminum->id}}</td>
                    <td class="texto">
                        <b>Perfil:</b> {{$aluminum->aluminum->perfil .' |'}}
                        <b>Descrição:</b> {{$aluminum->aluminum->descricao .' |'}}
                        <b>Em estoque:</b> {{$aluminum->qtd}}
                    </td>
                </tr>
            </table>
        </div>
    @empty
        <p>Nenhum alumínio encontrado com as características passadas.</p>
    @endforelse
    @endif
    @if($components !== null)
        <p>Componentes:</p>

    @forelse($components as $component)
        <div class="flex">
            <table class="tabela-relatorio">
                <tr>
                    <td class="indice">{{$component->id}}</td>
                    <td class="texto">
                        <b>Nome:</b> {{$component->component->nome .' |'}}
                        <b>Em estoque:</b> {{$component->qtd}}
                    </td>
                </tr>

            </table>
        </div>
    @empty
        <p>Nenhum componente encontrado com as características passadas.</p>
    @endforelse
    @endif
    @break

    @case('financial')


    <h3>Relatório financeiro</h3>
    <h4>Movimentações encontradas: {{count($financials->toArray()) + count($installments->toArray())}}</h4>
    @php
        $possui_receitas = $possui_despesas = false;
        $totalReceitas = $totalDespesas = 0;
        foreach ($financials->where('tipo','RECEITA') as $receita){
            $possui_receitas = true;
            $totalReceitas += $receita->valor;
        }
        foreach ($installments as $receita){
            $possui_receitas = true;
            $totalReceitas += ($receita->valor_parcela + $receita->multa);
        }
        foreach ($financials->where('tipo','DESPESA') as $despesa){
            $possui_despesas = true;
            $totalDespesas += $despesa->valor;
        }
    @endphp

    @if($possui_receitas && $possui_despesas)
        <h4>Total Receitas: {{'R$'.number_format($totalReceitas,2,',','.')}}</h4>
        <h4>Total Despesas: {{'R$'.number_format($totalDespesas,2,',','.')}}</h4>
        <h4>Saldo: {{'R$'.number_format(($totalReceitas - $totalDespesas),2,',','.')}}</h4>
    @elseif($possui_receitas)
        <h4>Total Receitas: {{'R$'.number_format($totalReceitas,2,',','.')}}</h4>
    @elseif($possui_despesas)
        <h4>Total Despesas: {{'R$'.number_format($totalDespesas,2,',','.')}}</h4>
    @endif


    @php $contador = 0; @endphp
    @foreach($financials as $financial)
        @php $contador += 1; @endphp
        <div class="flex">
            <table class="tabela-relatorio">
                <tr>
                    <td class="indice">{{$contador}}</td>
                    <td class="texto">
                        <b>Tipo:</b> {{$financial->tipo .' |'}}
                        <b>Descrição:</b> {{$financial->descricao??'Sem descrição!' .' |'}}
                        <b>Valor:</b> {{'R$'.$financial->valor.' |'}}
                        <b>Data:</b> {{date_format(date_create($financial->data_vencimento), 'd/m/Y')}}
                    </td>
                </tr>
            </table>
        </div>
    @endforeach
    
    @foreach($installments as $installment)
        @php 
        $contador += 1; 
        
        $sale = $installment->sale()->first();     
        $client = $sale->budget()->first()->client()->first();

        @endphp
        <div class="flex">
            <table class="tabela-relatorio">
                <tr>
                    <td class="indice">{{$contador}}</td>
                    <td class="texto">
                        <b>Tipo:</b> RECEITA
                        <b>Descrição:</b> {{$client->nome.' - Parcela a receber'.' |'}}
                        <b>Valor:</b> {{'R$'.($installment->valor_parcela + $installment->multa).' |'}}
                        <b>Data de vencimento:</b> {{date_format(date_create($installment->data_vencimento), 'd/m/Y')}}      
                    </td>
                </tr>
            </table>
        </div>
    @endforeach
    
    @if(empty($installments) && empty($financials))
    <p>Nenhuma movimentação encontrada com as características passadas.</p>
    @endif

    @break

    @case('clients')

    <h3>Relatório de clientes</h3>
    <h4>Quantidade encontrada: {{count($clients->toArray())}}</h4>

    @forelse($clients as $client)
        @php
            $contact = $client->contact()->first();
            $telefone = $contact->telefone;
            $celular = $contact->celular;
            if($telefone !== null){
            // primeiro substr pega apenas o DDD e coloca dentro do (), segundo subtr pega os números do 3º até faltar 4, insere o hifem, e o ultimo pega apenas o 4 ultimos digitos
            $telefone="(".substr($telefone,0,2).") ".substr($telefone,2,-4)." - ".substr($telefone,-4);
            }

            if($celular !== null){
            $celular="(".substr($celular,0,2).") ".substr($celular,2,-4)." - ".substr($celular,-4);
            }


            $campoNome = '';
            $documento = $client->documento;
            $mask = '';
            if(strlen($client->documento) <= 11){
                $campoNome = 'Cpf:';
                $mask = '###.###.###-##';
            }else{
                $campoNome = 'Cnpj:';
                $mask = '##.###.###/####-##';
            }
        @endphp

        <div class="flex">
            <table class="tabela-relatorio">
                <tr>
                    <td class="indice">{{$client->id}}</td>
                    <td class="texto">
                        <b>Nome:</b> {{$client->nome .' |'}}
                        <b>{{$campoNome}} </b>{{App\Http\Controllers\PdfController::mask($documento,$mask).' |'}}
                        @can('gerenciamento')<b>Situação:</b> {{$client->status .' |'}}@endcan
                        <b>Telefone:</b> {{$telefone??'Não possui.'}}
                        <b>Celular:</b> {{$celular??'Não possui.'}}
                        <b>E-mail:</b> {{$contact->email??'Não possui.'}}
                        <b>Cadastrado em:</b> {{date_format(date_create($client->created_at), 'd/m/Y')}}
                    </td>
                </tr>

            </table>
        </div>
    @empty
        <p>Nenhum cliente encontrado com as características passadas.</p>
    @endforelse

    @break

    @case('providers')

    <h3>Relatório de fornecedores</h3>
    <h4>Quantidade encontrada: {{count($providers->toArray())}}</h4>

    @forelse($providers as $provider)
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

            $documento = $provider->cnpj;
            $mask = '##.###.###/####-##';

        @endphp

        <div class="flex">
            <table class="tabela-relatorio">
                <tr>
                    <td class="indice">{{$provider->id}}</td>
                    <td class="texto">
                        <b>Nome:</b> {{$provider->nome .' |'}}
                        <b>Cnpj: </b>{{App\Http\Controllers\PdfController::mask($documento,$mask).' |'}}
                        <b>Situação:</b> {{$provider->situacao .' |'}}
                        <b>Telefone:</b> {{$telefone??'Não possui.'}}{{' |'}}
                        <b>Celular:</b> {{$celular??'Não possui.'}}{{' |'}}
                        <b>E-mail:</b> {{$contact->email??'Não possui.'}}{{' |'}}
                        <b>Cadastrado em:</b> {{date_format(date_create($provider->created_at), 'd/m/Y')}}
                    </td>
                </tr>

            </table>
        </div>
    @empty
        <p>Nenhum fornecedor encontrado com as características passadas.</p>
    @endforelse

    @break

    @case('sales')

    <h3>Relatório de vendas</h3>
    <h4>Quantidade encontrada: {{count($sales->toArray())}}</h4>

    @forelse($sales as $sale)
        @php
            $budget = $sale->budget()->first();
            $client = $budget->client()->first();

            $valorVenda = $sale->installments()->first();
            if($valorVenda){
            $valorVenda = $valorVenda->valor_parcela * $sale->qtd_parcelas;
            }else{
            $valorVenda = $sale->payments()->first()->valor_pago;
            }
            $valorVenda += $sale->entrada;
        @endphp

        <div class="flex">
            <table class="tabela-relatorio">
                <tr>
                    <td class="indice">{{$sale->id}}</td>
                    <td class="texto">
                        <b>Orçamento utilizado:</b> {{$budget->nome .' |'}}
                        <b>Cliente: </b>{{$client->nome??'Anônimo'}}{{' |'}}
                        <b>Forma de pagamento:</b> {{$sale->tipo_pagamento .' |'}}
                        <b>Valor da venda:</b> {{$valorVenda}}{{' |'}}
                        <b>Data da venda:</b> {{date_format(date_create($sale->data_venda), 'd/m/Y')}}
                    </td>
                </tr>
            </table>
        </div>
    @empty
        <p>Nenhuma venda encontrada com as características passadas.</p>
    @endforelse

    @break

    @case('products')

    @php
        $quantidade = 0;
        if($mproducts !== null){
            $quantidade += count($mproducts->toArray());
        }

    @endphp

    <h3>Relatório de produtos por quantidade vendida</h3>
    <h4>Quantidade encontrada: {{$quantidade}}</h4>

    @forelse($mproducts as $mproduct)
        <div class="flex">
            <table class="tabela-relatorio">
                <tr>
                    <td class="indice">{{$mproduct->id}}</td>
                    <td class="texto">
                        <b>Nome:</b> {{$mproduct->nome .' |'}}
                        <b>Descrição:</b> {{$mproduct->descricao}}<hr>
                        <b>Qtd vendida:</b> {{$mproduct->products->sum('qtd')}}
                    </td>
                </tr>

            </table>
        </div>
    @empty
        <p>Nenhum produto encontrado.</p>
    @endforelse
    
    @break

    @default
    <p>Ocorreu um erro inesperado, reinicie a página!</p>
@endswitch

</body>
</html>
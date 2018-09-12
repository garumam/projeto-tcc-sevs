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
            vertical-align: center;
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


    <p>AQUI É ESTOQUE</p>


    @break

    @case('financial')


    <p>AQUI É FINANCEIRO</p>


    @break

    @case('clients')


    <p>AQUI É CLIENTE</p>


    @break

    @default
    <p>Ocorreu um erro inesperado, reinicie a página!</p>
@endswitch

</body>
</html>
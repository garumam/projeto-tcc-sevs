<table class="table table-hover">
    <thead>
    <tr>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Orçamento</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Cliente</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Valor da venda</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Falta pagar</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
    </tr>
    </thead>
    <tbody>

    @foreach($sales->where('tipo_pagamento','A PRAZO') as $sale)

        @if(!empty($sale->budget->client) && !empty($sale->installments->where('status_parcela','ABERTO')->shift()))

            @php $valorpago = 0; @endphp
            @foreach($sale->payments as $payment)
                @php $valorpago += $payment->valor_pago; @endphp
            @endforeach
            @php $faltapagar = $sale->budget->total - $valorpago; @endphp
            <tr>
                <th scope="row">{{$sale->id}}</th>
                <td>{{$sale->budget->nome}}</td>
                <td>{{$sale->budget->client->nome}}</td>
                <td>{{$sale->budget->total}}</td>
                <td>{{$faltapagar}}</td>
                <td>
                    <a class="btn-link" href="{{ route('sales.pay',['id'=> $sale->id]) }}">
                        <button class="btn btn-success mb-1 card-shadow-1dp d-flex"
                                title="Pagar"><i class="fas fa-dollar-sign"
                                                 style="font-size: 1.5rem;"></i></button>
                    </a>
                </td>
            </tr>

        @endif
    @endforeach
    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($sales->count() == 0) ? 'Nenhum resultado encontrado': ''}}</p>
{{ $sales->links('layouts.pagination') }}



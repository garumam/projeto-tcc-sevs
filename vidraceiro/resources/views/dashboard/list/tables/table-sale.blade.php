<table class="table table-hover">
    <thead>
    <tr>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Orçamento</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Cliente</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Pagamento</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Valor da venda</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Valor pago</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Usuário</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
    </tr>
    </thead>
    <tbody>
    @foreach($sales as $sale)
        <tr>
            <th scope="row">{{$sale->id}}</th>
            <td>{{$sale->budget->nome}}</td>
            <td>{{$sale->budget->client->nome or 'Anônimo'}}</td>
            <td><span class="badge {{$sale->tipo_pagamento === 'A VISTA'? 'badge-secondary':'badge-warning'}}">{{$sale->tipo_pagamento}}</span></td>
            
            <td>R${{$sale->valor_venda + $sale->entrada}}</td>
            @php $valorpago = 0; @endphp
            @foreach($sale->payments as $payment)
                @php $valorpago += $payment->valor_pago; @endphp
            @endforeach
            <td style="color: #28a745;">R${{$valorpago}}</td>

            @php $user = $sale->user()->first(); @endphp
            <td><span class="badge {{ !empty($user)? 'badge-primary' : 'badge-dark' }}">{{ !empty($user)? $user->name : 'Excluído' }}</span></td>

            <td>
                <a class="btn-link" href="{{ route('sales.show',['id'=> $sale->id]) }}">
                    <button class="btn btn-light mb-1 card-shadow-1dp" title="Ver"><i class="fas fa-eye"></i></button>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($sales->count() == 0) ? 'Nenhuma venda encontrada': ''}}</p>
{{ $sales->links('layouts.pagination') }}



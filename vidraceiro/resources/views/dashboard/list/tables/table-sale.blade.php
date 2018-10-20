<table class="table table-hover">
    <thead>
    <tr>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Orçamento</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Cliente</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Pagamento</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Valor da venda</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Valor pago</th>
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
            <td>{{$sale->budget->total}}</td>
            @php $valorpago = 0; @endphp
            @foreach($sale->payments as $payment)
                @php $valorpago += $payment->valor_pago; @endphp
            @endforeach
            <td>{{$valorpago}}</td>
            <td>

                {{--@php
                    $ordem = $sale->budget->order()->first();
                    $parcelaPaga = $sale->installments()->where('status_parcela','PAGO')->first();
                    $parcelaAberta = $sale->installments()->where('status_parcela','ABERTO')->first();
                    $editar = $deletar = true;
                @endphp
                @if(!empty($ordem))
                    @if($ordem->situacao === 'ANDAMENTO' || $ordem->situacao === 'ABERTA')
                        @php $editar = $deletar = false; @endphp
                    @endif
                @endif

                @if($sale->budget->status === 'FINALIZADO')
                    @php $editar = false; @endphp
                @endif

                @if(!empty($parcelaAberta) && !empty($parcelaPaga))
                    @php $editar = false; $deletar = false; @endphp
                @endif--}}

                <a class="btn-link" href="{{ route('sales.show',['id'=> $sale->id]) }}">
                    <button class="btn btn-light mb-1 card-shadow-1dp" title="Ver"><i class="fas fa-eye"></i></button>
                </a>
                {{--@if($editar)--}}
                    <a class="btn-link" href="{{ route('sales.edit',['id'=> $sale->id]) }}">
                        <button class="btn btn-warning mb-1 card-shadow-1dp pl-2 pr-2" title="Editar"><i class="fas fa-edit pl-1"></i></button>
                    </a>
                {{--@endif
                @if($deletar)--}}
                    <a class="btn-link" onclick="deletar(event,this.id,'sales')" id="{{ $sale->id }}">
                        <button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar"><i class="fas fa-trash-alt"></i></button>
                    </a>
                {{--@endif--}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($sales->count() == 0) ? 'Nenhuma venda encontrada': ''}}</p>
{{ $sales->links('layouts.pagination') }}



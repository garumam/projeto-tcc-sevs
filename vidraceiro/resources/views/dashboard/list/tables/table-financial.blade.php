@php
    $receitas = 0.00;
    $despesas = 0.00;
    foreach($financialsByPeriod as $financial){
        if($financial->tipo === 'RECEITA'){
            $receitas += $financial->valor;
        }else{
            $despesas += $financial->valor;
        }
    }
    $saldo = $receitas - $despesas;
@endphp
<div class="form-group col-md-12 mb-2 mt-1 border">
    <div class="form-group col-md-12 border-bottom mt-2 mb-2">
        <label style="color:#28a745;">Total Receitas por busca: </label>
        <label style="color:#28a745;">R${{$receitas}} </label>
    </div>
    <div class="form-group col-md-12 border-bottom mt-2 mb-2">
        <label style="color:#dc3545;">Total Despesas por busca: </label>
        <label style="color:#dc3545;">R${{$despesas}}</label>
    </div>
    <div class="form-group col-md-12 mt-3 mb-2">
        <label>Saldo por busca: </label>
        <label style="color:{{$saldo > 0? '#28a745':($saldo < 0?'#dc3545':'')}}">R${{$saldo}}</label>
    </div>
</div>

<table class="table table-hover">
    <thead>

    <tr class="tabela-vidro">
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Tipo</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Descrição</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Valor</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Data</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Usuário</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
    </tr>

    </thead>
    <tbody>

    @foreach($financials as $financial)
        <tr class="tabela-vidro">
            <th scope="row">{{ $financial->id }}</th>
            @if($financial->tipo === 'RECEITA')
                <td><span class="badge badge-success">Receita</span></td>
            @else
                <td><span class="badge badge-danger">Despesa</span></td>
            @endif
            <td>{{ $financial->descricao??'' }}</td>
            @if($financial->tipo === 'RECEITA')
                <td style="color:#28a745;">R${{ $financial->valor }}</td>
            @else
                <td style="color:#dc3545;">R${{ $financial->valor }}</td>
            @endif
            @php $payment = $financial->payment()->first(); $user = $financial->user()->first(); @endphp
            @if(!empty($payment))
                @php $sale = $payment->sale()->first(); @endphp
                <td>{{ date_format(date_create($payment->data_pagamento), 'd/m/Y') }}</td>
                @php $payment = null; @endphp
            @else
                <td>{{ date_format(date_create($financial->create_at), 'd/m/Y') }}</td>
            @endif
            @if(!empty($user))
                <td><span class="badge badge-primary">{{ $user->name }}</span></td>
                @php $user = null; @endphp
            @else
                <td><span class="badge badge-dark">Excluído</span></td>
            @endif
            <td>
                @if(!empty($sale))
                    <a class="btn-link" target="_blank" href="{{ route('sales.show',['id'=> $sale->id]) }}">
                        <button class="btn btn-light mb-1 card-shadow-1dp" type="button" title="Ver venda relacionada a este pagamento"><i class="fas fa-eye"></i></button>
                    </a>
                    @php $sale = null; @endphp
                @endif
                <a class="btn-link" onclick="deletar(event,this.id,'financial')" id="{{ $financial->id }}">
                    <button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar"><i class="fas fa-trash-alt"></i>
                    </button>
                </a>
            </td>

        </tr>
    @endforeach


    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($financials->count() == 0) ? 'Nenhum resultado encontrado': ''}}</p>
{{ $financials->links('layouts.pagination') }}



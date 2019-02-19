
@if(!Request::is('restore'))

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
        $saldo = number_format(($receitas - $despesas),2,',','.');
        $receitas = number_format(($receitas),2,',','.');
        $despesas = number_format(($despesas),2,',','.');
    @endphp

    <div class="form-group p-0 col-md-12 mb-4">
        <ul class="list-group">
            <li class="list-group-item active" style="background-color: #4264FB; border-color: #4264FB">Total por busca</li>
            <li class="list-group-item" style="color:#28a745;">Total Receitas: R${{$receitas}}</li>
            <li class="list-group-item" style="color:#dc3545;">Total Despesas: R${{$despesas}}</li>
            <li class="list-group-item" style="color:#191919;">Saldo:
                <span style="color:{{$saldo > 0? '#28a745':($saldo < 0?'#dc3545':'')}}">R${{$saldo}}</span>
            </li>
        </ul>
    </div>

@endif


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
            <td><span class="badge badge-{{$financial->tipo == 'RECEITA' ? 'success' : 'danger'}}">{{$financial->tipo}}</span></td>
            <td>{{ $financial->descricao??'' }}</td>
            <td style="{{$financial->tipo === 'RECEITA' ? 'color:#28a745;' : 'color:#dc3545;'}}">
                R${{ $financial->valor }}</td>
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

                @if(Request::is('restore'))

                    <a class="btn-link" href="{{ route('restore.restore',['tipo'=>'financeiro','id'=> $financial->id]) }}">
                        <button class="btn btn-light mb-1 card-shadow-1dp" title="Restaurar"><i class="fas fa-undo-alt"></i></button>
                    </a>

                @else

                    @if(!empty($sale))
                        <a class="btn-link" target="_blank" href="{{ route('sales.show',['id'=> $sale->id]) }}">
                            <button class="btn btn-light mb-1 card-shadow-1dp" type="button"
                                    title="Ver venda relacionada a este pagamento"><i class="fas fa-eye"></i></button>
                        </a>
                        @php $sale = null; @endphp
                    @endif
                    <a class="btn-link" onclick="deletar(event,this.id,'financial')" id="{{ $financial->id }}">
                        <button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar"><i class="fas fa-trash-alt"></i>
                        </button>
                    </a>

                @endif

            </td>

        </tr>
    @endforeach


    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($financials->count() == 0) ? 'Nenhum resultado encontrado': ''}}</p>
{{ $financials->links('layouts.pagination') }}



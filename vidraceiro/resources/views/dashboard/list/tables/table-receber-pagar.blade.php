<table class="table table-hover">
    <thead>
    <tr>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Descrição</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Valor</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Data</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Usuário</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
    </tr>
    </thead>
    <tbody>
    @php 
    if(!empty($receberOuPagar)){
        $installAndFinanc = $receberOuPagar == 'receber'? $futureReceipts : $futurePayments;
    }
    @endphp
    @foreach($installAndFinanc as $object)
        <tr>
            @if($object instanceof App\Installment)

            @php
                $sale = $object->sale()->first();
                $user = $sale->user()->first();
                $client = $sale->budget()->first()->client()->first();
            @endphp

            <td>{{ $client->nome??'Anônimo'}} - Parcela a receber</td>
            @php $valorTotal = number_format(($object->valor_parcela + $object->multa),2,'.',''); @endphp
            <td style="color: #28a745;">R${{$valorTotal}}</td>
            <td>{{date_format(date_create($object->data_vencimento), 'd/m/Y')}}</td>
            @if(!empty($user))
            <td><span class="badge badge-primary">{{ $user->name }}</span></td>
            @php $user = null; @endphp 
            @else
            <td><span class="badge badge-dark">Excluído</span></td>
            @endif
            <td>
                <a class="btn-link" target="_blank" href="{{ route('sales.show',['id'=> $object->venda_id]) }}">
                    <button class="btn btn-light mb-1 card-shadow-1dp" type="button"
                            title="Ver venda relacionada a esta parcela"><i class="fas fa-eye"></i></button>
                </a>
            </td>


            @else


            <td>{{ $object->descricao??'' }}</td>
            <td style="color: {{$object->tipo == 'RECEITA'? '#28a745' : '#dc3545'}};">R${{ $object->valor }}</td>
            @php $user = $object->user()->first(); @endphp 
            <td>{{ date_format(date_create($object->data_vencimento), 'd/m/Y') }}</td> 
            @if(!empty($user))
            <td><span class="badge badge-primary">{{ $user->name }}</span></td>
            @php $user = null; @endphp 
            @else
            <td><span class="badge badge-dark">Excluído</span></td>
            @endif
            <td>

                <a class="btn-link" onclick="atualizar(event,this.id)" id="{{$object->id}}">
                    <button class="btn btn-success mb-1 card-shadow-1dp" title="Confirmar"><i class="fas fa-check-square"></i></button>
                </a>
                
                <a class="btn-link" onclick="deletar(event,this.id,'financial')" id="{{ $object->id }}">
                    <button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar"><i class="fas fa-trash-alt"></i>
                    </button>
                </a> 

            </td>


            @endif
            
        </tr>
    @endforeach

    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($installAndFinanc->count() == 0) ? 'Nenhum valor encontrado': ''}}</p>
{{ $installAndFinanc->links('layouts.pagination') }}


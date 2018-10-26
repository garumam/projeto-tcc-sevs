<table class="table table-hover">
    <thead>
    <tr>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Nome</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Situação</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Data inicial</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Data final</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Total</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <th scope="row">{{$order->id}}</th>
            <td>{{$order->nome}}</td>
            <td><span class="badge {{$order->situacao === 'ABERTA'?'badge-warning'
                                        :($order->situacao === 'ANDAMENTO'?'badge-secondary'
                                        :(($order->situacao === 'CONCLUIDA'?'badge-primary' :'badge-dark')))}}">{{ucfirst($order->situacao)}}</span></td>
            <td>{{date_format(date_create($order->data_inicial), 'd/m/Y')}}</td>
            <td>{{date_format(date_create($order->data_final), 'd/m/Y')}}</td>
            <td style="color: #28a745;">R${{$order->total}}</td>
            <td>
                <a class="btn-link" href="{{ route('orders.show',['id'=> $order->id]) }}">
                    <button class="btn btn-light mb-1 card-shadow-1dp" title="Ver"><i class="fas fa-eye"></i></button>
                </a>
                @if($order->situacao === 'ABERTA')
                    <a class="btn-link" href="{{ route('orders.edit',['id'=> $order->id]) }}">
                        <button class="btn btn-warning mb-1 card-shadow-1dp pl-2 pr-2" title="Editar"><i class="fas fa-edit pl-1"></i></button>
                    </a>
                @endif
                @if($order->situacao === 'CONCLUIDA' || $order->situacao === 'CANCELADA')
                    <a class="btn-link" onclick="deletar(event,this.id,'orders')" id="{{$order->id}}">
                        <button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar"><i class="fas fa-trash-alt"></i></button>
                    </a>
                @endif

                @if($order->situacao === 'ANDAMENTO')
                    <a class="btn-link" onclick="atualizar(event,this.id,'CONCLUIDA')" id="{{$order->id}}">
                        <button class="btn btn-primary mb-1 card-shadow-1dp" title="Concluir"><i class="fas fa-calendar-check"></i></button>
                    </a>
                    <a class="btn-link" onclick="atualizar(event,this.id,'CANCELADA')" id="{{$order->id}}">
                        <button class="btn btn-dark mb-1 card-shadow-1dp" title="Cancelar"><i class="fas fa-calendar-times"></i></button>
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($orders->count() == 0) ? 'Nenhuma ordem de serviço encontrada': ''}}</p>
{{ $orders->links('layouts.pagination') }}



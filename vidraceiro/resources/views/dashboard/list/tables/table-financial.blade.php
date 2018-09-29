<table class="table table-hover">
    <thead>

    <tr class="tabela-vidro">
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Tipo</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Descrição</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Valor</th>
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
            <td>
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



<table class="table table-hover">
    <thead>
    <tr>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Nome</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">E-mail</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Situação</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
    </tr>
    </thead>
    <tbody>
    @foreach($providers as $provider)
        <tr>
            <th scope="row">{{ $provider->id }}</th>
            <td>{{ $provider->nome }}</td>
            <td>{{ $provider->contact()->first()->email }}</td>
            <td>
                <span class="badge {{$provider->situacao == "ativo" ? 'badge-success' : 'badge-secondary'}}">{{ ucfirst($provider->situacao) }}</span>
            </td>
            <td>
                <a class="btn-link" href="{{ route('providers.show',['id'=> $provider->id]) }}">
                    <button class="btn btn-light mb-1 card-shadow-1dp" title="Ver"><i class="fas fa-eye"></i>
                    </button>
                </a>
                <a class="btn-link" href="{{ route('providers.edit',['id' => $provider->id]) }}">
                    <button class="btn btn-warning mb-1 card-shadow-1dp pl-2 pr-2" title="Editar"><i
                                class="fas fa-edit pl-1"></i></button>
                </a>
                <a class="btn-link" onclick="deletar(event,this.id,'providers')" id="{{ $provider->id }}">
                    <button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar"><i
                                class="fas fa-trash-alt"></i></button>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>

</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($providers->count() == 0) ? 'Nenhum fornecedor encontrado': ''}}</p>
{{ $providers->links('layouts.pagination') }}



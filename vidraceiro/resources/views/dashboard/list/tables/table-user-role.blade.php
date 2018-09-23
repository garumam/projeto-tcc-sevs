<table class="table table-hover">
    <thead>
    <tr>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Nome</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Descrição</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
    </tr>
    </thead>
    <tbody>
    @foreach($rolesusuario as $role)
        <tr>
            <th scope="row">{{ $role->id }}</th>
            <td>{{ $role->nome }}</td>
            <td>{{ $role->descricao }}</td>
            <td>
                {{--<a class="btn-link" href="{{ route('roles.edit',['id' => $role->id]) }}">--}}
                {{--<button class="btn btn-warning mb-1" {{$role->nome === 'admin' ? 'disabled' :'' }}>--}}
                {{--Editar--}}
                {{--</button>--}}
                {{--</a>--}}
                <a class="btn-link" onclick="deletar(this.id,'users/role')"
                   id="{{ $user->id .'/'.$role->id }}">
                    <button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar" {{$role->nome === 'admin' ? 'disabled' :'' }}>
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($rolesusuario->count() == 0) ? 'Nenhum usuario encontrado': ''}}</p>
{{ $rolesusuario->links('layouts.pagination') }}



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
    @foreach($permissionsroles as $permission)
        <tr>
            <th scope="row">{{ $permission->id }}</th>
            <td>{{ $permission->nome }}</td>
            <td>{{ $permission->descricao }}</td>
            <td>
                <a class="btn-link" onclick="deletar(event,this.id,'roles/permission')"
                   id="{{ $role->id .'/'.$permission->id }}">
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
   style="font-weight: 600;"> {{ ($permissionsroles->count() == 0) ? 'Nenhuma permissão encontrada': ''}}</p>
{{ $permissionsroles->links('layouts.pagination') }}



<table class="table table-hover">
    <thead>
    <tr>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Nome</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Tipo</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Grupo de imagens</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <th scope="row">{{$category->id}}</th>
            <td>{{$category->nome}}</td>
            <td>{{ucfirst($category->tipo)}}</td>
            <td>{{$category->grupo_imagem}}</td>
            <td>
                <a class="btn-link" href="{{ route('categories.edit',['id'=> $category->id]) }}">
                    <button class="btn btn-warning mb-1 card-shadow-1dp pl-2 pr-2" title="Editar"><i class="fas fa-edit pl-1"></i></button>
                </a>
                <a class="btn-link" onclick="deletar(event,this.id,'categories')" id="{{ $category->id }}">
                    <button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar"><i class="fas fa-trash-alt"></i></button>
                </a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($categories->count() == 0) ? 'Nenhuma categoria encontrada': ''}}</p>
{{ $categories->links('layouts.pagination') }}



<table class="table table-hover">
    <thead>
    <!--INICIO HEAD DO COMPONENTE-->
    <tr class="tabela-componente">
        <th class="noborder" scope="col">Id</th>
        <th class="noborder" scope="col">Nome</th>
        <th class="noborder" scope="col">Categoria</th>
        <th class="noborder" scope="col">Qtd em estoque</th>
    </tr>
    <!--FIM HEAD DO COMPONENTE-->
    </thead>
    <tbody>
    <!--INICIO BODY DO COMPONENTE-->
    @foreach($components as $component)
        <tr class="tabela-componente">
            <th scope="row">{{ $component->id }}</th>
            <td>{{ $component->nome }}</td>
            <td>{{ $component->category->nome }}</td>
            <td>{{ $component->storage->qtd or '0' }}</td>
        </tr>
    @endforeach
    <!--FIM BODY DO COMPONENTE-->
    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($components->count() == 0) ? 'Nenhum componente encontrado': ''}}</p>
{{ $components->links('layouts.pagination') }}



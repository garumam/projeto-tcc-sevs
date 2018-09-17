<table class="table table-hover">
    <thead>
    <tr class="tabela-aluminio">
        <th class="noborder" scope="col">Id</th>
        <th class="noborder" scope="col">Perfil</th>
        <th class="noborder" scope="col">Categoria</th>
        <th class="noborder" scope="col">Qtd em estoque</th>
    </tr>
    </thead>
    <tbody>
    <!--INICIO BODY DO ALUMINIO-->
    @foreach($aluminums as $aluminum)
        <tr class="tabela-aluminio">
            <th scope="row">{{ $aluminum->id }}</th>
            <td>{{ $aluminum->perfil }}</td>
            <td>{{ $aluminum->category->nome }} {{ $aluminum->espessura ? $aluminum->espessura.'mm' : ''}}</td>
            <td>{{ $aluminum->storage->qtd or '0' }}</td>
        </tr>
    @endforeach
    <!--FIM BODY DO ALUMINIO-->
    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($aluminums->count() == 0) ? 'Nenhum aluminio encontrado': ''}}</p>
{{ $aluminums->links('layouts.pagination') }}



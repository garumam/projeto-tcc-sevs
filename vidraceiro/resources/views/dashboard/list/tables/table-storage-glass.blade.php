<table class="table table-hover">
    <thead>
    <!--INICIO HEAD DO VIDRO-->
    <tr class="tabela-vidro">
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Nome</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Categoria</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">M² em estoque</th>
    </tr>
    </thead>
    <tbody>
    <!--INICIO BODY DO VIDRO-->
    @foreach($glasses as $glass)
        <tr class="tabela-vidro">
            <th scope="row">{{ $glass->id }}</th>
            <td>{{ $glass->nome }}</td>
            <td>{{ $glass->category->nome }}</td>
            <td>{{ $glass->storage->metros_quadrados or '0' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($glasses->count() == 0) ? 'Nenhum vidro encontrado': ''}}</p>
{{ $glasses->links('layouts.pagination') }}



<table class="table table-hover">
    <thead>
    <!--INICIO HEAD DO VIDRO-->
    <tr class="tabela-vidro">
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Nome</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Categoria</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Preço m²</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Modelo</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
    </tr>
    </thead>
    <tbody>
    <!--INICIO BODY DO VIDRO-->
    @foreach($glasses as $glass)
        <tr class="tabela-vidro">
            <th scope="row">{{ $glass->id }}</th>
            <td>{{ $glass->nome }}</td>
            <td>{{ $glass->category->nome }}</td>
            <td>R${{ $glass->preco }}</td>
            <td>{{ $glass->is_modelo ? 'Sim' : 'Não' }}</td>
            <td>
                <a class="btn-link" href="{{ route('materials.show',['type'=>'glass','id'=> $glass->id]) }}">
                    <button class="btn btn-light mb-1 card-shadow-1dp" title="Ver"><i class="fas fa-eye"></i></button>
                </a>
                <a class="btn-link"
                   href="{{ route('materials.edit',['type'=>'glass','id'=>$glass->id]) }}">
                    <button class="btn btn-warning mb-1 card-shadow-1dp pl-2 pr-2" title="Editar"><i class="fas fa-edit pl-1"></i></button>
                </a>
                <a class="btn-link" onclick="deletar(this.id,'materials/glass')" id="{{ $glass->id }}">
                    <button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar"><i class="fas fa-trash-alt"></i></button>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($glasses->count() == 0) ? 'Nenhum vidro encontrado': ''}}</p>
{{ $glasses->links('layouts.pagination') }}



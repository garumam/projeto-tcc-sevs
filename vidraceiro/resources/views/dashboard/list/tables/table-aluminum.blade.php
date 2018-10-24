<table class="table table-hover">
    <thead>
    <tr class="tabela-aluminio">
        <th class="noborder" scope="col">Id</th>
        <th class="noborder text-center" scope="col">Imagem</th>
        <th class="noborder" scope="col">Perfil</th>
        <th class="noborder" scope="col">Categoria</th>
        <th class="noborder" scope="col">Medida</th>
        <th class="noborder" scope="col">Peso</th>
        <th class="noborder" scope="col">Preço kg</th>
        <th class="noborder" scope="col">Modelo</th>
        <th class="noborder" scope="col">Ação</th>
    </tr>
    </thead>
    <tbody>
    <!--INICIO BODY DO ALUMINIO-->
    @foreach($aluminums as $aluminum)
        <tr class="tabela-aluminio">
            <th scope="row">{{ $aluminum->id }}</th>

            <td class="text-center"><img style="height: 5rem;" src="{{ $aluminum->imagem??'/img/semimagem.png' }}" class="img-fluid img-thumbnail"></td>

            <td>{{ $aluminum->perfil }}</td>
            <td>{{ $aluminum->category->nome }} {{ $aluminum->espessura ? $aluminum->espessura.'mm' : ''}}</td>
            <td>{{ $aluminum->medida ? $aluminum->medida.'m' : ''}}</td>
            <td>{{ $aluminum->peso }}kg</td>
            <td>R${{ $aluminum->preco }}</td>
            <td>{{ $aluminum->is_modelo ? 'Sim' : 'Não' }}</td>
            <td>
                <a class="btn-link" href="{{ route('materials.show',['type'=>'aluminum','id'=> $aluminum->id]) }}">
                    <button class="btn btn-light mb-1 card-shadow-1dp" title="Ver"><i class="fas fa-eye"></i></button>
                </a>
                <a class="btn-link"
                   href="{{ route('materials.edit',['type'=>'aluminum','id'=> $aluminum->id]) }}">
                    <button class="btn btn-warning mb-1 card-shadow-1dp pl-2 pr-2" title="Editar"><i class="fas fa-edit pl-1"></i></button>
                </a>
                <a class="btn-link" onclick="deletar(event,this.id,'materials/aluminum')" id="{{ $aluminum->id }}">
                    <button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar"><i class="fas fa-trash-alt"></i></button>
                </a>
            </td>
        </tr>
    @endforeach
    <!--FIM BODY DO ALUMINIO-->
    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($aluminums->count() == 0) ? 'Nenhum aluminio encontrado': ''}}</p>
{{ $aluminums->links('layouts.pagination') }}



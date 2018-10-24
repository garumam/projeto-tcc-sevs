<table class="table table-hover">
    <thead>
    <!--INICIO HEAD DO COMPONENTE-->
    <tr class="tabela-componente">
        <th class="noborder" scope="col">Id</th>
        <th class="noborder text-center" scope="col">Imagem</th>
        <th class="noborder" scope="col">Nome</th>
        <th class="noborder" scope="col">Categoria</th>
        <th class="noborder" scope="col">Preço</th>
        <th class="noborder" scope="col">Qtd</th>
        <th class="noborder" scope="col">Modelo</th>
        <th class="noborder" scope="col">Ação</th>
    </tr>
    <!--FIM HEAD DO COMPONENTE-->
    </thead>
    <tbody>
    <!--INICIO BODY DO COMPONENTE-->
    @foreach($components as $component)
        <tr class="tabela-componente">
            <th scope="row">{{ $component->id }}</th>

            <td class="text-center"><img style="height: 5rem;" src="{{ $component->imagem??'/img/semimagem.png' }}" class="img-fluid img-thumbnail"></td>

            <td>{{ $component->nome }}</td>
            <td>{{ $component->category->nome }}</td>
            <td>R${{ $component->preco }}</td>
            <td>{{ $component->qtd }}</td>
            <td>{{ $component->is_modelo ? 'Sim' : 'Não' }}</td>
            <td>
                <a class="btn-link"
                   href="{{ route('materials.show',['type'=>'component','id'=> $component->id]) }}">
                    <button class="btn btn-light mb-1 card-shadow-1dp" title="Ver"><i
                                class="fas fa-eye"></i></button>
                </a>
                <a class="btn-link"
                   href="{{ route('materials.edit',['type'=>'component','id'=> $component->id]) }}">
                    <button class="btn btn-warning mb-1 card-shadow-1dp pl-2 pr-2"
                            title="Editar"><i class="fas fa-edit pl-1"></i></button>
                </a>
                <a class="btn-link" onclick="deletar(event,this.id,'materials/component')"
                   id="{{ $component->id }}">
                    <button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar">
                        <i class="fas fa-trash-alt"></i></button>
                </a>
            </td>
        </tr>
    @endforeach
    <!--FIM BODY DO COMPONENTE-->
    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($components->count() == 0) ? 'Nenhum componente encontrado': ''}}</p>
{{ $components->links('layouts.pagination') }}



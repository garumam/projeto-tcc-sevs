<table class="table table-hover">
    <thead>
    <tr>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
        <th class="noborder text-center" scope="col" style="padding: 12px 30px 12px 16px;">Imagem</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Produto</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Descrição</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Categoria</th>
        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mProducts as $mProduct)
        <tr>
            <th scope="row">{{ $mProduct->id }}</th>

            <td class="text-center"><img style="height: 5rem;" src="{{ $mProduct->imagem??'/img/semimagem.png' }}" class="img-fluid img-thumbnail"></td>

            <td>{{ $mProduct->nome }}</td>
            <td>{{ $mProduct->descricao }}</td>
            <td>{{ $mProduct->category->nome }}</td>
            <td>
                @if(Request::is('restore'))

                    <a class="btn-link" href="{{ route('restore.restore',['tipo'=>'mprodutos','id'=> $mProduct->id]) }}">
                        <button class="btn btn-light mb-1 card-shadow-1dp" title="Restaurar"><i class="fas fa-undo-alt"></i></button>
                    </a>

                @else

                    <a class="btn-link" href="{{ route('mproducts.edit',['id'=> $mProduct->id]) }}">
                        <button class="btn btn-warning mb-1 card-shadow-1dp pl-2 pr-2" title="Editar"><i class="fas fa-edit pl-1"></i></button>
                    </a>
                    <a class="btn-link" onclick="deletar(event,this.id,'products')" id="{{ $mProduct->id }}">
                        <button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar"><i class="fas fa-trash-alt"></i></button>
                    </a>

                @endif

            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="m-4 text-center"
   style="font-weight: 600;"> {{ ($mProducts->count() == 0) ? 'Nenhum produto encontrado': ''}}</p>
{{ $mProducts->links('layouts.pagination') }}

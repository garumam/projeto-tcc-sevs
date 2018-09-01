
<div class="form-row">
    <div class="form-group col-md-8">
        <label for="select-material">Materiais</label>
        <select id="select-material" class="custom-select">
            <option value="0">Vidros</option>
            <option value="1">Aluminios</option>
            <option value="2">Componentes</option>
        </select>
    </div>
</div>


<div class="form-row mt-3 align-items-end">

    <div class="form-group col-md-4">
        <label for="select-vidro" id="label_categoria">Vidros</label>
        {{--<select id="select-vidro" name="vidro_id" class="custom-select">
            <option value="" selected>Selecione um vidro</option>
            @foreach($glasses as $glass)
                <option data-preco="{{$glass->preco}}"
                        data-comparador="{{ trim($glass->cor . $glass->tipo . $glass->categoria_vidro_id) }}" value="{{$glass->id}}">{{$glass->nome}}</option>
            @endforeach
        </select>--}}
        {{--<select id="select-aluminio" name="aluminio_id" class="custom-select"
                style="display: none;">
            <option value="" selected>Selecione um aluminio</option>
            @foreach($aluminums as $aluminum)
                <option data-medida="{{$aluminum->medida}}"
                        data-peso="{{$aluminum->peso}}"
                        data-preco="{{$aluminum->preco}}"
                        value="{{$aluminum->id}}">{{$aluminum->perfil}}</option>
            @endforeach
        </select>--}}
        {{--<select id="select-componente" name="componente_id" class="custom-select"
                style="display: none;">
            <option value="" selected>Selecione um componente</option>
            @foreach($components as $component)
                <option data-qtd="{{$component->qtd}}"
                        data-preco="{{$component->preco}}"
                        value="{{$component->id}}">{{$component->nome}}</option>
            @endforeach
        </select>--}}
        <select id="select-vidro" class="form-control form-control-chosen" name="vidro_id" data-placeholder="Selecione um vidro" style="display: none;">
            <option></option>
            @foreach($glasses as $glass)
                <option data-preco="{{$glass->preco}}"
                        data-comparador="{{ trim($glass->cor . $glass->tipo . $glass->categoria_vidro_id) }}" value="{{$glass->id}}">{{$glass->nome .' '. $glass->tipo}}</option>
            @endforeach
        </select>
        <select id="select-aluminio" class="form-control form-control-chosen" name="aluminio_id" data-placeholder="Selecione um aluminio" style="display: none;">
            <option></option>
            @foreach($aluminums as $aluminum)
                <option data-medida="{{$aluminum->medida}}"
                        data-peso="{{$aluminum->peso}}"
                        data-preco="{{$aluminum->preco}}"
                        data-tipomedida="{{$aluminum->tipo_medida}}"
                        value="{{$aluminum->id}}">{{$aluminum->perfil}}</option>
            @endforeach
        </select>
        <select id="select-componente" class="form-control form-control-chosen" name="componente_id" data-placeholder="Selecione um componente" style="display: none;">
            <option></option>
            @foreach($components as $component)
                <option data-qtd="{{$component->qtd}}"
                        data-preco="{{$component->preco}}"
                        value="{{$component->id}}">{{$component->nome}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4">

        <button id="bt-add-material-mproduct" class="btn btn-primary btn-block btn-custom"
                type="button">
            Adicionar
        </button>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-12 p-0">
        <div class="topo pl-2">
            <h4 class="titulo">Vidros</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <!--INICIO HEAD DO VIDRO-->
                <tr id="topo-vidro">
                    <th class="noborder" scope="col">Id</th>
                    <th class="noborder" scope="col">Nome</th>
                    <th class="noborder" scope="col">Preço m²</th>
                    <th class="noborder" scope="col">Ação</th>
                </tr>
                <!--FIM HEAD DO VIDRO-->

                <!--INICIO HEAD DO ALUMINIO-->
                <tr id="topo-aluminio" style="display: none;">
                    <th class="noborder" scope="col">Id</th>
                    <th class="noborder" scope="col">Perfil</th>
                    <th class="noborder" scope="col">Medida</th>
                    <th class="noborder" scope="col">Peso</th>
                    <th class="noborder" scope="col">Preço</th>
                    <th class="noborder" scope="col">Ação</th>
                </tr>
                <!--FIM HEAD DO ALUMINIO-->

                <!--INICIO HEAD DO COMPONENTE-->
                <tr id="topo-componente" style="display: none;">
                    <th class="noborder" scope="col">Id</th>
                    <th class="noborder" scope="col">Nome</th>
                    <th class="noborder" scope="col">Preço</th>
                    <th class="noborder" scope="col">Qtd</th>
                    <th class="noborder" scope="col">Ação</th>
                </tr>
                <!--FIM HEAD DO COMPONENTE-->

                </thead>

                <!--INICIO BODY DO VIDRO-->
                <tbody id="tabela-vidro">
                @php
                    $contador = 1;
                @endphp
                @if(!empty(session('mproductcriado')) || !empty($mproductedit))
                    @foreach(!empty(session('mproductcriado')) ? Session::get('mproductcriado')->glasses : $mproductedit->glasses as $glassP)
                        <tr id="linha-vidro-{{$glassP->id}}">
                            <th scope="row">{{$glassP->id}}</th>
                            <td>{{$glassP->nome}}</td>
                            <td>R${{$glassP->preco}}</td>
                            <td>
                                <button id="linha-vidro-{{$glassP->id}}"
                                        class="deletar-material-tabela btn btn-danger mb-1" type="button">Delete
                                </button>

                            </td>
                        </tr>
                    @endforeach
                @endif
                {{--@if(!empty($products))--}}
                {{--@foreach($products as $product)--}}
                {{--@foreach($product->glasses as $glassP)--}}
                {{--<tr id="linha-vidro-{{$glassP->id}}" data-produtoid="{{$product->id}}"--}}
                {{--style="display: none;">--}}
                {{--<th scope="row">{{$glassP->id}}</th>--}}
                {{--<td>{{$glassP->nome}}</td>--}}
                {{--<td>R${{$glassP->preco}}</td>--}}
                {{--<td>--}}
                {{--<button id="linha-vidro-{{$glassP->id}}"--}}
                {{--class="deletar-material-tabela btn btn-danger mb-1" type="button">Delete--}}
                {{--</button>--}}

                {{--</td>--}}
                {{--</tr>--}}
                {{--@endforeach--}}
                {{--@endforeach--}}
                {{--@endif--}}

                @if(!empty(session('products')) || !empty($products))
                    @foreach(!empty($products) ? $products : Session::get('products') as $product)
                        @foreach($product->glasses as $glassP)
                            <tr id="linha-vidro-{{$glassP->id}}" data-produtoid="{{$product->id}}"
                                style="display: none;">
                                <th scope="row">{{$glassP->id}}</th>
                                <td>{{$glassP->nome}}</td>
                                <td>R${{$glassP->preco}}</td>
                                <td>
                                    <button id="linha-vidro-{{$glassP->id}}"
                                            class="deletar-material-tabela btn btn-danger mb-1" type="button">Delete
                                    </button>

                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endif
                </tbody>

                <!--FIM BODY DO VIDRO-->

                <!--INICIO BODY DO ALUMINIO-->
                <tbody id="tabela-aluminio" style="display: none;">
                @if(!empty(session('mproductcriado')) || !empty($mproductedit))
                    @foreach(!empty(session('mproductcriado')) ? Session::get('mproductcriado')->aluminums : $mproductedit->aluminums as $aluminumP)
                        <tr id="linha-aluminio-{{$aluminumP->id}}-{{$contador}}">
                            <th scope="row">{{$aluminumP->id}}</th>
                            <td>{{$aluminumP->perfil}}</td>
                            <td>{{$aluminumP->medida.'M'}}</td>
                            <td>{{$aluminumP->peso.'Kg'}}</td>
                            <td>{{'R$'.$aluminumP->preco}}</td>
                            <td>
                                <button id="linha-aluminio-{{$aluminumP->id}}-{{$contador++}}"
                                        class="deletar-material-tabela btn btn-danger mb-1" type="button">Delete
                                </button>

                            </td>
                        </tr>
                    @endforeach
                @endif
                {{--@if(!empty($products))--}}
                {{--@foreach($products as $product)--}}
                {{--@foreach($product->aluminums as $aluminumP)--}}
                {{--<tr id="linha-aluminio-{{$aluminumP->id}}" data-produtoid="{{$product->id}}"--}}
                {{--style="display: none;">--}}
                {{--<th scope="row">{{$aluminumP->id}}</th>--}}
                {{--<td>{{$aluminumP->perfil}}</td>--}}
                {{--<td>{{$aluminumP->medida}}</td>--}}
                {{--<td>{{$aluminumP->peso}}</td>--}}
                {{--<td>{{$aluminumP->preco}}</td>--}}
                {{--<td>--}}
                {{--<button id="linha-aluminio-{{$aluminumP->id}}"--}}
                {{--class="deletar-material-tabela btn btn-danger mb-1" type="button">Delete--}}
                {{--</button>--}}

                {{--</td>--}}
                {{--</tr>--}}
                {{--@endforeach--}}
                {{--@endforeach--}}
                {{--@endif--}}
                @if(!empty(session('products')) || !empty($products))
                    @foreach(!empty($products) ? $products : Session::get('products') as $product)
                        @foreach($product->aluminums as $aluminumP)
                            <tr id="linha-aluminio-{{$aluminumP->id}}" data-produtoid="{{$product->id}}"
                                style="display: none;">
                                <th scope="row">{{$aluminumP->id}}</th>
                                <td>{{$aluminumP->perfil}}</td>
                                <td>{{$aluminumP->medida.'M'}}</td>
                                <td>{{$aluminumP->peso.'Kg'}}</td>
                                <td>{{'R$'.$aluminumP->preco}}</td>
                                <td>
                                    <button id="linha-aluminio-{{$aluminumP->id}}"
                                            class="deletar-material-tabela btn btn-danger mb-1" type="button">Delete
                                    </button>

                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endif
                </tbody>
                <!--FIM BODY DO ALUMINIO-->

                <!--INICIO BODY DO COMPONENTE-->
                <tbody id="tabela-componente" style="display: none;">
                @if(!empty(session('mproductcriado')) || !empty($mproductedit))
                    @foreach(!empty(session('mproductcriado')) ? Session::get('mproductcriado')->components : $mproductedit->components as $componentP)
                        <tr id="linha-componente-{{$componentP->id}}-{{$contador}}">
                            <th scope="row">{{$componentP->id}}</th>
                            <td>{{$componentP->nome}}</td>
                            <td>{{$componentP->preco}}</td>
                            <td>{{$componentP->qtd}}</td>
                            <td>
                                <button id="linha-componente-{{$componentP->id}}-{{$contador++}}"
                                        class="deletar-material-tabela btn btn-danger mb-1" type="button">Delete
                                </button>

                            </td>
                        </tr>
                    @endforeach
                @endif
                {{--@if(!empty($products))--}}
                {{--@foreach($products as $product)--}}
                {{--@foreach($product->components as $componentP)--}}
                {{--<tr id="linha-componente-{{$componentP->id}}" data-produtoid="{{$product->id}}"--}}
                {{--style="display: none;">--}}
                {{--<th scope="row">{{$componentP->id}}</th>--}}
                {{--<td>{{$componentP->nome}}</td>--}}
                {{--<td>{{$componentP->preco}}</td>--}}
                {{--<td>{{$componentP->qtd}}</td>--}}
                {{--<td>--}}
                {{--<button id="linha-componente-{{$componentP->id}}"--}}
                {{--class="deletar-material-tabela btn btn-danger mb-1" type="button">Delete--}}
                {{--</button>--}}

                {{--</td>--}}
                {{--</tr>--}}
                {{--@endforeach--}}
                {{--@endforeach--}}
                {{--@endif--}}
                @if(!empty(session('products')) || !empty($products))
                    @foreach(!empty($products) ? $products : Session::get('products') as $product)
                        @foreach($product->components as $componentP)
                            <tr id="linha-componente-{{$componentP->id}}" data-produtoid="{{$product->id}}"
                                style="display: none;">
                                <th scope="row">{{$componentP->id}}</th>
                                <td>{{$componentP->nome}}</td>
                                <td>{{$componentP->preco}}</td>
                                <td>{{$componentP->qtd}}</td>
                                <td>
                                    <button id="linha-componente-{{$componentP->id}}"
                                            class="deletar-material-tabela btn btn-danger mb-1" type="button">Delete
                                    </button>

                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endif
                </tbody>
                <!--FIM BODY DO COMPONENTE-->

            </table>


        </div>
    </div>

</div>

<!-- Ids -->
<div class="form-row">
    <div class="form-group col-12">
        <div id="ids">
            @if(!empty(session('mproductcriado')) || !empty($mproductedit))
                @php
                    $contador = 1;
                @endphp
                @foreach(!empty(session('mproductcriado')) ? Session::get('mproductcriado')->aluminums : $mproductedit->aluminums as $aluminumP)
                    <input type="number" class="id-material-aluminio linha-aluminio-{{$aluminumP->id}}-{{$contador++}}"
                           name="id_aluminio_[]"
                           value="{{$aluminumP->id}}" style="display: none;"/>
                @endforeach
                @foreach(!empty(session('mproductcriado')) ? Session::get('mproductcriado')->glasses : $mproductedit->glasses as $glassP)
                    <input id="{{ trim($glassP->cor . $glassP->tipo . $glassP->categoria_vidro_id) }}" type="number" class="id-material-vidro linha-vidro-{{$glassP->id}}"
                           name="id_vidro_[]"
                           value="{{$glassP->id}}" style="display: none;"/>
                @endforeach
                @foreach(!empty(session('mproductcriado')) ? Session::get('mproductcriado')->components : $mproductedit->components as $componentP)
                    <input type="number" class="id-material-componente linha-componente-{{$componentP->id}}-{{$contador++}}"
                           name="id_componente_[]"
                           value="{{$componentP->id}}" style="display: none;"/>
                @endforeach
            @endif
            {{--@if(!empty($products))--}}
            {{--@foreach($products   as $product)--}}
            {{--@foreach($product->aluminums as $aluminumP)--}}
            {{--<input type="number" class="id-material-aluminio linha-aluminio-{{$aluminumP->id}}"--}}
            {{--name="id_aluminio_{{$product->id}}[]"--}}
            {{--value="{{$aluminumP->id}}" style="display: none;"/>--}}
            {{--@endforeach--}}
            {{--@foreach($product->glasses as $glassP)--}}
            {{--<input type="number" class="id-material-vidro linha-vidro-{{$glassP->id}}"--}}
            {{--name="id_vidro_{{$product->id}}[]"--}}
            {{--value="{{$glassP->id}}" style="display: none;"/>--}}
            {{--@endforeach--}}
            {{--@foreach($product->components as $componentP)--}}
            {{--<input type="number" class="id-material-componente linha-componente-{{$componentP->id}}"--}}
            {{--name="id_componente_{{$product->id}}[]"--}}
            {{--value="{{$componentP->id}}" style="display: none;"/>--}}
            {{--@endforeach--}}
            {{--@endforeach--}}
            {{--@endif--}}
            @if(!empty(session('products')) || !empty($products))
                @foreach(!empty($products) ? $products : Session::get('products') as $product)
                    @foreach($product->aluminums as $aluminumP)
                        <input type="number" class="id-material-aluminio linha-aluminio-{{$aluminumP->id}}"
                               name="id_aluminio_{{$product->id}}[]"
                               value="{{$aluminumP->id}}" style="display: none;"/>
                    @endforeach
                    @foreach($product->glasses as $glassP)
                        <input id="{{ trim($glassP->cor . $glassP->tipo . $glassP->categoria_vidro_id . $product['id']) }}" type="number" class="id-material-vidro linha-vidro-{{$glassP->id}}"
                               name="id_vidro_{{$product->id}}[]"
                               value="{{$glassP->id}}" style="display: none;"/>
                    @endforeach
                    @foreach($product->components as $componentP)
                        <input type="number" class="id-material-componente linha-componente-{{$componentP->id}}"
                               name="id_componente_{{$product->id}}[]"
                               value="{{$componentP->id}}" style="display: none;"/>
                    @endforeach
                @endforeach

            @endif
        </div>
    </div>
</div>
<!-- FIM ids -->
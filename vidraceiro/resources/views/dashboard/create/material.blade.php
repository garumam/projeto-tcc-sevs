@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <button id="bt-{{$type}}-visible" class="btn btn-primary btn-custom" type="submit">Salvar</button>
            </div>

            <form class="formulario" method="POST" role="form"
                  action="{{ !empty($material) ?  route('materials.update',['id'=>$material->id, 'type' => $type]) : route('materials.store',['type'=>$type])}}">
                @if(!empty($material))
                    <input type="hidden" name="_method" value="PATCH">
                @endif
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-12 m-0">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    </div>

                    @if($type == 'glass')

                        <div class="form-group col-md-4">
                            <label for="categoria_vidro_id" class="obrigatorio">Categoria</label>
                            <select class="custom-select" id="categoria_vidro_id" name="categoria_vidro_id" required>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}"
                                    @if(!empty($material)){{ $material->category->id == $category->id ? 'selected' :''}} @endif>{{$category->nome}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="nome" class="obrigatorio">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                   value="{{$material->nome or old('nome')}}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="cor" class="obrigatorio">Cor</label>
                            <input type="text" class="form-control" id="cor" name="cor" placeholder="Cor"
                                   value="{{$material->cor or old('cor')}}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="tipo" class="obrigatorio">Tipo</label>
                            <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo"
                                   value="{{$material->tipo or old('tipo')}}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="espessura" class="obrigatorio">Espessura</label>
                            <input type="number" class="form-control" id="espessura" name="espessura" placeholder="Espessura"
                                   value="{{$material->espessura or old('espessura')}}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="preco">Preço</label>
                            <input type="number" step='0.001' class="form-control" id="preco" name="preco" placeholder="preço"
                                   value="{{$material->preco or old('preco')}}">
                        </div>

                    @endif


                    @if($type == 'aluminum')

                            <div class="form-group col-md-4">
                                <label for="categoria_aluminio_id" class="obrigatorio">Categoria</label>
                                <select class="custom-select" id="categoria_aluminio_id" name="categoria_aluminio_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}"
                                        @if(!empty($material)){{ $material->category->id == $category->id ? 'selected' :''}} @endif>{{$category->nome}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="perfil" class="obrigatorio">Perfil</label>
                                <input type="text" class="form-control" id="perfil" name="perfil" placeholder="Perfil"
                                       value="{{$material->perfil or old('perfil')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="descricao">Descrição</label>
                                <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição"
                                       value="{{$material->descricao or old('descricao')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="medida">Medida</label>
                                <input type="number" step='0.001' class="form-control" id="medida" name="medida" placeholder="Medida"
                                       value="{{$material->medida or old('medida')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="qtd" class="obrigatorio">Quantidade</label>
                                <input type="number" class="form-control" id="qtd" name="qtd" placeholder="Quantidade"
                                       value="{{$material->qtd or old('qtd')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="peso">Peso</label>
                                <input type="number" step='0.001' class="form-control" id="peso" name="peso" placeholder="Peso"
                                       value="{{$material->peso or old('peso')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="preco">Preço do KG</label>
                                <input type="number" step='0.001' class="form-control" id="preco" name="preco" placeholder="preço"
                                       value="{{$material->preco or old('preco')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="espessura_aluminio_id">Espessuras</label>
                                <select class="custom-select" id="espessura_aluminio_id" name="espessura">
                                    @foreach($espessuras as $key => $value)
                                    <option value="{{$key}}"
                                        @if(!empty($material)){{ $key == $material->espessura? 'selected' : ''}}@endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="tipo_medida" class="obrigatorio">Tipo de medida</label>
                                <select class="custom-select" id="tipo_medida" name="tipo_medida" required>
                                    <option value="largura"
                                        @if(!empty($material)){{ $material->tipo_medida == 'largura' ? 'selected' :''}} @endif>Largura</option>
                                    <option value="altura"
                                        @if(!empty($material)){{ $material->tipo_medida == 'altura' ? 'selected' :''}} @endif>Altura</option>
                                    <option value="mlinear"
                                        @if(!empty($material)){{ $material->tipo_medida == 'mlinear' ? 'selected' :''}} @endif>M Linear</option>
                                </select>
                            </div>


                    @endif


                    @if($type == 'component')

                            <div class="form-group col-md-4">
                                <label for="categoria_componente_id" class="obrigatorio">Categoria</label>
                                <select class="custom-select" id="categoria_componente_id" name="categoria_componente_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}"
                                        @if(!empty($material)){{ $material->category->id == $category->id ? 'selected' :''}} @endif>{{$category->nome}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="nome" class="obrigatorio">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                       value="{{$material->nome or old('nome')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="qtd">Quantidade</label>
                                <input type="number" class="form-control" id="qtd" name="qtd" placeholder="Quantidade"
                                       value="{{$material->qtd or old('qtd')}}">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="preco">Preço</label>
                                <input type="number" step='0.001' class="form-control" id="preco" name="preco" placeholder="preço"
                                       value="{{$material->preco or old('preco')}}">
                            </div>

                    @endif


                    <div class="form-group col-md-12">
                        <label for="select-providers-material">Selecione os fornecedores</label>

                        <select id="select-providers-material" class="form-control form-control-chosen" multiple name="providers[]" data-placeholder="Please select..." style="display:none;">
                            <option></option>
                            @foreach ($providers as $provider)
                                <option value="{{$provider->id}}"

                                @if(!empty($material->providers))
                                    @foreach($material->providers as $materialProvider)
                                        {{ $materialProvider->id == $provider->id ? 'selected' :''}}
                                            @endforeach
                                        @endif

                                >{{$provider->nome}}</option>

                            @endforeach
                        </select>


                    </div>

                </div>
                <div class="form-row" style="height: 150px"></div>
                <button id="bt-{{$type}}-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <button id="bt-{{$type}}-visible" class="btn btn-primary btn-custom" type="submit">Salvar</button>
            </div>

            <form class="formulario" method="POST" role="form"
                  action="{{ route('budgets.materials.update',['id'=>$material->id, 'type' => $type])}}">

                <input type="hidden" name="_method" value="PATCH">

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
                        @if(session('error'))
                             <div class="alert alert-danger">
                                    {{ session('error') }}
                             </div>
                        @endif

                    </div>

                    @if($type == 'glass')

                        <div class="form-group col-md-4">
                            <label for="category">Categoria</label>
                            <input type="text" class="form-control" id="category" placeholder="Nome"
                                   value="{{$material->category->nome or old('nome')}}" disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="nome" class="obrigatorio">Nome</label>
                            <input type="text" class="form-control" id="nome" placeholder="Nome"
                                   value="{{$material->nome or old('nome')}}" disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="cor" class="obrigatorio">Cor</label>
                            <input type="text" class="form-control" id="cor" placeholder="Cor"
                                   value="{{$material->cor or old('cor')}}" disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="tipo" class="obrigatorio">Tipo</label>
                            <input type="text" class="form-control" id="tipo" placeholder="Tipo"
                                   value="{{$material->tipo or old('tipo')}}" disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="espessura" class="obrigatorio">Espessura</label>
                            <input type="number" class="form-control" id="espessura" placeholder="Espessura"
                                   value="{{$material->espessura or old('espessura')}}" disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="preco">Preço</label>
                            <input type="number" step='0.001' class="form-control" id="preco" name="preco" placeholder="preço"
                                   value="{{$material->preco or old('preco')}}">
                        </div>

                    @endif


                    @if($type == 'aluminum')

                        <div class="form-group col-md-4">
                            <label for="category">Categoria</label>
                            <input type="text" class="form-control" id="category" placeholder="Categoria"
                                   value="{{$material->category->nome or old('category')}}" disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="perfil" class="obrigatorio">Perfil</label>
                            <input type="text" class="form-control" id="perfil" placeholder="Perfil"
                                   value="{{$material->perfil or old('perfil')}}" disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="descricao">Descrição</label>
                            <input type="text" class="form-control" id="descricao" placeholder="Descrição"
                                   value="{{$material->descricao or old('descricao')}}" disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="medida">Medida</label>
                            <input type="number" step='0.001' class="form-control" id="medida" placeholder="Medida"
                                   value="{{$material->medida or old('medida')}}" disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="qtd" class="obrigatorio">Quantidade</label>
                            <input type="number" class="form-control" id="qtd" name="qtd" placeholder="Quantidade"
                                   value="{{$material->qtd or old('qtd')}}" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="peso">Peso</label>
                            <input type="number" step='0.001' class="form-control" id="peso" placeholder="Peso"
                                   value="{{$material->peso or old('peso')}}" disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="preco">Preço do KG</label>
                            <input type="number" step='0.001' class="form-control" id="preco" name="preco" placeholder="preço"
                                   value="{{$material->preco or old('preco')}}">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="espessura">Espessura</label>
                            <input type="number" class="form-control" id="espessura" placeholder="espessura"
                                   value="{{$material->espessura or old('espessura')}}" disabled>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="tipo_medida">Tipo de medida</label>
                            <input type="text" class="form-control" id="tipo_medida" placeholder=""
                                   value="{{$material->tipo_medida or old('tipo_medida')}}" disabled>
                        </div>


                    @endif


                    @if($type == 'component')

                            <div class="form-group col-md-4">
                                <label for="category">Categoria</label>
                                <input type="text" class="form-control" id="category" placeholder="Categoria"
                                       value="{{$material->category->nome or old('category')}}" disabled>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="nome" class="obrigatorio">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="Nome"
                                       value="{{$material->nome or old('nome')}}" disabled>
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


                </div>

                <div class="form-row" style="height: 150px"></div>
                <button id="bt-{{$type}}-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
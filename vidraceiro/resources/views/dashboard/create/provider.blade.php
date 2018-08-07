@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{ $title }}</h4>
                <button id="bt-provider-visible" class="btn btn-primary btn-custom"
                        type="submit">{{empty($provider) ? 'Adicionar': 'Atualizar'}}</button>
            </div>

            <form class="formulario" method="POST" role="form"
                  action="{{ !empty($provider) ?  route('providers.update',['id'=>$provider->id]) :  route('providers.store')}}">
                @if(!empty($provider))
                    <input type="hidden" name="_method" value="PATCH">
                @endif
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-12">
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

                    <div class="form-group col-md-4">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                               value="{{ $provider->nome or old('nome')}}" placeholder="Nome">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="situacao">Situação</label>
                        <select class="custom-select" id="situacao" name="situacao" required>
                            <option value="ativo" @if(!empty($provider)){{$provider->situacao == 'ativo'? 'selected' :''}} @endif>Ativo</option>
                            <option value="desativado" @if(!empty($provider)){{$provider->situacao == 'desativado'? 'selected' :''}} @endif>Desativado</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="cnpj">CNPJ</label>
                        <input type="number" class="form-control" id="cnpj" name="cnpj"
                               value="{{ $provider->cnpj or old('cnpj')}}" placeholder="CNPJ">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="telefone">Telefone</label>
                        <input type="number" class="form-control" id="telefone" name="telefone"
                               value="{{ $provider->telefone or old('telefone')}}" placeholder="Telefone">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="celular">Celular</label>
                        <input type="number" class="form-control" id="celular" name="celular"
                               value="{{ $provider->celular or old('celular')}}" placeholder="Celular">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ $provider->email or old('email')}}" placeholder="E-mail">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="cep">Cep</label>
                        <input type="number" class="form-control" id="cep" name="cep"
                               value="{{ $provider->cep or old('cep')}}" placeholder="Cep" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="rua">Rua</label>
                        <input type="text" class="form-control" id="rua" name="rua"
                               value="{{ $provider->rua or old('rua')}}" placeholder="Rua">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="numero_endereco">N°</label>
                        <input type="number" class="form-control" id="numero_endereco" name="numero_endereco"
                               value="{{ $provider->numero_endereco or old('numero_endereco')}}" placeholder="N°">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="bairro">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro"
                               value="{{ $provider->bairro or old('bairro')}}" placeholder="Bairro">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="cidade">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade"
                               value="{{ $provider->cidade or old('cidade')}}" placeholder="Cidade">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="uf">UF</label>
                        <select class="custom-select" id="uf" name="uf" required>
                            @foreach ($states as $uf => $estado)
                                <option value="{{$uf}}"
                                @if(!empty($provider)){{ $provider->uf == $uf ? 'selected' :''}} @endif>{{$estado}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <button id="bt-provider-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
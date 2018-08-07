@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}} </h4>
                @if($company)
                    <button id="{{$company->id}}" onclick="deletar(this.id,'companies')"
                            class="btn btn-danger ml-auto mr-3" type="button">Deletar
                    </button>
                @endif
                <button id="bt-company-visible" class="btn btn-primary btn-custom" type="button">Adicionar</button>
            </div>

            <form class="formulario" method="POST" role="form"
                  action="{{($company) ?  route('companies.update',['id'=>$company->id]) :  route('companies.store')}}">
                @if($company)
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
                        <input type="text" class="form-control" name="nome" value="{{ $company->nome or old('nome')}}"
                               placeholder="Nome" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="endereco">Endereço</label>
                        <input type="text" class="form-control" name="endereco"
                               value="{{ $company->nome or old('endereco')}}" placeholder="Endereço:" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="cidade">Cidade</label>
                        <input type="text" class="form-control" name="cidade"
                               value="{{ $company->nome or old('cidade')}}" placeholder="Cidade" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="bairro">Bairro</label>
                        <input type="text" class="form-control" name="bairro"
                               value="{{ $company->nome or old('bairro') }}" placeholder="Bairro" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="uf">Selecione uma UF</label>
                        <select id="uf" class="custom-select" name="uf" required>
                            {{--<option value="" selected>Selecione...</option>--}}
                            @foreach ($states as $uf => $estado)
                                <option value="{{$uf}}"
                                @if($company){{ $company->uf == $uf ? 'selected' :''}} @endif>{{$estado}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="e-mail">E-mail</label>
                        <input type="email" class="form-control" name="email"
                               value="{{ $company->email or old('email') }}" placeholder="E-mail:" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="telefone">Telefone</label>
                        <input type="tel" class="form-control" name="telefone"
                               value="{{ $company->telefone or old('telefone') }}" placeholder="Telefone" required>
                    </div>

                </div>

                <button id="bt-company-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
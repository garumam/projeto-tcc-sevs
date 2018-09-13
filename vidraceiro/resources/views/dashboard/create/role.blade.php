@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <button id="bt-user-visible" class="btn btn-primary btn-custom"
                        type="button">{{empty($role) ? 'Adicionar': 'Atualizar'}}</button>
            </div>

            <form id="formulario-create-user" class="formulario" method="POST" role="form"
                  action="{{ Request::is('roles/*/edit') ? route('roles.update',['id'=> $role->id]) : route('roles.store') }}">
                @if(Request::is('roles/*/edit'))
                    <input type="hidden" name="_method" value="PATCH">
                @endif
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-12 m-0" id="formAlert">
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
                        <label for="nome" class="obrigatorio">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                               value="{{ $role->nome or old('nome') }}" placeholder="Nome" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="descricao" class="obrigatorio">Descrição</label>
                        <input type="text" class="form-control" id="descricao" name="descricao"
                               value="{{ $role->descricao or old('descricao') }}"
                               placeholder="Descricao" required>
                    </div>

                </div>
                <button id="bt-user-invisible" class="d-none" type="submit"></button>
            </form>
        </div>
    </div>
@endsection
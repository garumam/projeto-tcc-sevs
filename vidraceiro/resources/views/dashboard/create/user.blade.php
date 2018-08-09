@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <button id="bt-user-visible" class="btn btn-primary btn-custom"
                        type="button">{{empty($user) ? 'Adicionar': 'Atualizar'}}</button>
            </div>

            <form id="formulario-create-user" class="formulario" method="POST" role="form"
                  action="{{ Request::is('users/*/edit') ? route('users.update',['id'=> $user->id]) : route('users.store') }}">
                @if(Request::is('users/*/edit'))
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

                    <div class="form-group col-md-4">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ $user->name or old('name') }}" placeholder="Nome" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ $user->email or old('email') }}"
                               placeholder="E-mail" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Password" required>
                    </div>

                </div>
                <button id="bt-user-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
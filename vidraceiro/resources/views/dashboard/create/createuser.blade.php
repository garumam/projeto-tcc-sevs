@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
            </div>

            <form class="formulario" method="POST" role="form" action="{{route('createUser')}}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="E-mail" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Password" required>
                    </div>

                </div>
                <button class="btn btn-lg btn-primary btn-block btn-custom w-3277" type="submit">Enviar</button>

            </form>
        </div>
    </div>
@endsection
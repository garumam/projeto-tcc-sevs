@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <button id="bt-{{$tipo}}-visible" class="btn btn-primary btn-custom" type="submit">Salvar</button>
            </div>

            <form class="formulario" method="POST" role="form"
                  action="{{ !empty($material) ?  route('materials.update',['id'=>$material->id]) : route('materials.store')}}">
                @if(!empty($material))
                    <input type="hidden" name="_method" value="PATCH">
                @endif
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Password">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="password1">Password</label>
                        <input type="password1" class="form-control" id="password1" name="password1"
                               placeholder="Password">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome1" name="nome1" placeholder="Nome">
                    </div>


                </div>
                <button id="bt-{{$tipo}}-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <button id="bt-category-visible" class="btn btn-primary btn-custom" type="button">Adicionar</button>
            </div>

            <form class="formulario" method="POST" role="form" action="{{ route('categories.create') }}">
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="select-categoria">Selecione um material</label>
                        <select id="select-categoria" class="custom-select" required>
                            <option value="" selected>Selecione aqui...</option>
                            <option value="">Vidro</option>
                            <option value="">Aluminio</option>
                            <option value="">Componente</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="select-categoria">Selecione o grupo de imagens</label>
                        <select id="select-categoria" class="custom-select" required>
                            <option value="" selected>Selecione um grupo</option>
                            <option value="">Box diversos</option>
                            <option value="">Box padrão</option>
                            <option value="">ferragem 1000</option>
                            <option value="">ferragem 3000</option>
                            <option value="">Kit sacada</option>
                        </select>
                    </div>

                </div>

                <button id="bt-category-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
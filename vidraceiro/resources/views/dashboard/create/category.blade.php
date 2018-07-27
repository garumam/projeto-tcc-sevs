@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
            </div>

            <form class="formulario" method="POST" role="form">
                <div class="form-row">

                    <div class="form-group col-md-7">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome">
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-7">
                        <label for="tipo">Selecione o tipo</label>
                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                            <label class="btn btn-primary active w-33 p-1">
                                <input type="radio" name="options" id="option1" autocomplete="off" checked> Vidro
                            </label>
                            <label class="btn btn-primary w-33 p-1">
                                <input type="radio" name="options" id="option2" autocomplete="off"> Alumínio
                            </label>
                            <label class="btn btn-primary w-33 p-1">
                                <input type="radio" name="options" id="option3" autocomplete="off"> Componente
                            </label>
                        </div>
                    </div>

                </div>

                <div class="form-row mb-4">
                    <div class="form-group col-md-7">
                        <label for="select-categoria">Selecione o grupo de imagens</label>
                        <select id="select-categoria" class="custom-select">
                            <option value="0" selected>Selecione um grupo</option>
                            <option value="">Box diversos</option>
                            <option value="">Box padrão</option>
                            <option value="">ferragem 1000</option>
                            <option value="">ferragem 3000</option>
                            <option value="">Kit sacada</option>
                        </select>
                    </div>
                </div>

                <button class="btn btn-lg btn-primary btn-block btn-custom w-50" type="submit">Enviar</button>

            </form>
        </div>
    </div>
@endsection
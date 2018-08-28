@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
        <div class="card-material">
            <div class="widget">
                <h4 class="titulo">{{$totalusers}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de usuarios</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
        <div class="card-material">
            <div class="widget">
                <h4 class="titulo">{{$clients}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de clientes</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
        <div class="card-material">
            <div class="widget">
                <h4 class="titulo">{{$totalcategories}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de categorias</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
        <div class="card-material">
            <div class="widget">
                <h4 class="titulo">{{$totalproducts}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de produtos</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
        <div class="card-material">
            <div class="widget">
                <h4 class="titulo">{{$totalbudgets}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de orçamentos</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
        <div class="card-material">
            <div class="widget">
                <h4 class="titulo">{{$totalorders}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de ordens de serviço</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
        <div class="card-material">
            <div class="widget">
                <h4 class="titulo">{{$totalmaterials}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de Materiais</p>
            </div>
        </div>
    </div>
@endsection
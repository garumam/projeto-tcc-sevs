@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        @if(session('error'))
            <div class="alerta p-0">
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            </div>
        @endif
    </div>
    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material card-shadow-dashboard borda-roxa">
            <div class="widget">
                <h4 class="titulo">{{$totalusers}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de usuarios</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material card-shadow-dashboard borda-verde">
            <div class="widget">
                <h4 class="titulo">{{$clients}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de clientes</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material card-shadow-dashboard borda-vermelha">
            <div class="widget">
                <h4 class="titulo">{{$totalcategories}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de categorias</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material card-shadow-dashboard borda-azul">
            <div class="widget">
                <h4 class="titulo">{{$totalproducts}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de produtos</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material">
            <div class="widget">
                <h4 class="titulo">{{$totalbudgets}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de orçamentos</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material">
            <div class="widget">
                <h4 class="titulo">{{$totalorders}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de ordens de serviço</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material">
            <div class="widget">
                <h4 class="titulo">{{$totalmaterials}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de Materiais</p>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material">

            <div id="accordion">
                <div class="card-material card-shadow-dashboard m-0 h-auto">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Ordens de serviço em aberto
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show tabelasrestaurar" data-tipo="ordens" aria-labelledby="headingOne">
                        <div class="card-body">

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginateordens">Mostrar</label>
                                    <select id="paginateordens" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('home')}}?ordens=1&search='+$('#searchordens').val()+'&paginate='+$('#paginateordens').val(),'ordens')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="searchordens">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('home')}}?ordens=1&search='+$('#searchordens').val()+'&paginate='+$('#paginateordens').val(),'ordens')"
                                           value="{{ old('search') }}" id="searchordens" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="ordens">
                                @include('dashboard.list.tables.table-order')
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-material card-shadow-dashboard m-0 h-auto">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Orçamentos aprovados para abrir ordem de serviço
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse show tabelasrestaurar" data-tipo="orcamentos" aria-labelledby="headingTwo">
                        <div class="card-body">

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginateorcamentos">Mostrar</label>
                                    <select id="paginateorcamentos" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('home')}}?orcamentos=1&search='+$('#searchorcamentos').val()+'&paginate='+$('#paginateorcamentos').val(),'orcamentos')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="searchorcamentos">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('home')}}?orcamentos=1&search='+$('#searchorcamentos').val()+'&paginate='+$('#paginateorcamentos').val(),'orcamentos')"
                                           value="{{ old('search') }}" id="searchorcamentos" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="orcamentos">
                                @include('dashboard.list.tables.table-budget')
                            </div>

                        </div>
                    </div>
                </div>
                {{--<div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Ordens de serviço excluídas
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse tabelasrestaurar" data-tipo="ordens" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">



                        </div>
                    </div>
                </div>--}}

            </div>

        </div>
    </div>
@endsection
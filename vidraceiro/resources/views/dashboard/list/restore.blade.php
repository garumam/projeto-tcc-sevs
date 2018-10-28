@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card text-dark">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
            </div>

            @if(session('success'))
                <div class="alerta">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @elseif(session('error'))
                <div class="alerta">
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                </div>
            @else
                @foreach($errors->all() as $error)
                    <div class="alerta">
                        <div class="alert alert-danger m-0">
                            {{ $error }}
                        </div>
                    </div>
                @endforeach

            @endif

            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Clientes excluídos
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show tabelasrestaurar" data-tipo="clientes" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginateclientes">Mostrar</label>
                                    <select id="paginateclientes" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('restore')}}?clientes=1&search='+$('#searchclientes').val()+'&paginate='+$('#paginateclientes').val(),'clientes')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="searchclientes">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('restore')}}?clientes=1&search='+$('#searchclientes').val()+'&paginate='+$('#paginateclientes').val(),'clientes')"
                                           value="{{ old('search') }}" id="searchclientes" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="clientes">
                                @include('dashboard.list.tables.table-client')
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Orçamentos excluídos
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse tabelasrestaurar" data-tipo="orcamentos" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginateorcamentos">Mostrar</label>
                                    <select id="paginateorcamentos" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('restore')}}?orcamentos=1&search='+$('#searchorcamentos').val()+'&paginate='+$('#paginateorcamentos').val(),'orcamentos')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="searchorcamentos">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('restore')}}?orcamentos=1&search='+$('#searchorcamentos').val()+'&paginate='+$('#paginateorcamentos').val(),'orcamentos')"
                                           value="{{ old('search') }}" id="searchorcamentos" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="orcamentos">
                                @include('dashboard.list.tables.table-budget')
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Ordens de serviço excluídas
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse tabelasrestaurar" data-tipo="ordens" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginateordens">Mostrar</label>
                                    <select id="paginateordens" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('restore')}}?ordens=1&search='+$('#searchordens').val()+'&paginate='+$('#paginateordens').val(),'ordens')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="searchordens">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('restore')}}?ordens=1&search='+$('#searchordens').val()+'&paginate='+$('#paginateordens').val(),'ordens')"
                                           value="{{ old('search') }}" id="searchordens" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="ordens">
                                @include('dashboard.list.tables.table-order')
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFour">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Modelos de produto excluídos
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFour" class="collapse tabelasrestaurar" data-tipo="mprodutos" aria-labelledby="headingFour" data-parent="#accordion">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFive">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Vidros excluídos
                            </button>
                        </h5>
                    </div>
                    <div id="collapseFive" class="collapse tabelasrestaurar" data-tipo="vidros" aria-labelledby="headingFive" data-parent="#accordion">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingSix">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Alumínios excluídos
                            </button>
                        </h5>
                    </div>
                    <div id="collapseSix" class="collapse tabelasrestaurar" data-tipo="aluminios" aria-labelledby="headingSix" data-parent="#accordion">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingSeven">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                Componentes excluídos
                            </button>
                        </h5>
                    </div>
                    <div id="collapseSeven" class="collapse tabelasrestaurar" data-tipo="componentes" aria-labelledby="headingSeven" data-parent="#accordion">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingEight">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                Categorias excluídas
                            </button>
                        </h5>
                    </div>
                    <div id="collapseEight" class="collapse tabelasrestaurar" data-tipo="categorias" aria-labelledby="headingEight" data-parent="#accordion">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingNine">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                Movimentações financeiras excluídas
                            </button>
                        </h5>
                    </div>
                    <div id="collapseNine" class="collapse tabelasrestaurar" data-tipo="financeiro" aria-labelledby="headingNine" data-parent="#accordion">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTen">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                Usuários excluídos
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTen" class="collapse tabelasrestaurar" data-tipo="usuarios" aria-labelledby="headingTen" data-parent="#accordion">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
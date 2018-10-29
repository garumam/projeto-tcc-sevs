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

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginatemprodutos">Mostrar</label>
                                    <select id="paginatemprodutos" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('restore')}}?mprodutos=1&search='+$('#searchmprodutos').val()+'&paginate='+$('#paginatemprodutos').val(),'mprodutos')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="searchmprodutos">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('restore')}}?mprodutos=1&search='+$('#searchmprodutos').val()+'&paginate='+$('#paginatemprodutos').val(),'mprodutos')"
                                           value="{{ old('search') }}" id="searchmprodutos" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="mprodutos">
                                @include('dashboard.list.tables.table-mproduct')
                            </div>

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

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginatevidros">Mostrar</label>
                                    <select id="paginatevidros" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('restore')}}?vidros=1&search='+$('#searchvidros').val()+'&paginate='+$('#paginatevidros').val(),'vidros')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="searchvidros">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('restore')}}?vidros=1&search='+$('#searchvidros').val()+'&paginate='+$('#paginatevidros').val(),'vidros')"
                                           value="{{ old('searchvidros') }}" id="searchvidros" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="vidros">
                                @include('dashboard.list.tables.table-glass')
                            </div>

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

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginatealuminios">Mostrar</label>
                                    <select id="paginatealuminios" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('restore')}}?aluminios=1&search='+$('#searchaluminios').val()+'&paginate='+$('#paginatealuminios').val(),'aluminios')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="search">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('restore')}}?aluminios=1&search='+$('#searchaluminios').val()+'&paginate='+$('#paginatealuminios').val(),'aluminios')"
                                           value="{{ old('search') }}" id="searchaluminios" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="aluminios">
                                @include('dashboard.list.tables.table-aluminum')
                            </div>

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

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginatecomponentes">Mostrar</label>
                                    <select id="paginatecomponentes" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('restore')}}?componentes=1&search='+$('#searchcomponentes').val()+'&paginate='+$('#paginatecomponentes').val(),'componentes')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="search">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('restore')}}?componentes=1&search='+$('#searchcomponentes').val()+'&paginate='+$('#paginatecomponentes').val(),'componentes')"
                                           value="{{ old('search') }}" id="searchcomponentes" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="componentes">
                                @include('dashboard.list.tables.table-component')
                            </div>

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

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginatecategorias">Mostrar</label>
                                    <select id="paginatecategorias" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('restore')}}?categorias=1&search='+$('#searchcategorias').val()+'&paginate='+$('#paginatecategorias').val(),'categorias')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="searchcategorias">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('restore')}}?categorias=1&search='+$('#searchcategorias').val()+'&paginate='+$('#paginatecategorias').val(),'categorias')"
                                           value="{{ old('search') }}" id="searchcategorias" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="categorias">
                                @include('dashboard.list.tables.table-category')
                            </div>

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

                            <div class="form-row col-12 m-0 formulario px-0 justify-content-between">
                                <div class="form-group col-12 col-sm-12 col-md-6 col-lg-2">
                                    <label for="paginatefinanceiro">Mostrar</label>
                                    <select id="paginatefinanceiro" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('restore')}}?financeiro=1&search='+$('#searchfinanceiro').val()+'&paginate='+$('#paginatefinanceiro').val()+'&period='+$('#period').val(),'financeiro')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-12 col-md-6 col-lg-2">
                                    <label for="period">Período</label>
                                    <select id="period" name="period" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('restore')}}?financeiro=1&search='+$('#searchfinanceiro').val()+'&paginate='+$('#paginatefinanceiro').val()+'&period='+$('#period').val(),'financeiro')">
                                        <option value="hoje" selected>Hoje</option>
                                        <option value="semana">Últimos 7 dias</option>
                                        <option value="mes">Últimos 30 dias</option>
                                        <option value="semestre">Últimos 180 dias</option>
                                        <option value="anual">Últimos 360 dias</option>
                                        <option value="tudo">Todos</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-12 col-md-6 col-lg-4">
                                    <label for="searchfinanceiro">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('restore')}}?financeiro=1&search='+$('#searchfinanceiro').val()+'&paginate='+$('#paginatefinanceiro').val()+'&period='+$('#period').val(),'financeiro')"
                                           value="{{ old('search') }}" id="searchfinanceiro" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-1" id="financeiro">
                                @include('dashboard.list.tables.table-financial')
                            </div>

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

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginateusuarios">Mostrar</label>
                                    <select id="paginateusuarios" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('restore')}}?usuarios=1&search='+$('#searchusuarios').val()+'&paginate='+$('#paginateusuarios').val(),'usuarios')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="searchusuarios">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('restore')}}?usuarios=1&search='+$('#searchusuarios').val()+'&paginate='+$('#paginateusuarios').val(),'usuarios')"
                                           value="{{ old('search') }}" id="searchusuarios" name="search" placeholder="Pesquisar">
                                </div>
                            </div>
                            <div class="table-responsive text-dark p-2" id="usuarios">
                                @include('dashboard.list.tables.table-user')
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
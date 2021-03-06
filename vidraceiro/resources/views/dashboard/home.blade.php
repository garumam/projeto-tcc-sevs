@extends('layouts.app')
@section('content')
    @if(session('error'))
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="alerta p-0">
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            </div>
        </div>
    @endif
    @can('gerenciamento') 
    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material card-shadow-dashboard borda-roxa">
            <div class="widget">
                <h4 class="titulo" style="color:#716ACA;">{{$totalusers??0}}
                    <small><i class="fas fa-arrow-up" style="color:#716ACA;"></i></small>
                </h4>
                <p class="subtitulo">Total de Usuarios</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material card-shadow-dashboard borda-verde">
            <div class="widget">
                <h4 class="titulo text-success">{{$clients??0}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de Clientes</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material card-shadow-dashboard borda-vermelha">
            <div class="widget">
                <h4 class="titulo" style="color: #c82333;">{{$totalsales??0}}
                    <small><i class="fas fa-arrow-up text-danger"></i></small>
                </h4>
                <p class="subtitulo">Total de Vendas</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material card-shadow-dashboard borda-azul">
            <div class="widget">
                <h4 class="titulo" style="color: #36A3F7;">{{$totalreceita??0}}
                    <small><i class="fas fa-arrow-up" style="color: #36A3F7;"></i></small>
                </h4>
                <p class="subtitulo">Total Receitas</p>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material card-shadow-dashboard borda-roxa">
            <div class="widget">
                <h4 class="titulo" style="color:#716ACA;">{{$totalbudgets??0}}
                    <small><i class="fas fa-arrow-up" style="color:#716ACA;"></i></small>
                </h4>
                <p class="subtitulo">Total de Orçamentos</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material card-shadow-dashboard borda-verde">
            <div class="widget">
                <h4 class="titulo text-success">{{$totalorders??0}}
                    <small><i class="fas fa-arrow-up text-success"></i></small>
                </h4>
                <p class="subtitulo">Total de Ordens de Serviço</p>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material card-shadow-dashboard borda-vermelha">
            <div class="widget">
                <h4 class="titulo" style="color: #c82333;">{{$totaldespesa??0}}
                    <small><i class="fas fa-arrow-up text-danger"></i></small>
                </h4>
                <p class="subtitulo">Total de Despesas</p>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-4 col-md-4 col-lg-3">
        <div class="card-material card-shadow-dashboard borda-azul">
            <div class="widget">
                <h4 class="titulo" style="color: #36A3F7;">{{$totalproviders??0}}
                    <small><i class="fas fa-arrow-up" style="color: #36A3F7;"></i></small>
                </h4>
                <p class="subtitulo">Total de Fornecedores</p>
            </div>
        </div>
    </div>



    <div class="col-12">
        <div class="card-material card-shadow-dashboard">
            <div class="card-header">
                <h4>Vendas</h4>
            </div>
            <div class="chart-container" style="padding: .5rem; margin-bottom: 1rem;">
                <canvas id="vendas"></canvas>
            </div>

        </div>
    </div>

    <div class="col-12">
        <div class="card-material card-shadow-dashboard">
            <div class="card-header">
                <h4>Produtos mais vendidos (limite de 10)</h4>
            </div>
            <div class="chart-container" style="padding: .5rem; margin-bottom: 1rem;">
                <canvas id="produtos"></canvas>
            </div>

        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
        <div class="card-material card-shadow-dashboard">
            <div class="card-header">
                <h4>Financeiro</h4>
            </div>
            <div class="chart-container" style="padding: .5rem; margin-bottom: 1rem;">
                <canvas id="financeiro"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
        <div class="card-material card-shadow-dashboard">
            <div class="card-header">
                <h4>Ordens de serviço</h4>
            </div>
            <div class="chart-container" style="padding: .5rem; margin-bottom: 1rem;">
                <canvas id="ordensgraph"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
        <div class="card-material card-shadow-dashboard">
            <div class="card-header">
                <h4>Clientes</h4>
            </div>
            <div class="chart-container" style="padding: .5rem; margin-bottom: 1rem;">
                <canvas id="clientes"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
        <div class="card-material card-shadow-dashboard">
            <div class="card-header">
                <h4>Orçamentos</h4>
            </div>
            <div class="chart-container" style="padding: .5rem; margin-bottom: 1rem;">
                <canvas id="orcamentosgraph"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card-material card-shadow-dashboard">
            <div class="card-header">
                <h4>Previsão do fluxo de caixa futuro</h4>
            </div>
            <div class="chart-container" style="padding: .5rem; margin-bottom: 1rem;">
                <canvas id="caixafuturo"></canvas>
            </div>

        </div>
    </div>

    @endcan
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">

        <div class="card-material card-shadow-dashboard">

            <div id="accordion">
                @can('os_listar') 
                <div class="card-material card-shadow-dashboard m-0 h-auto">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0 d-flex justify-content-between">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                Ordens de serviço em aberto
                            </button>
                            <span class="notificacao"><span>{{count($ordersOpen)}}</span></span>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse tabelasrestaurar" data-tipo="ordens"
                         aria-labelledby="headingOne">
                        <div class="card-body p-0">

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
                                           value="{{ old('search') }}" id="searchordens" name="search"
                                           placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="ordens">
                                @include('dashboard.list.tables.table-order')
                            </div>

                        </div>
                    </div>
                </div>
                @endcan
                @can('orcamento_listar')
                <div class="card-material card-shadow-dashboard m-0 h-auto">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0 d-flex justify-content-between horizontal-scroll">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                    aria-expanded="false" aria-controls="collapseTwo">
                                Orçamentos aprovados para abrir ordem de serviço
                            </button>
                            <span class="notificacao"><span>{{$budgetsOpen->total()}}</span></span>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse tabelasrestaurar" data-tipo="orcamentos"
                         aria-labelledby="headingTwo">
                        <div class="card-body p-0">

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
                                           value="{{ old('search') }}" id="searchorcamentos" name="search"
                                           placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="orcamentos">
                                @include('dashboard.list.tables.table-budget')
                            </div>

                        </div>
                    </div>
                </div>
                @endcan
            </div>

        </div>
    </div>
@endsection

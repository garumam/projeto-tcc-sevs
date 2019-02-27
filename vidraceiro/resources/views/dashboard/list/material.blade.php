@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <!-- Inicio tab de Produto-->
            
                <div class="nav nav-tabs" id="nav-tab">
                    @for($i = 0; $i < count($titulotabs); $i++)
                        @if($i == 0)
                            <a class="tabs-material nav-item nav-link current"
                                data-id="{{lcfirst($titulotabs[$i])}}"
                                data-tab="nav-{{$titulotabs[$i]}}-tab">{{$titulotabs[$i]}}</a>
                        @else
                            <a class="tabs-material nav-item nav-link"
                                data-id="{{lcfirst($titulotabs[$i])}}"
                                data-tab="nav-{{$titulotabs[$i]}}-tab">{{$titulotabs[$i]}}</a>
                
                        @endif
                    @endfor
                    <div class="topo-tab">
                        <a id="bt-material" class="btn-link" href="">
                            <button class="btn btn-primary btn-block btn-custom" type="submit">Adicionar</button>
                        </a>
                    </div>
                </div>

            
            <!-- Fim tab de Produto-->

            <!--Inicio Conteudo de cada tab -->
            
                <div id="nav-{{$titulotabs[0]}}-tab" class="tab-content current">
                <div class="formulario px-0">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <div class="topo">
                                <h4 class="titulo">{{$titulotabs[0]}}</h4>
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

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginatevidros">Mostrar</label>
                                    <select id="paginatevidros" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('materials')}}?vidros=1&search='+$('#searchvidros').val()+'&paginate='+$('#paginatevidros').val(),'vidros')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="searchvidros">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('materials')}}?vidros=1&search='+$('#searchvidros').val()+'&paginate='+$('#paginatevidros').val(),'vidros')"
                                           value="{{ old('searchvidros') }}" id="searchvidros" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="vidros">
                                @include('dashboard.list.tables.table-glass')
                            </div>
                        </div>
                    </div>
                </div>
                </div>

            
                <div id="nav-{{$titulotabs[1]}}-tab" class="tab-content">
                <div class="formulario px-0">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <div class="topo">
                                <h4 class="titulo">{{$titulotabs[1]}}</h4>
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

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginatealuminios">Mostrar</label>
                                    <select id="paginatealuminios" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('materials')}}?aluminios=1&search='+$('#searchaluminios').val()+'&paginate='+$('#paginatealuminios').val(),'aluminios')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="search">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('materials')}}?aluminios=1&search='+$('#searchaluminios').val()+'&paginate='+$('#paginatealuminios').val(),'aluminios')"
                                           value="{{ old('search') }}" id="searchaluminios" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="aluminios">
                                @include('dashboard.list.tables.table-aluminum')
                            </div>
                        </div>

                    </div>

                </div>
                </div>

            
                <div id="nav-{{$titulotabs[2]}}-tab" class="tab-content">
                <div class="formulario px-0">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <div class="topo">
                                <h4 class="titulo">{{$titulotabs[2]}}</h4>
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

                            <div class="form-row formulario pb-0 justify-content-between">
                                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                    <label for="paginatecomponentes">Mostrar</label>
                                    <select id="paginatecomponentes" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('materials')}}?componentes=1&search='+$('#searchcomponentes').val()+'&paginate='+$('#paginatecomponentes').val(),'componentes')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                    <label for="search">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('materials')}}?componentes=1&search='+$('#searchcomponentes').val()+'&paginate='+$('#paginatecomponentes').val(),'componentes')"
                                           value="{{ old('search') }}" id="searchcomponentes" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="componentes">
                                @include('dashboard.list.tables.table-component')
                            </div>
                        </div>

                    </div>
                </div>
                </div>
            
            <!--Fim Conteudo de cada tab -->
        </div>
    </div>
@endsection

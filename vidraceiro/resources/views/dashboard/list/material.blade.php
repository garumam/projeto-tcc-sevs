@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <!-- Inicio tab de Produto-->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @for($i = 0; $i < count($titulotabs); $i++)
                        @if($i == 0)
                            <a class="nav-item nav-link active noborder-left" id="nav-{{$titulotabs[$i]}}-tab"
                               data-id="{{lcfirst($titulotabs[$i])}}"
                               data-toggle="tab"
                               href="#nav-{{$titulotabs[$i]}}" role="tab"
                               aria-controls="nav-{{$titulotabs[$i]}}"
                               aria-selected="true">{{$titulotabs[$i]}}</a>
                        @else
                            <a class="nav-item nav-link" id="nav-{{$titulotabs[$i]}}-tab"
                               data-id="{{lcfirst($titulotabs[$i])}}"
                               data-toggle="tab"
                               href="#nav-{{$titulotabs[$i]}}" role="tab"
                               aria-controls="nav-{{$titulotabs[$i]}}"
                               aria-selected="false">{{$titulotabs[$i]}}</a>
                        @endif
                    @endfor
                    <div class="topo-tab">
                        <a id="bt-material" class="btn-link" href="">
                            <button class="btn btn-primary btn-block btn-custom" type="submit">Adicionar</button>
                        </a>
                    </div>
                </div>

            </nav>
            <!-- Fim tab de Produto-->

            <!--Inicio Conteudo de cada tab -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-{{$titulotabs[0]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[0]}}-tab">

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
                                    <label for="search">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('materials')}}?vidros=1&search='+$('#searchvidros').val()+'&paginate='+$('#paginatevidros').val(),'vidros')"
                                           value="{{ old('search') }}" id="searchvidros" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-2" id="vidros">
                                @include('dashboard.list.tables.table-glass')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="nav-{{$titulotabs[1]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[1]}}-tab">

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

                <div class="tab-pane fade" id="nav-{{$titulotabs[2]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[2]}}-tab">

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

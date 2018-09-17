@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <!-- Inicio tab de Material-->
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
                </div>

            </nav>
            <!-- Fim tab de Material-->

            <!--Inicio Conteudo de cada tab -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-{{$titulotabs[0]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[0]}}-tab">
                    <form class="formulario" method="POST" role="form"
                          action="{{route('storage.update',['tab'=>'vidro'])}}">
                        <input type="hidden" name="_method" value="PATCH">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-12">

                                @if(session('success'))
                                    <div class="alerta p-0">
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @elseif(session('error'))
                                    <div class="alerta p-0">
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif
                                    @foreach($errors->all() as $error)
                                        <div class="alert alert-danger">
                                            {{ $error }}
                                        </div>
                                    @endforeach

                            </div>

                            <div class="form-group col-md-4">
                                <label for="select-vidro" class="obrigatorio text-dark">Vidros</label>
                                <select id="select-vidro" class="form-control form-control-chosen" name="storage_vidro_id" data-placeholder="Selecione um vidro" style="display: none;">
                                    <option></option>
                                    @foreach($glasses as $glass)
                                        <option value="{{$glass->storage->id}}">{{$glass->nome .' '. $glass->tipo}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="select-operacao" class="obrigatorio">Operação</label>
                                <select id="select-operacao" name="operacao" class="custom-select" required>
                                    <option value="entrada" selected>Entrada</option>
                                    <option value="retirada">Retirada</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="m2" class="obrigatorio">M²</label>
                                <input type="number" class="form-control" id="m2" name="m2"
                                       placeholder="0" required>
                            </div>
                            <div class="form-group col-md-2 align-self-end">
                                <button class="btn btn-primary btn-block btn-custom" type="submit">Efetuar</button>
                            </div>

                            <div class="form-group col-12 mt-2">

                                <div class="form-row formulario p-0 justify-content-between">
                                    <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                        <label for="paginatevidros">Mostrar</label>
                                        <select id="paginatevidros" name="paginate" class="custom-select"
                                                onchange="ajaxPesquisaLoad('{{url('storage')}}?vidros=1&search='+$('#searchvidros').val()+'&paginate='+$('#paginatevidros').val(),'vidros')">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                        <label for="search">Pesquisar</label>
                                        <input type="text" class="form-control"
                                               onkeyup="ajaxPesquisaLoad('{{url('storage')}}?vidros=1&search='+$('#searchvidros').val()+'&paginate='+$('#paginatevidros').val(),'vidros')"
                                               value="{{ old('search') }}" id="searchvidros" name="search" placeholder="Pesquisar">
                                    </div>
                                </div>

                                <div class="table-responsive text-dark" id="vidros">
                                    @include('dashboard.list.tables.table-storage-glass')
                                </div>

                            </div>


                        </div>
                    </form>


                </div>


                <div class="tab-pane fade" id="nav-{{$titulotabs[1]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[1]}}-tab">


                    <form class="formulario" method="POST" role="form"
                          action="{{route('storage.update',['tab'=>'aluminio'])}}">
                        <input type="hidden" name="_method" value="PATCH">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-12">

                                @if(session('success'))
                                    <div class="alerta p-0">
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @elseif(session('error'))
                                    <div class="alerta p-0">
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif
                                @foreach($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                    </div>
                                @endforeach

                            </div>

                            <div class="form-group col-md-4">
                                <label for="select-aluminio" class="obrigatorio text-dark">Alumínios</label>
                                <select id="select-aluminio" class="form-control form-control-chosen" name="storage_aluminio_id" data-placeholder="Selecione um aluminio" style="display: none;">
                                    <option></option>
                                    @foreach($aluminums as $aluminum)
                                        <option value="{{$aluminum->storage->id}}">{{$aluminum->perfil}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="select-operacao" class="obrigatorio">Operação</label>
                                <select id="select-operacao" name="operacao" class="custom-select" required>
                                    <option value="entrada" selected>Entrada</option>
                                    <option value="retirada">Retirada</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="qtd" class="obrigatorio">Qtd</label>
                                <input type="number" class="form-control" id="qtd" name="qtd"
                                       placeholder="0" required>
                            </div>
                            <div class="form-group col-md-2 align-self-end">
                                <button class="btn btn-primary btn-block btn-custom" type="submit">Efetuar</button>
                            </div>

                            <div class="form-group col-12 mt-2">

                                <div class="form-row formulario p-0 justify-content-between">
                                    <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                        <label for="paginatealuminios">Mostrar</label>
                                        <select id="paginatealuminios" name="paginate" class="custom-select"
                                                onchange="ajaxPesquisaLoad('{{url('storage')}}?aluminios=1&search='+$('#searchaluminios').val()+'&paginate='+$('#paginatealuminios').val(),'aluminios')">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                        <label for="search">Pesquisar</label>
                                        <input type="text" class="form-control"
                                               onkeyup="ajaxPesquisaLoad('{{url('storage')}}?aluminios=1&search='+$('#searchaluminios').val()+'&paginate='+$('#paginatealuminios').val(),'aluminios')"
                                               value="{{ old('search') }}" id="searchaluminios" name="search" placeholder="Pesquisar">
                                    </div>
                                </div>

                                <div class="table-responsive text-dark" id="aluminios">
                                    @include('dashboard.list.tables.table-storage-aluminum')
                                </div>

                            </div>


                        </div>
                    </form>

                </div>

                <div class="tab-pane fade" id="nav-{{$titulotabs[2]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[2]}}-tab">


                    <form class="formulario" method="POST" role="form"
                          action="{{route('storage.update',['tab'=>'componente'])}}">
                        <input type="hidden" name="_method" value="PATCH">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-12">

                                @if(session('success'))
                                    <div class="alerta p-0">
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @elseif(session('error'))
                                    <div class="alerta p-0">
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif
                                @foreach($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                    </div>
                                @endforeach

                            </div>

                            <div class="form-group col-md-4">
                                <label for="select-componente" class="obrigatorio text-dark">Componentes</label>
                                <select id="select-componente" class="form-control form-control-chosen" name="storage_componente_id" data-placeholder="Selecione um componente" style="display: none;">
                                    <option></option>
                                    @foreach($components as $component)
                                        <option value="{{$component->storage->id}}">{{$component->nome}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="select-operacao" class="obrigatorio">Operação</label>
                                <select id="select-operacao" name="operacao" class="custom-select" required>
                                    <option value="entrada" selected>Entrada</option>
                                    <option value="retirada">Retirada</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="qtd" class="obrigatorio">Qtd</label>
                                <input type="number" class="form-control" id="qtd" name="qtd"
                                       placeholder="0" required>
                            </div>
                            <div class="form-group col-md-2 align-self-end">
                                <button class="btn btn-primary btn-block btn-custom" type="submit">Efetuar</button>
                            </div>

                            <div class="form-group col-12 mt-2">

                                <div class="form-row formulario p-0 justify-content-between">
                                    <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                                        <label for="paginatecomponentes">Mostrar</label>
                                        <select id="paginatecomponentes" name="paginate" class="custom-select"
                                                onchange="ajaxPesquisaLoad('{{url('storage')}}?componentes=1&search='+$('#searchcomponentes').val()+'&paginate='+$('#paginatecomponentes').val(),'componentes')">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                                        <label for="search">Pesquisar</label>
                                        <input type="text" class="form-control"
                                               onkeyup="ajaxPesquisaLoad('{{url('storage')}}?componentes=1&search='+$('#searchcomponentes').val()+'&paginate='+$('#paginatecomponentes').val(),'componentes')"
                                               value="{{ old('search') }}" id="searchcomponentes" name="search" placeholder="Pesquisar">
                                    </div>
                                </div>

                                <div class="table-responsive text-dark" id="componentes">
                                    @include('dashboard.list.tables.table-storage-component')
                                </div>

                            </div>

                        </div>
                    </form>
                </div>

            </div>
            <!--Inicio Conteudo de cada tab -->


        </div>
    </div>
@endsection

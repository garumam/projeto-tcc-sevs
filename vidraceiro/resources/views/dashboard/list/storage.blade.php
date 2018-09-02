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
                               data-toggle="tab"
                               href="#nav-{{$titulotabs[$i]}}" role="tab"
                               aria-controls="nav-{{$titulotabs[$i]}}"
                               aria-selected="true">{{$titulotabs[$i]}}</a>
                        @else
                            <a class="nav-item nav-link" id="nav-{{$titulotabs[$i]}}-tab"
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
                                <label for="m2" class="obrigatorio">Qtd m²</label>
                                <input type="number" class="form-control" id="m2" name="m2"
                                       placeholder="0" required>
                            </div>
                            <div class="form-group col-md-2 align-self-end">
                                <button class="btn btn-primary btn-block btn-custom" type="submit">Efetuar</button>
                            </div>


                            <div class="form-group col-12">
                                <div class="topo">
                                    <h4 class="titulo">{{$titulotabs[0]}}</h4>
                                </div>

                                <div class="table-responsive text-dark p-2">
                                    @include('layouts.htmltablesearch')
                                    <table class="table table-hover search-table" style="margin: 6px 0px 6px 0px;">
                                        <thead>
                                        <!--INICIO HEAD DO VIDRO-->
                                        <tr class="tabela-vidro">
                                            <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
                                            <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Nome</th>
                                            <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Categoria</th>
                                            <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">M² em estoque</th>
                                        </tr>
                                        <!--FIM HEAD DO VIDRO-->
                                        </thead>
                                        <tbody>
                                        <!--INICIO BODY DO VIDRO-->
                                        @foreach($glasses as $glass)
                                            <tr class="tabela-vidro">
                                                <th scope="row">{{ $glass->id }}</th>
                                                <td>{{ $glass->nome }}</td>
                                                <td>{{ $glass->category->nome }}</td>
                                                <td>{{ $glass->storage->metros_quadrados or '0' }}</td>
                                            </tr>
                                        @endforeach
                                        <!--FIM BODY DO VIDRO-->

                                        </tbody>
                                    </table>

                                    @include('layouts.htmlpaginationtable')

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

                                <div class="table-responsive text-dark p-2">
                                    <table class="table table-hover search-table">
                                        <thead>


                                        <!--INICIO HEAD DO ALUMINIO-->
                                        <tr class="tabela-aluminio">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Perfil</th>
                                            <th class="noborder" scope="col">Categoria</th>
                                            <th class="noborder" scope="col">Qtd em estoque</th>
                                        </tr>
                                        <!--FIM HEAD DO ALUMINIO-->


                                        </thead>
                                        <tbody>

                                        <!--INICIO BODY DO ALUMINIO-->
                                        @foreach($aluminums as $aluminum)
                                            <tr class="tabela-aluminio">
                                                <th scope="row">{{ $aluminum->id }}</th>
                                                <td>{{ $aluminum->perfil }}</td>
                                                <td>{{ $aluminum->category->nome }} {{ $aluminum->espessura ? $aluminum->espessura.'mm' : ''}}</td>
                                                <td>{{ $aluminum->storage->qtd or '0' }}</td>
                                            </tr>
                                        @endforeach
                                        <!--FIM BODY DO ALUMINIO-->

                                        </tbody>
                                    </table>


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

                            <div class="table-responsive text-dark p-2">
                                <table class="table table-hover search-table">
                                    <thead>

                                    <!--INICIO HEAD DO COMPONENTE-->
                                    <tr class="tabela-componente">
                                        <th class="noborder" scope="col">Id</th>
                                        <th class="noborder" scope="col">Nome</th>
                                        <th class="noborder" scope="col">Categoria</th>
                                        <th class="noborder" scope="col">Qtd em estoque</th>
                                    </tr>
                                    <!--FIM HEAD DO COMPONENTE-->

                                    </thead>
                                    <tbody>

                                    <!--INICIO BODY DO COMPONENTE-->
                                    @foreach($components as $component)
                                        <tr class="tabela-componente">
                                            <th scope="row">{{ $component->id }}</th>
                                            <td>{{ $component->nome }}</td>
                                            <td>{{ $component->category->nome }}</td>
                                            <td>{{ $component->storage->qtd or '0' }}</td>
                                        </tr>
                                    @endforeach
                                    <!--FIM BODY DO COMPONENTE-->
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <!--Inicio Conteudo de cada tab -->


        </div>
    </div>
@endsection

@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <!-- Inicio tab de Produto-->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @for($i = 0; $i < count($titulotabs); $i++)
                        @if($i == 0)
                            <a class="nav-item nav-link active noborder-left" id="nav-adicionar-{{$titulotabs[$i]}}-tab"
                               data-toggle="tab"
                               href="#nav-adicionar-{{$titulotabs[$i]}}" role="tab"
                               aria-controls="nav-adicionar-{{$titulotabs[$i]}}"
                               aria-selected="true">{{$titulotabs[$i]}}</a>
                        @else
                            <a class="nav-item nav-link" id="nav-adicionar-{{$titulotabs[$i]}}-tab"
                               data-toggle="tab"
                               href="#nav-adicionar-{{$titulotabs[$i]}}" role="tab"
                               aria-controls="nav-adicionar-{{$titulotabs[$i]}}"
                               aria-selected="false">{{$titulotabs[$i]}}</a>
                        @endif
                    @endfor
                    <div class="topo-tab">
                        <a class="btn-link" href="{{ route('users.create') }}">
                            <button class="btn btn-primary btn-block btn-custom" type="submit">Adicionar</button>
                        </a>
                    </div>
                </div>

            </nav>
            <!-- Fim tab de Produto-->

            <!--Inicio Conteudo de cada tab -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-adicionar-{{$titulotabs[0]}}" role="tabpanel"
                     aria-labelledby="nav-adicionar-{{$titulotabs[0]}}-tab">

                    <form class="formulario" method="POST" role="form">

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
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <!--INICIO HEAD DO VIDRO-->
                                        <tr class="tabela-vidro">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Nome</th>
                                            <th class="noborder" scope="col">Preço m²</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO VIDRO-->

                                        <!--INICIO HEAD DO ALUMINIO-->
                                        <tr class="tabela-aluminio" style="display: none;">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Perfil</th>
                                            <th class="noborder" scope="col">Medida</th>
                                            <th class="noborder" scope="col">Peso</th>
                                            <th class="noborder" scope="col">Preço</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO ALUMINIO-->

                                        <!--INICIO HEAD DO COMPONENTE-->
                                        <tr class="tabela-componente" style="display: none;">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Nome</th>
                                            <th class="noborder" scope="col">Preço</th>
                                            <th class="noborder" scope="col">Qtd</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO COMPONENTE-->

                                        </thead>
                                        <tbody>
                                        <!--INICIO BODY DO VIDRO-->
                                        <tr class="tabela-vidro">
                                            <th scope="row">1</th>
                                            <td>Vidro temperado 08mm</td>
                                            <td>100.0</td>
                                            <td>
                                                <a class="btn-link" href="">
                                                    <button class="btn btn-warning mb-1">Edit</button>
                                                </a>
                                                <a class="btn-link">
                                                    <button class="btn btn-danger mb-1">Delete</button>
                                                </a>

                                            </td>
                                        </tr>
                                        <!--FIM BODY DO VIDRO-->

                                        <!--INICIO BODY DO ALUMINIO-->
                                        <tr class="tabela-aluminio" style="display: none;">
                                            <th scope="row">1</th>
                                            <td>xt-201</td>
                                            <td>6000.0m</td>
                                            <td>1.6kg</td>
                                            <td>22.0</td>
                                            <td>
                                                <a class="btn-link" href="">
                                                    <button class="btn btn-warning mb-1">Edit</button>
                                                </a>
                                                <a class="btn-link">
                                                    <button class="btn btn-danger mb-1">Delete</button>
                                                </a>

                                            </td>
                                        </tr>
                                        <!--FIM BODY DO ALUMINIO-->

                                        <!--INICIO BODY DO COMPONENTE-->
                                        <tr class="tabela-componente" style="display: none;">
                                            <th scope="row">1</th>
                                            <td>Roldana</td>
                                            <td>1.0</td>
                                            <td>1</td>
                                            <td>
                                                <a class="btn-link" href="">
                                                    <button class="btn btn-warning mb-1">Edit</button>
                                                </a>
                                                <a class="btn-link">
                                                    <button class="btn btn-danger mb-1">Delete</button>
                                                </a>

                                            </td>
                                        </tr>
                                        <!--FIM BODY DO COMPONENTE-->
                                        </tbody>
                                    </table>


                                </div>
                            </div>

                        </div>
                        <button class="btn btn-lg btn-primary btn-block btn-custom w-50" type="submit">Enviar</button>

                    </form>

                </div>


                <div class="tab-pane fade" id="nav-adicionar-{{$titulotabs[1]}}" role="tabpanel"
                     aria-labelledby="nav-adicionar-{{$titulotabs[1]}}-tab">

                    <form class="formulario" method="POST" role="form">

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
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <!--INICIO HEAD DO VIDRO-->
                                        <tr class="tabela-vidro">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Nome</th>
                                            <th class="noborder" scope="col">Preço m²</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO VIDRO-->

                                        <!--INICIO HEAD DO ALUMINIO-->
                                        <tr class="tabela-aluminio" style="display: none;">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Perfil</th>
                                            <th class="noborder" scope="col">Medida</th>
                                            <th class="noborder" scope="col">Peso</th>
                                            <th class="noborder" scope="col">Preço</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO ALUMINIO-->

                                        <!--INICIO HEAD DO COMPONENTE-->
                                        <tr class="tabela-componente" style="display: none;">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Nome</th>
                                            <th class="noborder" scope="col">Preço</th>
                                            <th class="noborder" scope="col">Qtd</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO COMPONENTE-->

                                        </thead>
                                        <tbody>
                                        <!--INICIO BODY DO VIDRO-->
                                        <tr class="tabela-vidro">
                                            <th scope="row">1</th>
                                            <td>Vidro temperado 08mm</td>
                                            <td>100.0</td>
                                            <td>
                                                <a class="btn-link" href="">
                                                    <button class="btn btn-warning mb-1">Edit</button>
                                                </a>
                                                <a class="btn-link">
                                                    <button class="btn btn-danger mb-1">Delete</button>
                                                </a>

                                            </td>
                                        </tr>
                                        <!--FIM BODY DO VIDRO-->

                                        <!--INICIO BODY DO ALUMINIO-->
                                        <tr class="tabela-aluminio" style="display: none;">
                                            <th scope="row">1</th>
                                            <td>xt-201</td>
                                            <td>6000.0m</td>
                                            <td>1.6kg</td>
                                            <td>22.0</td>
                                            <td>
                                                <a class="btn-link" href="">
                                                    <button class="btn btn-warning mb-1">Edit</button>
                                                </a>
                                                <a class="btn-link">
                                                    <button class="btn btn-danger mb-1">Delete</button>
                                                </a>

                                            </td>
                                        </tr>
                                        <!--FIM BODY DO ALUMINIO-->

                                        <!--INICIO BODY DO COMPONENTE-->
                                        <tr class="tabela-componente" style="display: none;">
                                            <th scope="row">1</th>
                                            <td>Roldana</td>
                                            <td>1.0</td>
                                            <td>1</td>
                                            <td>
                                                <a class="btn-link" href="">
                                                    <button class="btn btn-warning mb-1">Edit</button>
                                                </a>
                                                <a class="btn-link">
                                                    <button class="btn btn-danger mb-1">Delete</button>
                                                </a>

                                            </td>
                                        </tr>
                                        <!--FIM BODY DO COMPONENTE-->
                                        </tbody>
                                    </table>


                                </div>
                            </div>

                        </div>
                        <button class="btn btn-lg btn-primary btn-block btn-custom w-50" type="submit">Enviar</button>

                    </form>

                </div>

                <div class="tab-pane fade" id="nav-adicionar-{{$titulotabs[2]}}" role="tabpanel"
                     aria-labelledby="nav-adicionar-{{$titulotabs[2]}}-tab">

                    <form class="formulario" method="POST" role="form">

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
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <!--INICIO HEAD DO VIDRO-->
                                        <tr class="tabela-vidro">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Nome</th>
                                            <th class="noborder" scope="col">Preço m²</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO VIDRO-->

                                        <!--INICIO HEAD DO ALUMINIO-->
                                        <tr class="tabela-aluminio" style="display: none;">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Perfil</th>
                                            <th class="noborder" scope="col">Medida</th>
                                            <th class="noborder" scope="col">Peso</th>
                                            <th class="noborder" scope="col">Preço</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO ALUMINIO-->

                                        <!--INICIO HEAD DO COMPONENTE-->
                                        <tr class="tabela-componente" style="display: none;">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Nome</th>
                                            <th class="noborder" scope="col">Preço</th>
                                            <th class="noborder" scope="col">Qtd</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO COMPONENTE-->

                                        </thead>
                                        <tbody>
                                        <!--INICIO BODY DO VIDRO-->
                                        <tr class="tabela-vidro">
                                            <th scope="row">1</th>
                                            <td>Vidro temperado 08mm</td>
                                            <td>100.0</td>
                                            <td>
                                                <a class="btn-link" href="">
                                                    <button class="btn btn-warning mb-1">Edit</button>
                                                </a>
                                                <a class="btn-link">
                                                    <button class="btn btn-danger mb-1">Delete</button>
                                                </a>

                                            </td>
                                        </tr>
                                        <!--FIM BODY DO VIDRO-->

                                        <!--INICIO BODY DO ALUMINIO-->
                                        <tr class="tabela-aluminio" style="display: none;">
                                            <th scope="row">1</th>
                                            <td>xt-201</td>
                                            <td>6000.0m</td>
                                            <td>1.6kg</td>
                                            <td>22.0</td>
                                            <td>
                                                <a class="btn-link" href="">
                                                    <button class="btn btn-warning mb-1">Edit</button>
                                                </a>
                                                <a class="btn-link">
                                                    <button class="btn btn-danger mb-1">Delete</button>
                                                </a>

                                            </td>
                                        </tr>
                                        <!--FIM BODY DO ALUMINIO-->

                                        <!--INICIO BODY DO COMPONENTE-->
                                        <tr class="tabela-componente" style="display: none;">
                                            <th scope="row">1</th>
                                            <td>Roldana</td>
                                            <td>1.0</td>
                                            <td>1</td>
                                            <td>
                                                <a class="btn-link" href="">
                                                    <button class="btn btn-warning mb-1">Edit</button>
                                                </a>
                                                <a class="btn-link">
                                                    <button class="btn btn-danger mb-1">Delete</button>
                                                </a>

                                            </td>
                                        </tr>
                                        <!--FIM BODY DO COMPONENTE-->
                                        </tbody>
                                    </table>


                                </div>
                            </div>

                        </div>
                        <button class="btn btn-lg btn-primary btn-block btn-custom w-50" type="submit">Enviar</button>

                    </form>

                </div>
            </div>
            <!--Inicio Conteudo de cada tab -->


        </div>
    </div>

    <!-- Modal -->

    <div class="modal fade" id="imagensModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Imagens</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="container-fluid">
                        <div id="gridImagens" class="row">

                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-custom" data-dismiss="modal">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

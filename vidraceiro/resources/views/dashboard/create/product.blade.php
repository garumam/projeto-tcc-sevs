@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <!-- Inicio tab de Produto-->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-adicionar-produto-tab" data-toggle="tab"
                       href="#nav-adicionar-produto" role="tab" aria-controls="nav-adicionar-produto"
                       aria-selected="true">Adicionar Produto</a>
                    <a class="nav-item nav-link" id="nav-adicionar-material-tab" data-toggle="tab"
                       href="#nav-adicionar-material" role="tab" aria-controls="nav-adicionar-material"
                       aria-selected="false">Adicionar Material</a>
                </div>
            </nav>
            <!-- Fim tab de Produto-->

            <!--Inicio Conteudo de cada tab -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-adicionar-produto" role="tabpanel"
                     aria-labelledby="nav-adicionar-produto-tab">

                    <form class="formulario" method="POST" role="form">
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label>Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Descrição</label>
                                <input type="text" class="form-control" id="descricao" name="descricao"
                                       placeholder="Descrição" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="select">Tipo</label>
                                <select class="custom-select" title="select">
                                    <option selected>Selecione um tipo</option>
                                    <option value="1">Tipo 1</option>
                                    <option value="2">Tipo 2</option>
                                    <option value="3">Tipo 3</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">

                                <img id="image-selecionar2" src="{{ asset('img/semimagem.png') }}" class="img-fluid"
                                     alt="Responsive image">
                                <a href="#" class="btn btn-lg btn-primary btn-custom w-3277" data-toggle="modal"
                                   data-target="#imagensModal">Buscar</a>
                                <label for="url-image2"></label><input type="text" id="url-image2" name="url-image2"
                                                                       style="display: none;">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Imagem</label>

                                <div id="dropmenu-imagem" class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="menu1"
                                            data-toggle="dropdown">
                                        <img id="image-selecionar" src="{{ asset('img/bootstrap-solid.svg')}}"
                                             class="img-fluid" alt="Responsive image">
                                    </button>
                                    <label for="url-image"></label><input type="text" id="url-image" name="url-image"
                                                                          style="display: none;">
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">

                                        <li role="presentation">
                                            {{--<a role="menuitem" tabindex="-1" href="#">--}}
                                            <img src="{{ asset('img/boxdiversos/bxa1.png')}}" class="img-fluid"
                                                 alt="Responsive image">
                                            {{--</a>--}}
                                        </li>
                                        <li role="presentation">
                                            {{--<a role="menuitem" tabindex="-1" href="#">--}}
                                            <img src="{{ asset('img/boxdiversos/bxa2.png')}}" class="img-fluid"
                                                 alt="Responsive image">
                                            {{--</a>--}}
                                        </li>
                                        <li role="presentation">
                                            {{--<a role="menuitem" tabindex="-1" href="#">--}}
                                            <img src="{{ asset('img/boxdiversos/bxc1.png')}}" class="img-fluid"
                                                 alt="Responsive image">
                                            {{--</a>--}}
                                        </li>
                                    </ul>
                                </div>

                            </div>

                        </div>
                        <button class="btn btn-lg btn-primary btn-block btn-custom w-3277" type="submit">Enviar
                        </button>

                    </form>

                </div>
                <div class="tab-pane fade" id="nav-adicionar-material" role="tabpanel"
                     aria-labelledby="nav-adicionar-material-tab">

                    <form class="formulario" method="POST" role="form">
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome_material" name="nome_material"
                                       placeholder="Nome">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Password">
                            </div>

                        </div>
                        <button class="btn btn-lg btn-primary btn-block btn-custom w-3277" type="submit">Enviar</button>

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
                    <h5 class="modal-title">Titulo do modal</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="container-fluid">
                        <div id="gridImagens" class="row">
                            @for($i = 0; $i < count($boxdiversos); $i++ )
                                <div class="col-">
                                    <img src="{{ asset('img/boxdiversos/'.$boxdiversos[$i].'.png')}}" class="img-fluid img-thumbnail"
                                         alt="Responsive image">
                                </div>
                            @endfor

                            {{--<div class="col-">--}}
                                {{--<img src="{{ asset('img/boxdiversos/bxa2.png')}}" class="img-fluid img-thumbnail"--}}
                                     {{--alt="Responsive image">--}}
                            {{--</div>--}}


                            {{--<div class="col-">--}}
                                {{--<img src="{{ asset('img/boxdiversos/bxc1.png')}}" class="img-fluid img-thumbnail"--}}
                                     {{--alt="Responsive image">--}}
                            {{--</div>--}}


                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
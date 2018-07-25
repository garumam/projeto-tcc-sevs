@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <!-- Inicio tab de Produto-->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-adicionar-produto-tab" data-toggle="tab" href="#nav-adicionar-produto" role="tab" aria-controls="nav-adicionar-produto" aria-selected="true">Adicionar Produto</a>
                    <a class="nav-item nav-link" id="nav-adicionar-material-tab" data-toggle="tab" href="#nav-adicionar-material" role="tab" aria-controls="nav-adicionar-material" aria-selected="false">Adicionar Material</a>
                </div>
            </nav>
            <!-- Fim tab de Produto-->

            <!--Inicio Conteudo de cada tab -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-adicionar-produto" role="tabpanel" aria-labelledby="nav-adicionar-produto-tab">

                    <form class="formulario" method="POST" role="form">
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"> </input>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="nome">Descrição</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Descrição"> </input>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="nome">Tipo</label>
                                <select class="custom-select">
                                    <option selected>Selecione um tipo</option>
                                    <option value="1">Tipo 1</option>
                                    <option value="2">Tipo 2</option>
                                    <option value="3">Tipo 3</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="nome">Imagem</label>

                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">
                                        <img src="{{ asset('img/bootstrap-solid.svg')}}" class="img-fluid" alt="Responsive image">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="#">
                                                <img src="{{ asset('img/bootstrap-solid.svg')}}" class="img-fluid" alt="Responsive image">
                                            </a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="#">
                                                <img src="{{ asset('img/bootstrap-solid.svg')}}" class="img-fluid" alt="Responsive image">
                                            </a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="#">
                                                <img src="{{ asset('img/bootstrap-solid.svg')}}" class="img-fluid" alt="Responsive image">
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                        </div>
                        <button class="btn btn-lg btn-primary btn-block btn-custom w-3277" type="submit">Enviar</button>

                    </form>

                </div>
                <div class="tab-pane fade" id="nav-adicionar-material" role="tabpanel" aria-labelledby="nav-adicionar-material-tab">

                    <form class="formulario" method="POST" role="form">
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"> </input>
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
@endsection
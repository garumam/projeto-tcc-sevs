@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <!-- Inicio tab de Produto-->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active noborder-left" id="nav-adicionar-produto-tab" data-toggle="tab"
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

                    <form id="form-product" class="formulario" method="POST" role="form"
                          action="{{route('product.create')}}">
                        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
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
                                <label for="select-categoria">Categoria</label>
                                <select id="select-categoria" name="select" class="custom-select">
                                    <option value="0" selected>Selecione uma categoria</option>

                                    @foreach($categorias as $categoria)
                                        @php
                                        $categorianova = str_replace('ã', 'a', $categoria);
                                        $categorianova = str_replace(' ', '', strtolower($categorianova));
                                        @endphp
                                        <option value="{{$categorianova}}">{{$categoria}}</option>
                                    @endforeach

                                    {{--<option value="boxpadrao">Box padrão</option>--}}
                                    {{--<option value="ferragem1000">Ferragem 1000</option>--}}
                                    {{--<option value="ferragem3000">Ferragem 3000</option>--}}
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Imagem</label>
                                <div class="imagem-modal">
                                    <img id="image-selecionar" src="{{ asset('img/semimagem.png') }}" class="img-fluid"
                                         alt="Responsive image">
                                    <a href="#" class="btn btn-lg btn-primary btn-custom w-50" data-toggle="modal"
                                       data-target="#imagensModal">Buscar</a>
                                    <label for="url-image"></label>
                                    <input type="text" id="url-image" name="url-image" style="display: none;">
                                </div>

                            </div>


                        </div>
                        <button class="btn btn-lg btn-primary btn-block btn-custom w-3277" type="submit">Criar
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
                    <h5 class="modal-title">Imagens</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="container-fluid">
                        <div id="gridImagens" class="row">
                            <p id="selecione-categoria" style="color: #191919; font-weight: 600;">Selecione uma
                                categoria</p>
                            <div id="boxdiversos" style="display: none;">
                                @for($i = 0; $i < count($boxdiversos); $i++ )
                                    <div class="col-">
                                        <img id="{{$i}}" src="{{ asset('img/boxdiversos/'.$boxdiversos[$i])}}"
                                             class="img-fluid img-thumbnail"
                                             alt="Responsive image">
                                    </div>
                                @endfor
                            </div>

                            <div id="boxpadrao" style="display: none;">
                                @for($i = 0; $i < count($boxpadrao); $i++ )
                                    <div class="col-">
                                        <img id="{{$i}}" src="{{ asset('img/boxpadrao/'.$boxpadrao[$i])}}"
                                             class="img-fluid img-thumbnail"
                                             alt="Responsive image">
                                    </div>
                                @endfor
                            </div>

                            <div id="ferragem1000" style="display: none;">
                                @for($i = 0; $i < count($ferragem1000); $i++ )
                                    <div class="col-">
                                        <img id="{{$i}}" src="{{ asset('img/ferragem1000/'.$ferragem1000[$i])}}"
                                             class="img-fluid img-thumbnail"
                                             alt="Responsive image">
                                    </div>
                                @endfor
                            </div>

                            <div id="ferragem3000" style="display: none;">
                                @for($i = 0; $i < count($ferragem3000); $i++ )
                                    <div class="col-">
                                        <img id="{{$i}}" src="{{ asset('img/ferragem3000/'.$ferragem3000[$i])}}"
                                             class="img-fluid img-thumbnail"
                                             alt="Responsive image">
                                    </div>
                                @endfor
                            </div>


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

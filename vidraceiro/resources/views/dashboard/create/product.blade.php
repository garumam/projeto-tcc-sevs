@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <!-- Inicio tab de Produto-->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active noborder-left" id="nav-adicionar-produto-tab" data-toggle="tab"
                       href="#nav-adicionar-produto" role="tab" aria-controls="nav-adicionar-produto"
                       aria-selected="true">{{$titulotabs['tab1']}}</a>
                    <a class="nav-item nav-link" id="nav-adicionar-material-tab" data-toggle="tab"
                       href="#nav-adicionar-material" role="tab" aria-controls="nav-adicionar-material"
                       aria-selected="false">{{$titulotabs['tab2']}}</a>
                </div>
            </nav>
            <!-- Fim tab de Produto-->

            <!--Inicio Conteudo de cada tab -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-adicionar-produto" role="tabpanel"
                     aria-labelledby="nav-adicionar-produto-tab">

                    <form id="form-product" class="formulario" method="POST" role="form"
                          action="{{route('products.create')}}">
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
                        <button class="btn btn-lg btn-primary btn-custom w-50" type="submit">Criar
                        </button>

                    </form>

                </div>
                <div class="tab-pane fade" id="nav-adicionar-material" role="tabpanel"
                     aria-labelledby="nav-adicionar-material-tab">

                    <form class="formulario" method="POST" role="form">

                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="id">id</label>
                                <input class="form-control" type="text" placeholder="1" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="nome">Produto</label>
                                <input class="form-control" type="text" placeholder="bx-01" readonly>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                    <label class="btn btn-primary active w-33">
                                        <input type="radio" name="options" id="option1" autocomplete="off" checked> Vidro
                                    </label>
                                    <label class="btn btn-primary w-33">
                                        <input type="radio" name="options" id="option2" autocomplete="off"> Alumínio
                                    </label>
                                    <label class="btn btn-primary w-33">
                                        <input type="radio" name="options" id="option3" autocomplete="off"> Componente
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row mt-3 align-items-end">

                            <div class="form-group col-md-4">
                                <label for="select-categoria">Vidros</label>
                                <select id="select-categoria" class="custom-select">
                                    <option value="0" selected>Selecione um vidro</option>
                                    <option value="">Vidro temperado</option>
                                    <option value="">Vidro azul</option>
                                    <option value="">Vidro blindado</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <a class="btn-link mb-3" href="{{ route('products.create') }}">
                                    <button class="btn btn-primary btn-block btn-custom" type="submit">Adicionar</button>
                                </a>
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-12">
                                <div class="topo">
                                    <h4 class="titulo">Vidros</h4>
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

                            <div id="kitsacada" style="display: none;">
                                @for($i = 0; $i < count($kitsacada); $i++ )
                                    <div class="col-">
                                        <img id="{{$i}}" src="{{ asset('img/kitsacada/'.$kitsacada[$i])}}"
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
                    <button type="button" class="btn btn-custom" data-dismiss="modal">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

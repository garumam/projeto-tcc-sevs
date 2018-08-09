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
                               data-toggle="tab"
                               href="#nav-{{$titulotabs[$i]}}" role="tab" aria-controls="nav-{{$titulotabs[$i]}}"
                               aria-selected="true">{{$titulotabs[$i]}}</a>
                        @else
                            <a class="nav-item nav-link" id="nav-{{$titulotabs[$i]}}-tab" data-toggle="tab"
                               href="#nav-{{$titulotabs[$i]}}" role="tab" aria-controls="nav-{{$titulotabs[$i]}}"
                               aria-selected="false">{{$titulotabs[$i]}}</a>
                        @endif
                    @endfor
                    <div class="topo-tab">

                        <button id="bt-product-visible" class="btn btn-primary btn-custom"
                                type="submit">{{empty($mproduct) ? 'Adicionar': 'Atualizar'}}</button>

                    </div>
                </div>
            </nav>
            <!-- Fim tab de Produto-->

            <!--Inicio Conteudo de cada tab -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-{{$titulotabs[0]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[0]}}-tab">

                    <form id="form-product" class="formulario" method="POST" role="form"
                          action="{{ !empty($mproduct) ? route('mproducts.update',['id'=> $mproduct->id]) : route('mproducts.store') }}">
                        @if(!empty($mproduct))
                            <input type="hidden" name="_method" value="PATCH">
                        @endif
                        @csrf
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
                                <select id="select-categoria" name="select" class="custom-select" required>
                                    <option value="" selected>Selecione uma categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->nome}}</option>
                                    @endforeach
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
                        <button id="bt-produto-product-invisible" class="d-none" type="submit"></button>

                    </form>

                </div>
                <div class="tab-pane fade" id="nav-{{$titulotabs[1]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[1]}}-tab">

                    <form class="formulario" method="POST" role="form"
                          action="{{ !empty($mproduct) ? route('mproducts.update',['id'=> $mproduct->id]) : route('mproducts.store') }}">
                        @if(!empty($mproduct))
                            <input type="hidden" name="_method" value="PATCH">
                        @endif
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="id">Id</label>
                                <input class="form-control" type="text" placeholder="1" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="nome">Produto</label>
                                <input class="form-control" type="text" placeholder="bx-01" readonly>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-8">

                                <label for="select-material">Materiais</label>
                                <select id="select-material" class="custom-select">
                                    <option value="0">Vidros</option>
                                    <option value="1">Aluminios</option>
                                    <option value="2">Componentes</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-row mt-3 align-items-end">

                            <div class="form-group col-md-4">
                                <label for="select-categoria">Vidros</label>
                                <select id="select-categoria" class="custom-select" required>
                                    <option value="" selected>Selecione um vidro</option>
                                    <option value="">Vidro temperado</option>
                                    <option value="">Vidro azul</option>
                                    <option value="">Vidro blindado</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <a class="btn-link mb-3" href="{{ route('mproducts.create') }}">
                                    <button class="btn btn-primary btn-block btn-custom" type="submit">Adicionar
                                    </button>
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
                        <button id="bt-material-product-invisible" class="d-none" type="submit"></button>

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

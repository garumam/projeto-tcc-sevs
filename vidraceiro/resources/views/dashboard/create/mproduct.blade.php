@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <!-- Inicio tab de Produto-->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    {{--@if(session('success'))--}}
                    {{--<script>--}}
                    {{--$(document).ready(function () {--}}

                    {{--$('#nav-Material-tab').click();--}}

                    {{--});--}}
                    {{--</script>--}}
                    {{--@endif--}}

                    @for($i = 0; $i < count($titulotabs); $i++)
                        @if($i == 0)
                            <a class="nav-item nav-link {{ empty(session('mproductcriado')) ? 'active' : 'disabled' }} noborder-left"
                               id="nav-{{$titulotabs[$i]}}-tab"
                               data-toggle="tab"
                               href="#nav-{{$titulotabs[$i]}}" role="tab" aria-controls="nav-{{$titulotabs[$i]}}"
                               aria-selected="true">{{$titulotabs[$i]}}</a>
                        @else
                            <a class="nav-item nav-link {{ empty(session('mproductcriado')) ? 'disabled' : 'active' }}"
                               id="nav-{{$titulotabs[$i]}}-tab" data-toggle="tab"
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
                <div class="tab-pane fade {{ empty(session('mproductcriado')) ? 'show active' : '' }} " id="nav-{{$titulotabs[0]}}"
                     role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[0]}}-tab">

                    <form id="form-product" class="formulario" method="POST" role="form"
                          action="{{ !empty($mproduct) ? route('mproducts.update',['id'=> $mproduct->id]) : route('mproducts.store') }}">
                        @if(!empty($mproduct))
                            <input type="hidden" name="_method" value="PATCH">
                        @endif
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                       value="{{$mproduct->nome or old('nome')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="descricao">Descrição</label>
                                <input type="text" class="form-control" id="descricao" name="descricao"
                                       value="{{$mproduct->descricao or old('descricao')}}" placeholder="Descrição"
                                       required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="select-categoria">Categoria</label>
                                <select id="select-categoria" name="categoria_produto_id" class="custom-select"
                                        required>
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
                                    <a href="#" class="btn btn-md btn-primary btn-custom w-50" data-toggle="modal"
                                       data-target="#imagensModal">Selecionar</a>
                                    <label for="url-image"></label>
                                    <input type="text" id="url-image" name="imagem" style="display: none;">
                                </div>

                            </div>

                            <input type="hidden" name="tabatual" value="produto">
                        </div>
                        <button id="bt-produto-product-invisible" class="d-none" type="submit"></button>

                    </form>

                </div>
                <div class="tab-pane fade {{ !empty(session('mproductcriado')) ? 'show active' : '' }}" id="nav-{{$titulotabs[1]}}"
                     role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[1]}}-tab">

                    <form class="formulario" method="POST" role="form"
                          action="{{ !empty($mproduct) ? route('mproducts.update',['id'=> $mproduct->id]) : route('mproducts.store') }}">
                        @if(!empty($mproduct))
                            <input type="hidden" name="_method" value="PATCH">
                        @endif
                        @csrf
                        <div class="form-row">

                            <div class="col-12">
                                @if(session('tab2'))
                                    <div class="alerta">
                                        <div class="alert alert-success">
                                            {{ session('tab2') }}
                                        </div>
                                    </div>
                                @elseif(session('error'))
                                    <div class="alerta">
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label for="id">Id</label>
                                <input class="form-control" type="text"
                                       value="{{!empty($mproduct) ? $mproduct->id : session('mproductcriado')? Session::get('mproductcriado')->id :''}}" readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="nome">Produto</label>
                                <input class="form-control" type="text"
                                       value="{{!empty($mproduct) ? $mproduct->nome : session('mproductcriado')? Session::get('mproductcriado')->nome :''}}" readonly>
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
                                <label for="select-vidro" id="label_categoria">Vidros</label>
                                <select id="select-vidro" name="id_vidro" class="custom-select" required>
                                    <option value="" selected>Selecione um vidro</option>
                                    @foreach($glasses as $glasse)
                                        <option value="{{$glasse->id}}">{{$glasse->nome}}</option>
                                    @endforeach
                                </select>
                                <select id="select-aluminio" name="id_aluminio" class="custom-select"
                                        style="display: none;" required>
                                    <option value="" selected>Selecione um aluminio</option>
                                    @foreach($aluminums as $aluminum)
                                        <option value="{{$aluminum->id}}">{{$aluminum->perfil}}</option>
                                    @endforeach
                                </select>
                                <select id="select-componente" name="id_componente" class="custom-select"
                                        style="display: none;" required>
                                    <option value="" selected>Selecione um componente</option>
                                    @foreach($components as $component)
                                        <option value="{{$component->id}}">{{$component->nome}}</option>
                                    @endforeach
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

                            <div class="form-group col-12 p-0">
                                <div class="topo pl-2">
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
                                        <tr id="topo-vidro">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Nome</th>
                                            <th class="noborder" scope="col">Preço m²</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO VIDRO-->

                                        <!--INICIO HEAD DO ALUMINIO-->
                                        <tr id="topo-aluminio" style="display: none;">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Perfil</th>
                                            <th class="noborder" scope="col">Medida</th>
                                            <th class="noborder" scope="col">Peso</th>
                                            <th class="noborder" scope="col">Preço</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO ALUMINIO-->

                                        <!--INICIO HEAD DO COMPONENTE-->
                                        <tr id="topo-componente" style="display: none;">
                                            <th class="noborder" scope="col">Id</th>
                                            <th class="noborder" scope="col">Nome</th>
                                            <th class="noborder" scope="col">Preço</th>
                                            <th class="noborder" scope="col">Qtd</th>
                                            <th class="noborder" scope="col">Ação</th>
                                        </tr>
                                        <!--FIM HEAD DO COMPONENTE-->

                                        </thead>

                                        <!--INICIO BODY DO VIDRO-->
                                        <tbody id="tabela-vidro">
                                        @if(!empty($mproduct))
                                            @foreach($glassesProduct as $glassP)
                                                <tr>
                                                    <th scope="row">{{$glassP->id}}</th>
                                                    <td>{{$glassP->nome}}</td>
                                                    <td>R${{$glassP->preco}}</td>
                                                    <td>
                                                        <a class="btn-link">
                                                            <button class="btn btn-danger mb-1">Delete</button>
                                                        </a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>

                                        <!--FIM BODY DO VIDRO-->

                                        <!--INICIO BODY DO ALUMINIO-->
                                        <tbody id="tabela-aluminio" style="display: none;">
                                        @if(!empty($mproduct))
                                            @foreach($aluminumsProduct as $aluminumP)
                                                <tr>
                                                    <th scope="row">{{$aluminumP->id}}</th>
                                                    <td>{{$aluminumP->perfil}}</td>
                                                    <td>{{$aluminumP->medida}}</td>
                                                    <td>{{$aluminumP->peso}}</td>
                                                    <td>{{$aluminumP->preco}}</td>
                                                    <td>
                                                        <a class="btn-link">
                                                            <button class="btn btn-danger mb-1">Delete</button>
                                                        </a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <!--FIM BODY DO ALUMINIO-->

                                        <!--INICIO BODY DO COMPONENTE-->
                                        <tbody id="tabela-componente" style="display: none;">
                                        @if(!empty($mproduct))
                                            @foreach($componentsProduct as $componentP)
                                                <tr>
                                                    <th scope="row">{{$componentP->id}}</th>
                                                    <td>{{$componentP->nome}}</td>
                                                    <td>{{$componentP->preco}}</td>
                                                    <td>{{$componentP->qtd}}</td>
                                                    <td>
                                                        <a class="btn-link">
                                                            <button class="btn btn-danger mb-1">Delete</button>
                                                        </a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <!--FIM BODY DO COMPONENTE-->

                                    </table>


                                </div>
                            </div>
                            <input type="hidden" name="tabatual" value="material">
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

                            @if(!session('mproductcriado'))

                                <p id="selecione-categoria" style="color: #191919; font-weight: 600;">Selecione uma
                                    categoria</p>
                                <div id="boxdiversos" style="display: none;">
                                    <h4 class="text-black-50 col-12 mt-2 pl-1">Box diversos</h4>
                                    @for($i = 0; $i < count($boxdiversos); $i++ )
                                        <div class="col-">
                                            <img id="{{$i}}" src="{{ asset('img/boxdiversos/'.$boxdiversos[$i])}}"
                                                 class="img-fluid img-thumbnail"
                                                 alt="Responsive image">
                                        </div>
                                    @endfor
                                </div>

                                <div id="boxpadrao" style="display: none;">
                                    <h4 class="text-black-50 col-12 mt-2 pl-1">Box padrão</h4>
                                    @for($i = 0; $i < count($boxpadrao); $i++ )
                                        <div class="col-">
                                            <img id="{{$i}}" src="{{ asset('img/boxpadrao/'.$boxpadrao[$i])}}"
                                                 class="img-fluid img-thumbnail"
                                                 alt="Responsive image">
                                        </div>
                                    @endfor
                                </div>

                                <div id="ferragem1000" style="display: none;">
                                    <h4 class="text-black-50 col-12 mt-2 pl-1">Ferragem 1000</h4>
                                    @for($i = 0; $i < count($ferragem1000); $i++ )
                                        <div class="col-">
                                            <img id="{{$i}}" src="{{ asset('img/ferragem1000/'.$ferragem1000[$i])}}"
                                                 class="img-fluid img-thumbnail"
                                                 alt="Responsive image">
                                        </div>
                                    @endfor
                                </div>

                                <div id="ferragem3000" style="display: none;">
                                    <h4 class="text-black-50 col-12 mt-2 pl-1">Ferragem 3000</h4>
                                    @for($i = 0; $i < count($ferragem3000); $i++ )
                                        <div class="col-">
                                            <img id="{{$i}}" src="{{ asset('img/ferragem3000/'.$ferragem3000[$i])}}"
                                                 class="img-fluid img-thumbnail"
                                                 alt="Responsive image">
                                        </div>
                                    @endfor
                                </div>

                                <div id="kitsacada" style="display: none;">
                                    <h4 class="text-black-50 col-12 mt-2 pl-1">Kit sacada</h4>
                                    @for($i = 0; $i < count($kitsacada); $i++ )
                                        <div class="col-">
                                            <img id="{{$i}}" src="{{ asset('img/kitsacada/'.$kitsacada[$i])}}"
                                                 class="img-fluid img-thumbnail"
                                                 alt="Responsive image">
                                        </div>
                                    @endfor
                                </div>

                            @endif
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

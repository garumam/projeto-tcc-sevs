@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <!-- Inicio tab de Produto-->
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">


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
                                type="submit">Salvar</button>

                    </div>
                </div>
            </nav>
            <!-- Fim tab de Produto-->

            <!--Inicio Conteudo de cada tab -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade {{ empty(session('mproductcriado')) ? 'show active' : '' }} "
                     id="nav-{{$titulotabs[0]}}"
                     role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[0]}}-tab">

                    <form id="form-product" class="formulario" method="POST" role="form"
                          action="{{ !empty($mproductedit) ? route('mproducts.update',['id'=> $mproductedit->id, 'tab' => '1']) : route('mproducts.store',['tab'=>'1']) }}">
                        @if(!empty($mproductedit))
                            <input type="hidden" name="_method" value="PATCH">
                        @endif
                        @csrf
                        <div class="form-row">
                            <div class="col-12">
                                @foreach($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        {{ $error }}
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                       value="{{$mproductedit->nome or old('nome')}}" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="descricao">Descrição</label>
                                <input type="text" class="form-control" id="descricao" name="descricao"
                                       value="{{$mproductedit->descricao or old('descricao')}}" placeholder="Descrição">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="select-categoria">Categoria</label>
                                <select id="select-categoria" name="categoria_produto_id" class="custom-select"
                                        required>
                                    <option value="" selected>Selecione uma categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->grupo_imagem}}" @if(!empty($categoryEdit)){{ $category->id == $categoryEdit[0]->id ? 'selected' :''}} @endif>{{$category->nome}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Imagem</label>
                                <div class="imagem-modal">
                                    <img id="image-selecionar" data-produto="{{!empty($mproductedit) ? true : false}}" src="{{ !empty($mproductedit) ? $mproductedit->imagem : '/img/semimagem.png' }}" class="img-fluid img-thumbnail"
                                         alt="Responsive image">
                                    <a href="#" class="btn btn-md btn-primary btn-custom" data-toggle="modal"
                                       data-target="#imagensModal">Selecionar</a>
                                    <label for="url-image"></label>
                                    <input type="text" id="url-image" name="imagem" style="display: none;">
                                </div>

                            </div>

                        </div>
                        <button id="bt-produto-product-invisible" class="d-none" type="submit"></button>

                    </form>

                </div>
                <div class="tab-pane fade {{ !empty(session('mproductcriado')) ? 'show active' : '' }}"
                     id="nav-{{$titulotabs[1]}}"
                     role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[1]}}-tab">

                    <form class="formulario" method="POST" role="form"
                          action="{{ !empty($mproductedit) ? route('mproducts.update',['id'=> $mproductedit->id, 'tab' => '2']) : route('mproducts.store',['tab'=>'2']) }}">
                        @if(!empty($mproductedit))
                            <input type="hidden" name="_method" value="PATCH">
                        @endif
                        @csrf
                        <div class="form-row">

                            <div class="col-12">
                                @if(session('success'))
                                    <div class="alerta p-0">
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
                                    @foreach($errors->all() as $error)
                                        <div class="alert alert-danger">
                                            {{ $error }}
                                        </div>
                                    @endforeach
                            </div>

                            <div class="form-group col-md-4">
                                <label for="id">Id</label>
                                <input id="id" name="m_produto_id" class="form-control" type="text"
                                       value="{{ !empty(session('mproductcriado')) ? Session::get('mproductcriado')->id : ''}}"
                                       readonly>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="nome">Produto</label>
                                <input id="nome" class="form-control" type="text"
                                       value="{{ !empty(session('mproductcriado')) ? Session::get('mproductcriado')->nome : ''}}"
                                       readonly>
                            </div>

                        </div>
                            @include('layouts.listarmaterial')
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
                                            <img id="{{$i}}" src="{{ '/img/boxdiversos/'.$boxdiversos[$i]}}"
                                                 class="img-fluid img-thumbnail images-modal"
                                                 alt="Responsive image">
                                        </div>
                                    @endfor
                                </div>

                                <div id="boxpadrao" style="display: none;">
                                    <h4 class="text-black-50 col-12 mt-2 pl-1">Box padrão</h4>
                                    @for($i = 0; $i < count($boxpadrao); $i++ )
                                        <div class="col-">
                                            <img id="{{$i}}" src="{{ '/img/boxpadrao/'.$boxpadrao[$i]}}"
                                                 class="img-fluid img-thumbnail images-modal"
                                                 alt="Responsive image">
                                        </div>
                                    @endfor
                                </div>

                                <div id="ferragem1000" style="display: none;">
                                    <h4 class="text-black-50 col-12 mt-2 pl-1">Ferragem 1000</h4>
                                    @for($i = 0; $i < count($ferragem1000); $i++ )
                                        <div class="col-">
                                            <img id="{{$i}}" src="{{ '/img/ferragem1000/'.$ferragem1000[$i]}}"
                                                 class="img-fluid img-thumbnail images-modal"
                                                 alt="Responsive image">
                                        </div>
                                    @endfor
                                </div>

                                <div id="ferragem3000" style="display: none;">
                                    <h4 class="text-black-50 col-12 mt-2 pl-1">Ferragem 3000</h4>
                                    @for($i = 0; $i < count($ferragem3000); $i++ )
                                        <div class="col-">
                                            <img id="{{$i}}" src="{{ '/img/ferragem3000/'.$ferragem3000[$i]}}"
                                                 class="img-fluid img-thumbnail images-modal"
                                                 alt="Responsive image">
                                        </div>
                                    @endfor
                                </div>

                                <div id="kitsacada" style="display: none;">
                                    <h4 class="text-black-50 col-12 mt-2 pl-1">Kit sacada</h4>
                                    @for($i = 0; $i < count($kitsacada); $i++ )
                                        <div class="col-">
                                            <img id="{{$i}}" src="{{ '/img/kitsacada/'.$kitsacada[$i]}}"
                                                 class="img-fluid img-thumbnail images-modal"
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

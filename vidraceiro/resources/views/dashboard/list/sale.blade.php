@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <!-- Inicio tab de Venda-->
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
                    <div class="topo-tab">
                        <a class="btn-link" href="{{ route('sales.create') }}">
                            <button class="btn btn-primary btn-block btn-custom" type="submit">Realizar venda</button>
                        </a>
                    </div>
                </div>

            </nav>
            <!-- Fim tab de Venda-->

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
            @else
                @foreach($errors->all() as $error)
                    <div class="alerta">
                        <div class="alert alert-danger m-0">
                            {{ $error }}
                        </div>
                    </div>
                @endforeach

            @endif

        <!--Inicio Conteudo de cada tab -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-{{$titulotabs[0]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[0]}}-tab">

                    <div class="form-row formulario pb-0 justify-content-between">
                        <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                            <label for="paginatevendas">Mostrar</label>
                            <select id="paginatevendas" name="paginate" class="custom-select"
                                    onchange="ajaxPesquisaLoad('{{url('sales')}}?search='+$('#searchvendas').val()+'&paginate='+$('#paginatevendas').val(),'vendas')">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                            <label for="search">Pesquisar</label>
                            <input type="text" class="form-control"
                                   onkeyup="ajaxPesquisaLoad('{{url('sales')}}?search='+$('#searchvendas').val()+'&paginate='+$('#paginatevendas').val(),'vendas')"
                                   value="{{ old('search') }}" id="searchvendas" name="search" placeholder="Pesquisar">
                        </div>
                    </div>

                    <div class="table-responsive text-dark p-2" id="vendas">
                        @include('dashboard.list.tables.table-sale')
                        <p class="info-importante mt-1">Não é possível deletar ou editar venda relacionada a ordem
                            serviço em andando ou aberta!</p>
                        <p class="info-importante mt-1">Não é possível deletar ou editar venda que tenha recebido pagamento, apenas será liberado para exclusão após a ordem de serviço ser concluída e não haja pagamento pendente!</p>
                    </div>

                </div>
                <div class="tab-pane fade" id="nav-{{$titulotabs[1]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[1]}}-tab">

                    <div class="form-row formulario pb-0 justify-content-between">
                        <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                            <label for="paginatepagamentos">Mostrar</label>
                            <select id="paginatepagamentos" name="paginate" class="custom-select"
                                    onchange="ajaxPesquisaLoad('{{url('sales')}}?pagamentos=1&search='+$('#searchpagamentos').val()+'&paginate='+$('#paginatepagamentos').val(),'pagamentos')">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                            <label for="search">Pesquisar</label>
                            <input type="text" class="form-control"
                                   onkeyup="ajaxPesquisaLoad('{{url('sales')}}?pagamentos=1&search='+$('#searchpagamentos').val()+'&paginate='+$('#paginatepagamentos').val(),'pagamentos')"
                                   value="{{ old('search') }}" id="searchpagamentos" name="search" placeholder="Pesquisar">
                        </div>
                    </div>

                    <div class="table-responsive text-dark p-2" id="pagamentos">
                        @include('dashboard.list.tables.table-payment')
                    </div>

                </div>
            </div>
            <!--Fim Conteudo de cada tab -->

        </div>
    </div>

@endsection


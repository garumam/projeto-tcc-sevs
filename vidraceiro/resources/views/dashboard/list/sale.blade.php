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
        @endif

        <!--Inicio Conteudo de cada tab -->
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-{{$titulotabs[0]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[0]}}-tab">

                    <div class="form-row formulario pb-0 justify-content-between">
                        <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                            <label for="paginate">Mostrar</label>
                            <select id="paginate" name="paginate" class="custom-select"
                                    onchange="ajaxPesquisaLoad('{{url('sales')}}?search='+$('#search').val()+'&paginate='+$('#paginate').val())">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                            <label for="search">Pesquisar</label>
                            <input type="text" class="form-control"
                                   onkeyup="ajaxPesquisaLoad('{{url('sales')}}?search='+$('#search').val()+'&paginate='+$('#paginate').val())"
                                   value="{{ old('search') }}" id="search" name="search" placeholder="Pesquisar">
                        </div>
                    </div>

                    <div class="table-responsive text-dark p-2" id="content">
                        @include('dashboard.list.tables.table-sale')
                        <p class="info-importante mt-1">Não é possível deletar ou editar venda relacionada a ordem
                            serviço em andando ou que está com pagamento pendente!</p>
                        <p class="info-importante">Não é possível editar venda relacionada a orçamento finalizado!</p>
                    </div>

                </div>
                <div class="tab-pane fade" id="nav-{{$titulotabs[1]}}" role="tabpanel"
                     aria-labelledby="nav-{{$titulotabs[1]}}-tab">

                    <div class="table-responsive text-dark p-2">

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
                                <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Orçamento</th>
                                <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Cliente</th>
                                <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Valor da venda
                                </th>
                                <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Falta pagar</th>
                                <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($sales->where('tipo_pagamento','A PRAZO') as $sale)

                                @if(!empty($sale->budget->client) && !empty($sale->installments->where('status_parcela','ABERTO')->shift()))

                                    @php $valorpago = 0; @endphp
                                    @foreach($sale->payments as $payment)
                                        @php $valorpago += $payment->valor_pago; @endphp
                                    @endforeach
                                    @php $faltapagar = $sale->budget->total - $valorpago; @endphp
                                    <tr>
                                        <th scope="row">{{$sale->id}}</th>
                                        <td>{{$sale->budget->nome}}</td>
                                        <td>{{$sale->budget->client->nome}}</td>
                                        <td>{{$sale->budget->total}}</td>
                                        <td>{{$faltapagar}}</td>
                                        <td>
                                            <a class="btn-link" href="{{ route('sales.pay',['id'=> $sale->id]) }}">
                                                <button class="btn btn-success mb-1 card-shadow-1dp d-flex"
                                                        title="Pagar"><i class="fas fa-dollar-sign"
                                                                         style="font-size: 1.5rem;"></i></button>
                                            </a>
                                        </td>
                                    </tr>

                                @endif
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
            <!--Fim Conteudo de cada tab -->

        </div>
    </div>

@endsection


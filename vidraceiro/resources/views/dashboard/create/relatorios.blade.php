@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}} </h4>
                <button id="bt-pdf-visible" class="btn btn-primary btn-custom" type="button">Gerar Relatório</button>

            </div>


            @switch($tipo)
                @case('orders')
                @case('budgets')

                <form class="formulario" method="GET" role="form" target="_blank"
                      action="{{route('pdf.showRelatorio',['tipo'=>$tipo])}}">

                    <div class="form-row">

                        <div class="form-group col-md-12">
                             <h5 class="titulo">Filtros (opcionais)</h5>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="status">Status</label>
                            <select class="custom-select" id="status" name="status" required>
                            @foreach($status as $index => $value)
                                <option value="{{$index}}">{{$value}}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="total-inicial">Valor total de:</label>
                            <input type="number" step=".01" class="form-control" id="total-inicial" name="total_de">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="total-final">até total:</label>
                            <input type="number" step=".01" class="form-control" id="total-final" name="total_ate">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="data-inicial">Data inicial de:</label>
                            <input type="date" class="form-control" id="data-inicial" name="data_inicial">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="data-final">até data:</label>
                            <input type="date" class="form-control" id="data-final" name="data_final">
                        </div>

                    </div>

                    <button id="bt-pdf-invisible" class="d-none" type="submit"></button>

                </form>



                @break

                @case('storage')


                <form class="formulario" method="GET" role="form" target="_blank"
                      action="{{route('pdf.showRelatorio',['tipo'=>$tipo])}}">

                    <div class="form-row">

                        <div class="form-group col-md-12">
                            <h5 class="titulo">Filtros (opcionais)</h5>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="material">Material</label>
                            <select class="custom-select" id="material" name="material" required>
                                @foreach($materials as $index => $value)
                                    <option value="{{$index}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="qtd_de">Qtd de:</label>
                            <input type="number" class="form-control" id="qtd_de" name="qtd_de">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="qtd_ate">até qtd:</label>
                            <input type="number" class="form-control" id="qtd_ate" name="qtd_ate">
                        </div>

                        <div class="form-group col-md-12 mt-3">
                            <label class="mr-3">Ordenar por quantidade:</label>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="ordenar" value="nao" checked>Não ordenar
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="ordenar" value="ASC">Crescente
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="ordenar" value="DESC">Decrescente
                                </label>
                            </div>
                        </div>


                    </div>

                    <button id="bt-pdf-invisible" class="d-none" type="submit"></button>

                </form>


                @break

                @case('financial')


                <p>AQUI É FINANCEIRO</p>


                @break

                @case('clients')


                <form class="formulario" method="GET" role="form" target="_blank"
                      action="{{route('pdf.showRelatorio',['tipo'=>$tipo])}}">

                    <div class="form-row">

                        <div class="form-group col-md-12">
                            <h5 class="titulo">Filtros (opcionais)</h5>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="status">Situação do cliente</label>
                            <select class="custom-select" id="status" name="status" required>
                                @foreach($status as $index => $value)
                                    <option value="{{$index}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="data-inicial">Cadastrados desde:</label>
                            <input type="date" class="form-control" id="data-inicial" name="data_inicial">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="data-final">até:</label>
                            <input type="date" class="form-control" id="data-final" name="data_final">
                        </div>


                    </div>

                    <button id="bt-pdf-invisible" class="d-none" type="submit"></button>

                </form>


                @break

                @default
                <p>Ocorreu um erro inesperado, reinicie a página!</p>
            @endswitch


            {{--<form class="formulario" method="GET" role="form" target="_blank" action="{{route('pdf.show')}}">

                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="opcao-pdf">Selecione qual deseja visualizar</label>
                        <select class="custom-select" id="opcao-pdf">
                            <option value="orcamento">Orçamentos</option>
                            <option value="ordem">Ordens de serviço</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="opcao" class="obrigatorio">Selecione uma das opções</label>
                        <select class="custom-select" id="opcao" name="idorcamento" required>
                            <option value="" selected>Selecione uma das opções</option>
                            @foreach($budgets as $budget)
                                <option class="orcamento-select-pdf" value="{{$budget->id}}">{{$budget->nome}}</option>
                            @endforeach
                            @foreach($orders as $order)
                                <option class="ordem-select-pdf" value="{{$order->id}}" style="display: none;">{{$order->nome}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <button id="bt-pdf-invisible" class="d-none" type="submit"></button>

            </form>--}}
        </div>
    </div>
@endsection
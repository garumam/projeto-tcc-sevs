@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <button id="bt-order-visible" class="btn btn-primary btn-custom"
                        type="button">{{empty($order) ? 'Adicionar': 'Atualizar'}}</button>
            </div>

            <form class="formulario" method="POST" role="form"
                  action="{{ !empty($order) ? route('orders.update',['id'=> $order->id]) : route('orders.store') }}">
                @if(!empty($order))
                    <input type="hidden" name="_method" value="PATCH">
                @endif
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="data_inicial">Data inicial</label>
                        <input type="date" class="form-control" id="data_inicial" name="data_inicial"
                               placeholder="10/10/2010" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="data_final">Data de entrega</label>
                        <input type="date" class="form-control" id="data_final" name="data_final"
                               placeholder="20/20/2020" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="total">Total</label>
                        <input type="number" class="form-control" id="total" name="total" placeholder="R$" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="select-situacao">Situação</label>
                        <select id="select-situacao" name="situacao" class="custom-select" required>
                            <option value="" selected>Selecione algo...</option>
                            <option value="">Em andamento</option>
                            <option value="">Concluída</option>
                            <option value="">Cancelada</option>
                        </select>
                    </div>

                </div>

                <div class="form-row mt-3 align-items-end">

                    <div class="form-group col-md-4">
                        <label for="select-orcamentos">Orçamentos</label>
                        <select id="select-orcamentos" class="custom-select" required>
                            <option value="" selected>Selecione um orçamento</option>
                            @foreach($budgets as $budget)
                                <option value="{{$budget->id}}">{{$budget->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">

                        <button id="bt-add-orcamento-order" class="btn btn-primary btn-block btn-custom" type="button">
                            Adicionar
                        </button>
                    </div>
                </div>


                <!-- INICIO DA TABELA DE ORÇAMENTO -->
                <div class="form-row">

                    <div class="form-group col-12">
                        <div id="ids">

                        </div>
                    </div>

                    <div class="form-group col-12">
                        <div class="topo">
                            <h4 class="titulo">Orçamentos</h4>
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

                                <tr class="tabela-vidro">
                                    <th class="noborder" scope="col">Id</th>
                                    <th class="noborder" scope="col">Nome</th>
                                    <th class="noborder" scope="col">Data</th>
                                    <th class="noborder" scope="col">Ação</th>
                                </tr>

                                </thead>
                                <tbody>

                                <tr class="tabela-vidro">
                                    <th scope="row">1</th>
                                    <td>Orçamento1</td>
                                    <td>20/20/2020</td>
                                    <td>
                                        <a class="btn-link">
                                            <button class="btn btn-danger mb-1">Delete</button>
                                        </a>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- FIM DA TABELA DE ORÇAMENTO -->

                <button id="bt-order-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
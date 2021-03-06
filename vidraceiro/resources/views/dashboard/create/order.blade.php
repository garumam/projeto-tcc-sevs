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
                    <div class="form-group col-md-12 m-0">
                        @if(session('success'))
                            <div class="alerta p-0">
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            </div>
                        @elseif(session('error'))
                            <div class="alerta p-0">
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
                        <label for="nome" class="obrigatorio">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                               value="{{$order->nome or old('nome')}}" placeholder="Nome" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="data_inicial" class="obrigatorio">Data inicial</label>
                        <input type="date" class="form-control" id="data_inicial" name="data_inicial"
                               value="{{$order->data_inicial or date('Y-m-d', time())}}"
                               required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="data_final" class="obrigatorio">Data de entrega</label>
                        <input type="date" class="form-control" id="data_final" name="data_final"
                               value="{{$order->data_final or old('data_final')}}" required>
                    </div>


                    <div class="form-group col-md-4">
                        <label for="select-situacao" class="obrigatorio">Situação</label>
                        <select id="select-situacao" name="situacao" class="custom-select" required>
                            <option value="" selected>Selecione...</option>
                            <option value="ABERTA" @if(!empty($order)) {{ $order->situacao == 'ABERTA' ? 'selected' : '' }} @endif>
                                Aberta
                            </option>
                            <option value="ANDAMENTO" @if(!empty($order)) {{ $order->situacao == 'ANDAMENTO' ? 'selected' : '' }} @endif>
                                Em andamento
                            </option>
                            <option value="CONCLUIDA" @if(!empty($order)) {{ $order->situacao == 'CONCLUIDA' ? 'selected' : '' }} @endif>
                                Concluída
                            </option>
                            @if(!empty($order))
                            <option value="CANCELADA" @if(!empty($order)) {{ $order->situacao == 'CANCELADA' ? 'selected' : '' }} @endif>
                                Cancelada
                            </option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="total" class="obrigatorio">Total</label>
                        <input type="number" class="form-control" id="total" name="total"
                               value="{{$order->total or old('total')}}" placeholder="R$" required
                               readonly>
                    </div>

                </div>

                <div class="form-row mt-3 align-items-end">

                    <div class="form-group col-md-4">
                        <label for="select-orcamentos">Orçamentos</label>
                        <select id="select-orcamentos" class="custom-select">
                            <option value="" selected>Selecione um orçamento</option>
                            @foreach($budgets as $budget)
                                <option id="option-linha-{{$budget->id}}" name="{{$budget->total}}"
                                        value="{{$budget->id}}">{{$budget->nome}}</option>
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
                            @if(!empty($order))
                                @foreach($budgetsOrders as $budgetOrder)
                                    <input type="number" class="id_orcamento linha-{{$budgetOrder->id}}"
                                           name="id_orcamento[]"
                                           value="{{$budgetOrder->id}}" style="display: none;"/>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group col-12">
                        <div class="topo pl-0">
                            <h4 class="titulo">Orçamentos</h4>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>

                                <tr>
                                    <th class="noborder" scope="col">Id</th>
                                    <th class="noborder" scope="col">Nome</th>
                                    <th class="noborder" scope="col">Total</th>
                                    <th class="noborder" scope="col">Ação</th>
                                </tr>

                                </thead>
                                <tbody>
                                @if(!empty($order))
                                    @foreach($budgetsOrders as $budgetOrder)
                                        <tr id="linha-{{$budgetOrder->id}}">
                                            <th scope="row">{{$budgetOrder->id}}</th>
                                            <td>{{$budgetOrder->nome}}</td>
                                            <td>{{$budgetOrder->total}}</td>
                                            <td>
                                                <button id="linha-{{$budgetOrder->id}}"
                                                        class="deletar-orcamento-tabela btn btn-danger mb-1" type="button">Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

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
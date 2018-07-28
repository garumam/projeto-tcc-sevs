@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a id="bt-order-visible" class="btn-link" href="#">
                    <button class="btn btn-primary btn-block btn-custom" type="button">Adicionar</button>
                </a>
            </div>

            <form class="formulario" method="POST" role="form">
                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"> </input>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="data-init">Data inicial</label>
                        <input type="date" class="form-control" id="data-init" name="data-init" placeholder="10/10/2010"> </input>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="data-entrega">Data de entrega</label>
                        <input type="date" class="form-control" id="data-entrega" name="data-entrega" placeholder="20/20/2020"> </input>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="total">Total</label>
                        <input type="number" class="form-control" id="total" name="total" placeholder=""> </input>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="select-situacao">Situação</label>
                        <select id="select-situacao" name="select" class="custom-select">
                            <option value="">Em aberto</option>
                            <option value="">Em andamento</option>
                            <option value="">Concluída</option>
                            <option value="">Cancelada</option>
                        </select>
                    </div>

                </div>

                <div class="form-row mt-3 align-items-end">

                    <div class="form-group col-md-4">
                        <label for="select-orcamentos">Orçamentos</label>
                        <select id="select-orcamentos" class="custom-select">
                            <option value="0" selected>Selecione um orçamento</option>
                            <option value="">Orçamento 1</option>
                            <option value="">Orçamento 2</option>
                            <option value="">Orçamento 3</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <a class="btn-link mb-3" href="{{ route('orders.create') }}">
                            <button class="btn btn-primary btn-block btn-custom" type="submit">Adicionar
                            </button>
                        </a>
                    </div>
                </div>


                <!-- INICIO DA TABELA DE ORÇAMENTO -->
                <div class="form-row">

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
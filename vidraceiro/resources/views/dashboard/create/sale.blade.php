@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <button id="bt-sale-visible" class="btn btn-primary btn-custom"
                        type="button">Realizar venda</button>
            </div>

            <form class="formulario" method="POST" role="form"
                  action="{{ route('sales.store') }}">
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-12 m-0">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach

                            <div id="erro-js"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="select-orcamento-venda" class="obrigatorio">Orçamento</label>
                        <select id="select-orcamento-venda" class="form-control form-control-chosen" name="orcamento_id" id="orcamento_id" data-placeholder="Selecie um orçamento" style="display: none;">

                                <option value=""
                                        data-cliente="{{0}}"
                                        data-total="{{0}}"
                                        selected >Nada selecionado</option>

                                @foreach ($budgets as $budget)
                                    <option value="{{$budget->id}}"
                                            data-cliente="{{!empty($budget->client)}}"
                                            data-total="{{$budget->total}}"
                                            >{{$budget->nome}}{{!empty($budget->client)?', Cliente: '.$budget->client->nome : ', Cliente: Anônimo'}} </option>
                                @endforeach

                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="total">Total</label>
                        <input type="number" step=".01" name="valor_venda" class="form-control" id="total"
                               value="{{old('total')}}" placeholder="R$" required
                               readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="select-tipo-pagamento">Tipo de pagamento</label>
                        <select id="select-tipo-pagamento" class="custom-select" name="tipo_pagamento">
                            <option value="A VISTA" selected>À vista</option>
                            <option value="A PRAZO">A prazo</option>
                        </select>
                    </div>

                    <div id="qtd_parcelas" class="form-group col-md-4" style="display: none;">
                        <label for="qtd_parc">Quantidade de parcelas</label>
                        <select id="qtd_parc" class="custom-select">
                            @for($i = 1; $i <= 12;$i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>

                    <div id="valor_parcela" class="form-group col-md-4" style="display: none;">
                        <label for="valor_parc">Valor das parcelas</label>
                        <input type="number" step=".01" class="form-control" id="valor_parc" placeholder="R$" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="data_venda">Data da venda</label>
                        <input type="date" class="form-control" id="data_venda" name="data_venda" placeholder="00/00/0000"
                               value="{{date('Y-m-d', time())}}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="desconto">Desconto(R$)</label>
                        <input type="number" step=".01" class="form-control" id="desconto" name="desconto"
                               value="{{old('desconto')}}" placeholder="R$">
                    </div>

                    <div id="entradadisplay" class="form-group col-md-4" style="display: none;">
                        <label for="entrada">Entrada(R$)</label>
                        <input type="number" step=".01" class="form-control" id="entrada"
                               value="{{old('entrada')}}" placeholder="R$">
                    </div>

                    <div id="semjurosdisplay" class="form-check col-md-12 ml-4" style="display: none;">
                        <input type="checkbox" class="form-check-input" data-juros="{{$juros/100}}" name="sem_juros" id="sem_juros">
                        <label class="form-check-label" for="sem_juros">Sem juros</label>
                    </div>

                    <div class="form-check col-md-12 ml-4">
                        <input type="checkbox" class="form-check-input" name="usar_desconto" id="usar_desconto">
                        <label class="form-check-label" for="usar_desconto">Marque se deseja vender como desconto</label>
                    </div>

                    <div class="form-check col-md-12 ml-4">
                        <input type="checkbox" class="form-check-input" name="usar_estoque" id="usar_estoque">
                        <label class="form-check-label" for="usar_estoque">Marque se desejar utilizar materiais disponíveis em estoque para esta venda.</label>
                    </div>


                </div>

                <div class="form-row" style="height: 100px!important;"></div>

                <button id="bt-sale-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
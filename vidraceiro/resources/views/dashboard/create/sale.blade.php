@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <button id="bt-sale-visible" class="btn btn-primary btn-custom"
                        type="button">{{empty($sale) ? 'Realizar venda': 'Atualizar'}}</button>
            </div>

            <form class="formulario" method="POST" role="form"
                  action="{{ !empty($sale) ? route('sales.update',['id'=> $sale->id]) : route('sales.store') }}">
                @if(!empty($sale))
                    <input type="hidden" name="_method" value="PATCH">
                @endif
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
                        <select id="select-orcamento-venda" class="form-control form-control-chosen" name="orcamento_id" data-placeholder="Selecie um orçamento" style="display: none;">

                                <option value=""
                                        data-cliente="{{0}}"
                                        data-total="{{0}}"
                                        selected="{{!empty($sale)?'false':'true'}}" >Nada selecionado</option>

                                @if(!empty($sale))
                                <option value="{{$sale->budget->id}}"
                                        data-cliente="{{!empty($sale->budget->client()->first())}}"
                                        data-total="{{$sale->budget->total}}" selected>{{$sale->budget->nome}}{{!empty($sale->budget->client)?', Cliente: '.$sale->budget->client->nome : ', Cliente: Anônimo'}}</option>
                                @endif
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
                        <input type="number" class="form-control" id="total"
                               @if(!empty($sale))value="{{$sale->budget->total}}"@else value="{{old('total')}}" @endif placeholder="R$" required
                               readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="select-tipo-pagamento">Tipo de pagamento</label>
                        <select id="select-tipo-pagamento" class="custom-select" name="tipo_pagamento">
                            <option value="A VISTA"
                            @if(!empty($sale)) {{$sale->tipo_pagamento == 'A VISTA'? 'selected':''}}@else selected @endif>À vista</option>
                            <option value="A PRAZO"
                            @if(!empty($sale)) {{$sale->tipo_pagamento == 'A PRAZO'? 'selected':''}} @endif>A prazo</option>
                        </select>
                    </div>

                    <div id="qtd_parcelas" class="form-group col-md-4" @if(!empty($sale)) style="{{$sale->tipo_pagamento == 'A VISTA'? 'display: none':''}}"@else style="display: none;" @endif>
                        <label for="qtd_parc">Quantidade de parcelas</label>
                        <select id="qtd_parc" class="custom-select" @if(!empty($sale))name="{{$sale->tipo_pagamento == 'A PRAZO'? 'qtd_parcelas':''}}"@endif>
                            @for($i = 1; $i <= 12;$i++)
                            <option value="{{$i}}"
                                    @if(!empty($sale)) {{$sale->qtd_parcelas == $i? 'selected':''}}@endif>{{$i}}</option>
                            @endfor
                        </select>
                    </div>

                    <div id="valor_parcela" class="form-group col-md-4" @if(!empty($sale)) style="{{$sale->tipo_pagamento == 'A VISTA'? 'display: none':''}}"@else style="display: none;" @endif>
                        <label for="valor_parc">Valor das parcelas</label>
                        <input type="number" class="form-control" id="valor_parc" @if(!empty($sale))name="{{$sale->tipo_pagamento == 'A PRAZO'? 'valor_parcela':''}}"@endif
                               @if(!empty($sale))value="{{$sale->installments->shift()->valor_parcela or ''}}" @endif placeholder="R$"
                               readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="data_venda">Data da venda</label>
                        <input type="date" class="form-control" id="data_venda" name="data_venda" placeholder="00/00/0000"
                               value="{{$sale->data_venda or date('Y-m-d', time())}}">
                    </div>

                    @if(empty($sale))
                        <div class="form-check col-md-12 ml-4">
                            <input type="checkbox" class="form-check-input" name="usar_estoque" id="usar_estoque">
                            <label class="form-check-label" for="usar_estoque">Marque se desejar utilizar materiais disponíveis em estoque para esta venda.</label>
                        </div>
                    @endif

                </div>

                <div class="form-row" style="height: 100px!important;"></div>

                <button id="bt-sale-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
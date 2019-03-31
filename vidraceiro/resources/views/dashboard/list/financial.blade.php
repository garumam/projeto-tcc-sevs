@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <input type="hidden" id="tabSession" data-value="{{session('tab')? session('tab') : ''}}" />
                <div class="nav nav-tabs" id="nav-tab">
                   
                <a class="tabs-financial nav-item nav-link {{ session('tab')? '' : 'current' }}"
                                data-tab="nav-{{$titulotabs[0]}}-tab"
                                data-id="{{lcfirst($titulotabs[0])}}">{{$titulotabs[0]}}</a>
                        
                <a class="tabs-financial nav-item nav-link" data-tab="nav-{{$titulotabs[1]}}-tab"
                                data-id="{{lcfirst($titulotabs[1])}}">{{$titulotabs[1]}}</a>

                <a class="tabs-financial nav-item nav-link" data-tab="nav-{{$titulotabs[2]}}-tab"
                                data-id="{{lcfirst($titulotabs[2])}}">{{$titulotabs[2]}}</a>                
                </div>

        
            <!--Inicio Conteudo de cada tab -->
        
                <div id="nav-{{$titulotabs[0]}}-tab" class="tab-content current">
                    <form class="formulario" method="POST" role="form"
                          action="{{route('financial.store')}}">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-12">

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

                            <div class="form-group col-md-2">
                                <label for="select-tipo" class="obrigatorio">Nova</label>
                                <select id="select-tipo" name="tipo" class="custom-select" required>
                                    <option value="RECEITA" selected>Receita</option>
                                    <option value="DESPESA">Despesa</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="descricao">Descrição</label>
                                <input type="text" maxlength="100" class="form-control" id="descricao" name="descricao">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="data" class="obrigatorio">Data</label>
                                <input type="date" class="form-control" id="data" name="data_vencimento" placeholder="00/00/0000" value="{{date('Y-m-d', time())}}">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="valor" class="obrigatorio">Valor</label>
                                <input type="number" step=".01" class="form-control" id="valor" name="valor" required>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="select-status" class="obrigatorio">Situação da movimentação</label>
                                <select id="select-status" name="status" class="custom-select" required>
                                    <option value="CONFIRMADO" selected>Confirmada</option>
                                    <option value="PENDENTE">Pendente</option>
                                </select>
                            </div>

                            <div class="form-group col-md-2 align-self-end">
                                <button class="btn btn-primary btn-block btn-custom" type="submit">Adicionar</button>
                            </div>
                            @php
                                $receitas = 0.00;
                                $despesas = 0.00;
                                foreach($allfinancial as $financial){
                                    if($financial->tipo === 'RECEITA'){
                                        $receitas += $financial->valor;
                                    }else{
                                        $despesas += $financial->valor;
                                    }
                                }
                                $saldo = number_format(($receitas - $despesas),2,',','.');
                                $receitas = number_format(($receitas),2,',','.');
                                $despesas = number_format(($despesas),2,',','.');
                            @endphp

                            <div class="form-group col-md-12 mt-2 mb-2">
                                <ul class="list-group">
                                    <li class="list-group-item active" style="background-color: #4264FB; border-color: #4264FB">Total geral</li>
                                    <li class="list-group-item" style="color:#28a745;">Total Receitas: R${{$receitas}}</li>
                                    <li class="list-group-item" style="color:#dc3545;">Total Despesas: R${{$despesas}}</li>
                                    <li class="list-group-item" style="color:#191919;">Saldo:
                                        <span style="color:{{$saldo > 0? '#28a745':($saldo < 0?'#dc3545':'')}}">R${{$saldo}}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="form-row col-12 m-0 formulario px-0 justify-content-between">
                                <div class="form-group col-12 col-sm-12 col-md-6 col-lg-2">
                                    <label for="paginatecaixa">Mostrar</label>
                                    <select id="paginatecaixa" name="paginate" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('financial')}}?caixa=1&search='+$('#searchcaixa').val()+'&paginate='+$('#paginatecaixa').val()+'&period='+$('#period').val(),'caixa')">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-12 col-md-6 col-lg-2">
                                    <label for="period">Período</label>
                                    <select id="period" name="period" class="custom-select"
                                            onchange="ajaxPesquisaLoad('{{url('financial')}}?caixa=1&search='+$('#searchcaixa').val()+'&paginate='+$('#paginatecaixa').val()+'&period='+$('#period').val(),'caixa')">
                                        <option value="hoje" selected>Hoje</option>
                                        <option value="semana">Últimos 7 dias</option>
                                        <option value="mes">Últimos 30 dias</option>
                                        <option value="semestre">Últimos 180 dias</option>
                                        <option value="anual">Últimos 360 dias</option>
                                        <option value="tudo">Todos</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-12 col-md-6 col-lg-4">
                                    <label for="searchcaixa">Pesquisar</label>
                                    <input type="text" class="form-control"
                                           onkeyup="ajaxPesquisaLoad('{{url('financial')}}?caixa=1&search='+$('#searchcaixa').val()+'&paginate='+$('#paginatecaixa').val()+'&period='+$('#period').val(),'caixa')"
                                           value="{{ old('search') }}" id="searchcaixa" name="search" placeholder="Pesquisar">
                                </div>
                            </div>

                            <div class="table-responsive text-dark p-1" id="caixa">
                                @include('dashboard.list.tables.table-financial')
                            </div>

                        </div>
                    </form>

                </div>

                <div id="nav-{{$titulotabs[1]}}-tab" class="tab-content">
                    <div class="form-row formulario">

                        @php
                            $receber = 0.00;

                            foreach($pendingFinancials as $object){
                                if($object instanceof App\Installment){
                                    $receber += $object->valor_parcela + $object->multa;
                                }else{
                                    $receber += $object->valor;
                                }
                            }
                            
                            $receber = number_format($receber,2,',','.');
                        @endphp

                        <div class="form-group col-md-12 mt-2 mb-2">
                            <ul class="list-group">
                                <li class="list-group-item active" style="background-color: #4264FB; border-color: #4264FB">Total geral</li>
                                <li class="list-group-item text-dark" >A receber: <span style="color:{{$receber > 0?'#28a745':''}};">R${{$receber}}</span></li>
                            </ul>
                        </div>
                        <div class="form-row col-12 m-0 formulario px-0 justify-content-between">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-2">
                                <label for="paginatereceber">Mostrar</label>
                                <select id="paginatereceber" name="paginate" class="custom-select"
                                        onchange="ajaxPesquisaLoad('{{url('financial')}}?receber=1&search='+$('#searchreceber').val()+'&paginate='+$('#paginatereceber').val(),'receber')">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-4">
                                <label for="searchreceber">Pesquisar</label>
                                <input type="text" class="form-control"
                                       onkeyup="ajaxPesquisaLoad('{{url('financial')}}?receber=1&search='+$('#searchreceber').val()+'&paginate='+$('#paginatereceber').val(),'receber')"
                                       value="{{ old('search') }}" id="searchreceber" name="search" placeholder="Pesquisar">
                            </div>
                        </div>

                        <div class="table-responsive text-dark p-1" id="receber">
                            @php $installAndFinanc = $futureReceipts; //INICIANDO VARIAVEL QUE SERÁ UTILIZADA ENTRO DA TABELA @endphp
                            @include('dashboard.list.tables.table-receber-pagar')
                        </div>

                    </div>
                </div>
            
                <div id="nav-{{$titulotabs[2]}}-tab" class="tab-content">
                    <div class="form-row formulario">

                        @php
                            $pagar = 0.00;

                            foreach($payPending as $object){
                                
                                $pagar += $object->valor;
                        
                            }
                            
                            $pagar = number_format($pagar,2,',','.');
                        @endphp

                        <div class="form-group col-md-12 mt-2 mb-2">
                            <ul class="list-group">
                                <li class="list-group-item active" style="background-color: #4264FB; border-color: #4264FB">Total geral</li>
                                <li class="list-group-item text-dark" >A pagar: <span style="color:{{$pagar > 0?'#dc3545':''}};">R${{$pagar}}</span></li>
                            </ul>
                        </div>
                        <div class="form-row col-12 m-0 formulario px-0 justify-content-between">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-2">
                                <label for="paginatepagar">Mostrar</label>
                                <select id="paginatepagar" name="paginate" class="custom-select"
                                        onchange="ajaxPesquisaLoad('{{url('financial')}}?pagar=1&search='+$('#searchpagar').val()+'&paginate='+$('#paginatepagar').val(),'pagar')">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-4">
                                <label for="searchpagar">Pesquisar</label>
                                <input type="text" class="form-control"
                                       onkeyup="ajaxPesquisaLoad('{{url('financial')}}?pagar=1&search='+$('#searchpagar').val()+'&paginate='+$('#paginatepagar').val(),'pagar')"
                                       value="{{ old('search') }}" id="searchpagar" name="search" placeholder="Pesquisar">
                            </div>
                        </div>

                        <div class="table-responsive text-dark p-1" id="pagar">
                            @php $installAndFinanc = $futurePayments; //INICIANDO VARIAVEL QUE SERÁ UTILIZADA ENTRO DA TABELA @endphp
                            @include('dashboard.list.tables.table-receber-pagar')
                        </div>

                    </div>
                </div>
            <!--Final Conteudo de cada tab -->

        </div>
    </div>
@endsection

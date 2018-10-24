@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

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

                    <div class="form-group col-md-2">
                        <label for="valor" class="obrigatorio">Valor</label>
                        <input type="number" step=".01" class="form-control" id="valor" name="valor" required>
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
                        $saldo = $receitas - $despesas;
                    @endphp

                    <div class="form-group col-md-12 mt-2 mb-2">
                        <ul class="list-group">
                            <li class="list-group-item active" style="background-color: #4264FB;">Total geral</li>
                            <li class="list-group-item" style="color:#28a745;">Total Receitas: R${{$receitas}}</li>
                            <li class="list-group-item" style="color:#dc3545;">Total Despesas: R${{$despesas}}</li>
                            <li class="list-group-item" style="color:#191919;">Saldo:
                                <span style="color:{{$saldo > 0? '#28a745':($saldo < 0?'#dc3545':'')}}">R${{$saldo}}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="form-row col-12 m-0 formulario px-0 justify-content-between">
                        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-2">
                            <label for="paginate">Mostrar</label>
                            <select id="paginate" name="paginate" class="custom-select"
                                    onchange="ajaxPesquisaLoad('{{url('financial')}}?search='+$('#search').val()+'&paginate='+$('#paginate').val()+'&period='+$('#period').val())">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-2">
                            <label for="period">Período</label>
                            <select id="period" name="period" class="custom-select"
                                    onchange="ajaxPesquisaLoad('{{url('financial')}}?search='+$('#search').val()+'&paginate='+$('#paginate').val()+'&period='+$('#period').val())">
                                <option value="hoje" selected>Hoje</option>
                                <option value="semana">Últimos 7 dias</option>
                                <option value="mes">Últimos 30 dias</option>
                                <option value="semestre">Últimos 180 dias</option>
                                <option value="anual">Últimos 360 dias</option>
                                <option value="tudo">Todos</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-sm-12 col-md-6 col-lg-4">
                            <label for="search">Pesquisar</label>
                            <input type="text" class="form-control"
                                   onkeyup="ajaxPesquisaLoad('{{url('financial')}}?search='+$('#search').val()+'&paginate='+$('#paginate').val()+'&period='+$('#period').val())"
                                   value="{{ old('search') }}" id="search" name="search" placeholder="Pesquisar">
                        </div>
                    </div>

                    <div class="table-responsive text-dark p-1" id="content">
                        @include('dashboard.list.tables.table-financial')
                    </div>

                </div>
            </form>

        </div>
    </div>
@endsection

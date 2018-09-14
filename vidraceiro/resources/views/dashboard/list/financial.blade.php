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
                        foreach($financials as $financial){
                            if($financial->tipo === 'RECEITA'){
                                $receitas += $financial->valor;
                            }else{
                                $despesas += $financial->valor;
                            }
                        }
                        $saldo = $receitas - $despesas;
                    @endphp
                    <div class="form-group col-md-12 mb-2 mt-4 border">
                        <div class="form-group col-md-12 border-bottom mt-2 mb-2">
                        <label style="color:#28a745;">Total Receitas: </label>
                        <label style="color:#28a745;">R${{$receitas}} </label>
                        </div>
                        <div class="form-group col-md-12 border-bottom mt-2 mb-2">
                        <label style="color:#dc3545;">Total Despesas: </label>
                        <label style="color:#dc3545;">R${{$despesas}}</label>
                        </div>
                        <div class="form-group col-md-12 mt-3 mb-2">
                        <label>Saldo: </label>
                        <label>R${{$saldo}}</label>
                        </div>
                    </div>


                    <div class="form-group col-12">
                        <div class="table-responsive text-dark p-2">
                            @include('layouts.htmltablesearch')
                            <table class="table table-hover search-table" style="margin: 6px 0 6px 0;">
                                <thead>

                                <tr class="tabela-vidro">
                                    <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
                                    <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Tipo</th>
                                    <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Descrição</th>
                                    <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Valor</th>
                                    <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
                                </tr>

                                </thead>
                                <tbody>

                                @foreach($financials as $financial)
                                    <tr class="tabela-vidro">
                                        <th scope="row">{{ $financial->id }}</th>
                                        @if($financial->tipo === 'RECEITA')
                                        <td><span class="badge badge-success">Receita</span></td>
                                        @else
                                        <td><span class="badge badge-danger">Despesa</span></td>
                                        @endif
                                        <td>{{ $financial->descricao??'' }}</td>
                                        @if($financial->tipo === 'RECEITA')
                                        <td style="color:#28a745;">R${{ $financial->valor }}</td>
                                        @else
                                        <td style="color:#dc3545;">R${{ $financial->valor }}</td>
                                        @endif
                                        <td>
                                            <a class="btn-link" onclick="deletar(this.id,'financial')" id="{{ $financial->id }}">
                                                <button class="btn btn-danger mb-1" title="Deletar"><i class="fas fa-trash-alt"></i></button>
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach


                                </tbody>
                            </table>

                            @if(!empty($financials->shift()))
                                @include('layouts.htmlpaginationtable')
                            @endif

                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
@endsection

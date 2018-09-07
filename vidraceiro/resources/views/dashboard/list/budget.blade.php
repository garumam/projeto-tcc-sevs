@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn-link" href="{{ route('budgets.create') }}">
                    <button class="btn btn-primary btn-block btn-custom" type="submit">Adicionar</button>
                </a>
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

            <div class="table-responsive text-dark p-2">
                @include('layouts.htmltablesearch')
                <table class="table table-hover search-table" style="margin: 6px 0px 6px 0px;">
                    <thead>
                    <tr>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Nome</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Data</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Total</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Status</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($budgets as $budget)
                        <tr>
                            <th scope="row">{{ $budget->id }}</th>
                            <td>{{$budget->nome}}</td>
                            <td>{{date_format(date_create($budget->data), 'd/m/Y')}}</td>
                            <td>R${{empty($budget->total) ? 0 : $budget->total}}</td>
                            <td><span class="badge badge-secondary">{{$budget->status}}</span></td>
                            <td>


                                @php
                                    $ordem = $budget->order()->first();
                                    $sale = $budget->sale()->first();
                                    $parcela = $sale === null? $sale : $sale->installments()->where('status_parcela','ABERTO')->first();
                                    $editar = $deletar = true;
                                @endphp

                                @if(!empty($ordem))
                                    @if($ordem->situacao === 'ANDAMENTO')
                                        @php $editar = $deletar = false; @endphp
                                    @endif
                                @endif

                                @if(!empty($parcela))
                                    @php $editar = $deletar = false; @endphp
                                @endif

                                @if($budget->status === 'FINALIZADO')
                                    @php $editar = false; @endphp
                                @endif

                                @if($editar)
                                    <a class="btn-link" href="{{ route('budgets.edit',['id'=> $budget->id]) }}">
                                        <button class="btn btn-warning mb-1">Editar</button>
                                    </a>
                                @endif
                                @if($deletar)
                                    <a class="btn-link" onclick="deletar(this.id,'budgets/budget')" id="{{ $budget->id }}">
                                        <button class="btn btn-danger mb-1">Deletar</button>
                                    </a>
                                @endif

                                {{--@if($budget->ordem_id !== null)

                                    @if($budget->order()->first()->situacao !== 'ANDAMENTO')
                                        @if($budget->status === 'AGUARDANDO')
                                            <a class="btn-link" href="{{ route('budgets.edit',['id'=> $budget->id]) }}">
                                                <button class="btn btn-warning mb-1">Editar</button>
                                            </a>
                                        @endif
                                        <a class="btn-link" onclick="deletar(this.id,'budgets/budget')" id="{{ $budget->id }}">
                                            <button class="btn btn-danger mb-1">Deletar</button>
                                        </a>
                                    @else
                                        <b>Ordem de serviço em andamento!</b>
                                    @endif
                                @else
                                    @if($budget->status === 'AGUARDANDO')
                                        <a class="btn-link" href="{{ route('budgets.edit',['id'=> $budget->id]) }}">
                                            <button class="btn btn-warning mb-1">Editar</button>
                                        </a>
                                    @endif
                                    <a class="btn-link" onclick="deletar(this.id,'budgets/budget')" id="{{ $budget->id }}">
                                        <button class="btn btn-danger mb-1">Deletar</button>
                                    </a>
                                @endif--}}


                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @include('layouts.htmlpaginationtable')
                <p class="info-importante">Não é possível deletar ou editar orçamento relacionado a ordem serviço em andando ou que está com pagamento pendente!</p>
                <p class="info-importante">Não é possível editar orçamento finalizado!</p>
            </div>
        </div>
    </div>

@endsection
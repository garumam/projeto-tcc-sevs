@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn-link" href="{{ route('clients.create') }}">
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
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Cpf | Cnpj</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Telefone</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Situação</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <th scope="row">{{$client->id}}</th>
                            <td>{{$client->nome}}</td>
                            <td>{{$client->cpf or $client->cnpj}}</td>
                            <td class="telefone">{{$client->telefone}}</td>
                            <td><span class="badge badge-secondary">{{$client->status}}</span></td>
                            <td>


                                @php
                                    $editar = $deletar = true;
                                    $ordem = null;
                                    foreach($client->budgets as $budget){
                                        $ordem = $budget->order()->first();
                                        if(!empty($ordem)){

                                            if($ordem->situacao === 'ANDAMENTO'){
                                                $deletar = false;
                                                break;
                                            }

                                        }
                                        $sale = $budget->sale()->first();
                                        $parcela = $sale === null? $sale : $sale->installments()->where('status_parcela','ABERTO')->first();
                                        if(!empty($parcela)){
                                            $deletar = false;
                                            break;
                                        }
                                    }

                                @endphp


                                <a class="btn-link" href="{{ route('clients.edit',['id'=> $client->id]) }}">
                                    <button class="btn btn-warning mb-1" title="Editar"><i class="fas fa-edit"></i></button>
                                </a>

                                @if($deletar)
                                    <a class="btn-link" onclick="deletar(this.id,'clients')" id="{{ $client->id }}">
                                        <button class="btn btn-danger mb-1" title="Deletar"><i class="fas fa-trash-alt"></i></button>
                                    </a>
                                @endif

                                {{--@if(!empty($client->budgets()))
                                    @php $emandamento = $devendo = false; @endphp
                                    @foreach($client->budgets as $budget)
                                        @php $ordem= $budget->order()->first(); @endphp
                                        @if(!empty($ordem))
                                            @if($budget->order()->first()->situacao === 'ANDAMENTO')
                                                @php $emandamento = true; @endphp
                                                @break
                                            @endif
                                        @endif
                                        @php $sale = $budget->sale()->first(); @endphp
                                        @if(!empty($sale))

                                            @if(!empty($sale->installments()->where('status_parcela','ABERTO')->first()))
                                                @php $devendo = true; @endphp
                                                @break
                                            @endif
                                        @endif
                                    @endforeach
                                    @if(!$emandamento && !$devendo)
                                        <a class="btn-link" onclick="deletar(this.id,'clients')" id="{{ $client->id }}">
                                            <button class="btn btn-danger mb-1">Deletar</button>
                                        </a>
                                    @endif
                                @else
                                    <a class="btn-link" onclick="deletar(this.id,'clients')" id="{{ $client->id }}">
                                        <button class="btn btn-danger mb-1">Deletar</button>
                                    </a>
                                @endif--}}

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if(!empty($clients->shift()))
                    @include('layouts.htmlpaginationtable')
                @endif
                <p class="info-importante">Não é possível deletar cliente relacionado a ordem serviço em andando ou que está com pagamento pendente!</p>
            </div>
        </div>
    </div>

@endsection


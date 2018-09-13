@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn-link" href="{{ route('orders.create') }}">
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
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Situação</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Data inicial</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Data final</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Total</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <th scope="row">{{$order->id}}</th>
                            <td>{{$order->nome}}</td>
                            <td><span class="badge badge-secondary">{{ucfirst($order->situacao)}}</span></td>
                            <td>{{date_format(date_create($order->data_inicial), 'd/m/Y')}}</td>
                            <td>{{date_format(date_create($order->data_final), 'd/m/Y')}}</td>
                            <td>R${{$order->total}}</td>
                            <td>
                                @if(!($order->situacao === 'CONCLUIDA') && !($order->situacao === 'CANCELADA'))
                                <a class="btn-link" href="{{ route('orders.edit',['id'=> $order->id]) }}">
                                    <button class="btn btn-warning mb-1">Editar</button>
                                </a>
                                @endif
                                <a class="btn-link" onclick="deletar(this.id,'orders')" id="{{$order->id}}">
                                    <button class="btn btn-danger mb-1">Deletar</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if(!empty($orders->shift()))
                    @include('layouts.htmlpaginationtable')
                @endif

            </div>
        </div>
    </div>

@endsection
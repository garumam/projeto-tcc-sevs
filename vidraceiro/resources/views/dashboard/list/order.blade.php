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

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="noborder" scope="col">Id</th>
                        <th class="noborder" scope="col">Nome</th>
                        <th class="noborder" scope="col">Situação</th>
                        <th class="noborder" scope="col">Data inicial</th>
                        <th class="noborder" scope="col">Data final</th>
                        <th class="noborder" scope="col">Total</th>
                        <th class="noborder" scope="col">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <th scope="row">{{$order->id}}</th>
                            <td>{{$order->nome}}</td>
                            <td>{{$order->situacao}}</td>
                            <td>{{$order->data_inicial}}</td>
                            <td>{{$order->data_final}}</td>
                            <td>R${{$order->total}}</td>
                            <td>
                                <a class="btn-link" href="{{ route('orders.edit',['id'=> $order->id]) }}">
                                    <button class="btn btn-warning mb-1">Edit</button>
                                </a>
                                <a class="btn-link" onclick="deletar(this.id,'orders')" id="{{$order->id}}">
                                    <button class="btn btn-danger mb-1">Delete</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>

@endsection
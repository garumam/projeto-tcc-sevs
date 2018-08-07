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

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="noborder" scope="col">Id</th>
                        <th class="noborder" scope="col">Nome</th>
                        <th class="noborder" scope="col">Data</th>
                        <th class="noborder" scope="col">Total</th>
                        <th class="noborder" scope="col">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($budgets as $budget)
                        <tr>
                            <th scope="row">{{ $budget->id }}</th>
                            <td>{{$budget->nome}}</td>
                            <td>{{$budget->data}}</td>
                            <td>R${{$budget->total}}</td>
                            <td>
                                <a class="btn-link" href="{{ route('budgets.edit',['id'=> $budget->id]) }}">
                                    <button class="btn btn-warning mb-1">Edit</button>
                                </a>
                                <a class="btn-link" onclick="deletar(this.id,'budgets')" id="{{ $budget->id }}">
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
@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn-link" href="{{ route('mproducts.create') }}">
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
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Produto</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Descrição</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Categoria</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($mProducts as $mProduct)
                        <tr>
                            <th scope="row">{{ $mProduct->id }}</th>
                            <td>{{ $mProduct->nome }}</td>
                            <td>{{ $mProduct->descricao }}</td>
                            <td>{{ $mProduct->category->nome }}</td>
                            <td>
                                <a class="btn-link" href="{{ route('mproducts.edit',['id'=> $mProduct->id]) }}">
                                    <button class="btn btn-warning mb-1" title="Editar"><i class="fas fa-edit"></i></button>
                                </a>
                                <a class="btn-link" onclick="deletar(this.id,'products')" id="{{ $mProduct->id }}">
                                    <button class="btn btn-danger mb-1" title="Deletar"><i class="fas fa-trash-alt"></i></button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if(!empty($mProducts->shift()))
                    @include('layouts.htmlpaginationtable')
                @endif

            </div>
        </div>
    </div>

@endsection
@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn-link" href="{{ route('providers.create') }}">
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
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">E-mail</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Situação</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($providers as $provider)
                        <tr>
                            <th scope="row">{{ $provider->id }}</th>
                            <td>{{ $provider->nome }}</td>
                            <td>{{ $provider->email }}</td>
                            <td><span class="badge {{$provider->situacao == "ativo" ? 'badge-success' : 'badge-secondary'}}">{{ ucfirst($provider->situacao) }}</span></td>
                            <td>
                                <a class="btn-link" href="{{ route('providers.edit',['id' => $provider->id]) }}">
                                    <button class="btn btn-warning mb-1">Editar</button>
                                </a>
                                <a class="btn-link" onclick="deletar(this.id,'providers')" id="{{ $provider->id }}">
                                    <button class="btn btn-danger mb-1">Deletar</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if(!empty($providers->shift()))
                    @include('layouts.htmlpaginationtable')
                @endif

            </div>


        </div>
    </div>

@endsection
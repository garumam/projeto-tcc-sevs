@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn-link" href="{{ route('roles.create') }}">
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
                <table class="table table-hover search-table" style="margin: 6px 0 6px 0;">
                    <thead>
                    <tr>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Nome</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Descrição</th>
                        <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <th scope="row">{{ $role->id }}</th>
                            <td>{{ $role->nome }}</td>
                            <td>{{ $role->descricao }}</td>
                            <td>
                                <a class="btn-link" href="{{ route('roles.edit',['id' => $role->id]) }}">
                                    <button class="btn btn-warning mb-1" {{$role->nome === 'admin' ? 'disabled' :'' }}>
                                        Editar
                                    </button>
                                </a>
                                <a class="btn-link" href="{{ route('roles.permission.show',['id' => $role->id]) }}">
                                    <button class="btn btn-dark mb-1" {{$role->nome === 'admin' ? 'disabled' :'' }}>
                                        Permissão
                                    </button>
                                </a>
                                <a class="btn-link" onclick="deletar(this.id,'roles')" id="{{ $role->id }}">
                                    <button class="btn btn-danger mb-1" {{$role->nome === 'admin' ? 'disabled' :'' }}>
                                        Deletar
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @include('layouts.htmlpaginationtable')

            </div>
        </div>
    </div>

@endsection

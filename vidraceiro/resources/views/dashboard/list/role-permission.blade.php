@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}} {{ 'do '.$role->nome}}</h4>
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
            <div class="col-6">
                <form action="{{route('roles.permission.store',$role->id)}}" class="d-flex py-4" method="POST">
                    @csrf
                    <select class="form-control form-control-chosen" name="permission_id">
                        <option value="">Selecione</option>
                        @foreach($permissions as $permission)
                            <option value="{{$permission->id}}">{{$permission->nome}}</option>
                        @endforeach
                    </select>
                    <a class="btn-link ml-4">
                        <button class="btn btn-primary btn-block btn-custom" type="submit">Adicionar</button>
                    </a>
                </form>
            </div>

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
                    @foreach($role->permissions as $permission)
                        <tr>
                            <th scope="row">{{ $permission->id }}</th>
                            <td>{{ $permission->nome }}</td>
                            <td>{{ $permission->descricao }}</td>
                            <td>
                                {{--<a class="btn-link" href="{{ route('roles.edit',['id' => $role->id]) }}">--}}
                                {{--<button class="btn btn-warning mb-1" {{$role->nome === 'admin' ? 'disabled' :'' }}>--}}
                                {{--Editar--}}
                                {{--</button>--}}
                                {{--</a>--}}
                                <a class="btn-link" onclick="deletar(this.id,'roles/permission')"
                                   id="{{ $role->id .'/'.$permission->id }}">
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

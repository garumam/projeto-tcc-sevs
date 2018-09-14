@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}} {{ 'do '.$user->name}}</h4>

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
                <form action="{{route('users.role.store',$user->id)}}" class="d-flex py-4" method="POST">
                    @csrf
                    <select class="custom-select" name="role_id">
                        <option value="">Selecione</option>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->nome}}</option>
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
                    @foreach($user->roles as $role)
                        <tr>
                            <th scope="row">{{ $role->id }}</th>
                            <td>{{ $role->nome }}</td>
                            <td>{{ $role->descricao }}</td>
                            <td>
                                {{--<a class="btn-link" href="{{ route('roles.edit',['id' => $role->id]) }}">--}}
                                {{--<button class="btn btn-warning mb-1" {{$role->nome === 'admin' ? 'disabled' :'' }}>--}}
                                {{--Editar--}}
                                {{--</button>--}}
                                {{--</a>--}}
                                <a class="btn-link" onclick="deletar(this.id,'users/role')"
                                   id="{{ $user->id .'/'.$role->id }}">
                                    <button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar" {{$role->nome === 'admin' ? 'disabled' :'' }}>
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if(!empty($user->roles->shift()))
                    @include('layouts.htmlpaginationtable')
                @endif

            </div>
        </div>
    </div>

@endsection

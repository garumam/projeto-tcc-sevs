@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn-link" href="{{ route('users.create') }}">
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
                        <th class="noborder" scope="col">E-mail</th>
                        <th class="noborder" scope="col">Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a class="btn-link" href="{{ route('users.edit',['id' => $user->id]) }}">
                                    <button class="btn btn-warning mb-1">Edit</button>
                                </a>
                                <a class="btn-link" onclick="event.preventDefault(); document.getElementById('del-user-{{ $user
                                 ->id}}').submit();">
                                    <button class="btn btn-danger mb-1">Delete</button>
                                </a>
                                <form id="del-user-{{ $user->id }}"
                                      action="{{ route('users.destroy',['id' => $user->id]) }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <p>Sem usuarios</p>
                    @endforelse

                    </tbody>
                </table>


            </div>
        </div>
    </div>

@endsection
@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn-link" href="{{ route('createUser') }}"><button class="btn btn-primary btn-block btn-custom" type="submit">Adicionar</button></a>

            </div>

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
                                <a class="btn-link" href="{{ route('updateUser',['id' => $user->id]) }}"> <button class="btn btn-warning mb-1">Edit</button></a>
                                <a class="btn-link" href="{{ route('deleteUser',['id' => $user->id]) }}"><button class="btn btn-danger mb-1">Delete</button></a>
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
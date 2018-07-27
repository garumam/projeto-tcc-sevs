@extends('layouts.app')
@section('content')
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <a class="btn-link" href="{{ route('category.create') }}">
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
                        <th class="noborder" scope="col">Tipo</th>
                        <th class="noborder" scope="col">Grupo de imagens</th>
                        <th class="noborder" scope="col">Ação</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <th scope="row">1</th>
                        <td>Box diversos</td>
                        <td>Vidro</td>
                        <td>Box diversos</td>
                        <td>
                            <a class="btn-link" href="#">
                                <button class="btn btn-warning mb-1">Edit</button>
                            </a>
                            <a class="btn-link">
                                <button class="btn btn-danger mb-1">Delete</button>
                            </a>

                        </td>
                    </tr>

                    </tbody>
                </table>


            </div>
        </div>
    </div>
    <form id="del-produto" action="#" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
    </form>

@endsection
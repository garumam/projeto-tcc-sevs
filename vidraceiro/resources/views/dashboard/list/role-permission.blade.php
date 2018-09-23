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

            <form action="{{route('roles.permission.store',$role->id)}}" class="d-flex flex-wrap pt-4" method="POST">
                @csrf
                <div class="col-12 col-lg-5 mb-4">
                    <select class="custom-select" name="permission_id">
                        <option value="">Selecione</option>
                        @foreach($permissions as $permission)
                            <option value="{{$permission->id}}">{{$permission->nome}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-lg-3 mb-4">
                    <button class="btn btn-primary btn-block btn-custom" type="submit">Adicionar</button>
                </div>
            </form>

            <div class="form-row formulario pb-0 justify-content-between">
                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                    <label for="paginate">Mostrar</label>
                    <select id="paginate" name="paginate" class="custom-select"
                            onchange="ajaxPesquisaLoad('{{url('roles/permission/'.$role->id)}}?search='+$('#search').val()+'&paginate='+$('#paginate').val())">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                    <label for="search">Pesquisar</label>
                    <input type="text" class="form-control"
                           onkeyup="ajaxPesquisaLoad('{{url('roles/permission/'.$role->id)}}?search='+$('#search').val()+'&paginate='+$('#paginate').val())"
                           value="{{ old('search') }}" id="search" name="search" placeholder="Pesquisar">
                </div>
            </div>

            <div class="table-responsive text-dark p-2" id="content">
                @include('dashboard.list.tables.table-role-permission')
            </div>
        </div>
    </div>

@endsection

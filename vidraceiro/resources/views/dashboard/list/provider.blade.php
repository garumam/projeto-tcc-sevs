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

            {{--<div class="table-responsive text-dark p-2">--}}
            {{--@include('layouts.htmltablesearch')--}}
            {{--<table class="table table-hover search-table" style="margin: 6px 0px 6px 0px;">--}}
            {{--<thead>--}}
            {{--<tr>--}}
            {{--<th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Id</th>--}}
            {{--<th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Nome</th>--}}
            {{--<th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">E-mail</th>--}}
            {{--<th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Situação</th>--}}
            {{--<th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Ação</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--@foreach($providers as $provider)--}}
            {{--<tr>--}}
            {{--<th scope="row">{{ $provider->id }}</th>--}}
            {{--<td>{{ $provider->nome }}</td>--}}
            {{--<td>{{ $provider->email }}</td>--}}
            {{--<td><span class="badge {{$provider->situacao == "ativo" ? 'badge-success' : 'badge-secondary'}}">{{ ucfirst($provider->situacao) }}</span></td>--}}
            {{--<td>--}}
            {{--<a class="btn-link" href="{{ route('providers.edit',['id' => $provider->id]) }}">--}}
            {{--<button class="btn btn-warning mb-1 card-shadow-1dp pl-2 pr-2" title="Editar"><i class="fas fa-edit pl-1"></i></button>--}}
            {{--</a>--}}
            {{--<a class="btn-link" onclick="deletar(this.id,'providers')" id="{{ $provider->id }}">--}}
            {{--<button class="btn btn-danger mb-1 card-shadow-1dp" title="Deletar"><i class="fas fa-trash-alt"></i></button>--}}
            {{--</a>--}}
            {{--</td>--}}
            {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
            {{--</table>--}}

            {{--@if(!empty($providers->shift()))--}}
            {{--@include('layouts.htmlpaginationtable')--}}
            {{--@endif--}}

            {{--</div>--}}

            <div class="form-row formulario pb-0 justify-content-between">
                <div class="form-group col-12 col-sm-4 col-md-3 col-lg-1">
                    <label for="paginate">Mostrar</label>
                    <select id="paginate" name="paginate" class="custom-select"
                            onchange="ajaxPesquisaLoad('{{url('providers')}}?search='+$('#search').val()+'&paginate='+$('#paginate').val())">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="form-group col-12 col-sm-5 col-md-6 col-lg-4">
                    <label for="search">Pesquisar</label>
                    <input type="text" class="form-control"
                           onkeyup="ajaxPesquisaLoad('{{url('providers')}}?search='+$('#search').val()+'&paginate='+$('#paginate').val())"
                           value="{{ old('search') }}" id="search" name="search" placeholder="Pesquisar">
                </div>
            </div>
            <div class="table-responsive text-dark p-2" id="content">
                @include('dashboard.list.tables.tableprovider')
            </div>
        </div>
    </div>

@endsection
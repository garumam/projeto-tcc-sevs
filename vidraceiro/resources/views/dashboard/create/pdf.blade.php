@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}} </h4>
                <button id="bt-pdf-visible" class="btn btn-primary btn-custom" type="button">Gerar PDF</button>
            </div>

            <form class="formulario" method="POST" role="form" action="{{route('pdf.create')}}">
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="orcamento">Selecione um Orçamento</label>
                        <select class="custom-select" id="orcamento" required>
                            <option value="" selected>Selecione...</option>
                            <option value="">Orçamento 1</option>
                        </select>
                    </div>

                </div>

                <button id="bt-pdf-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
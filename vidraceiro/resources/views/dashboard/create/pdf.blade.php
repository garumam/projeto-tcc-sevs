@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}} </h4>
                <button id="bt-pdf-visible" class="btn btn-primary btn-custom" href="{{route('pdf.show')}}" type="button">Gerar PDF</button>

            </div>

            <form class="formulario" method="GET" role="form" target="_blank" action="{{route('pdf.show')}}">

                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="opcao-pdf">Selecione qual deseja visualizar</label>
                        <select class="custom-select" id="opcao-pdf">
                            <option value="orcamento">Orçamentos</option>
                            <option value="ordem">Ordens de serviço</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="opcao">Selecione uma das opções</label>
                        <select class="custom-select" id="opcao" name="idorcamento" required>
                            <option value="" selected>Selecione uma das opções</option>
                            @foreach($budgets as $budget)
                                <option class="orcamento-select-pdf" value="{{$budget->id}}">{{$budget->nome}}</option>
                            @endforeach
                            @foreach($orders as $order)
                                <option class="ordem-select-pdf" value="{{$order->id}}" style="display: none;">{{$order->nome}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <button id="bt-pdf-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
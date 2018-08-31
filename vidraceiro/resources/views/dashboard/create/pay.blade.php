@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <button id="bt-sale-visible" class="btn btn-primary btn-custom"
                        type="button">Efetuar pagamento</button>
            </div>

            <form class="formulario" method="POST" role="form"
                  action="{{route('sales.payupdate',['id'=> $sale->id])}}">
                @if(!empty($sale))
                    <input type="hidden" name="_method" value="PATCH">
                @endif
                @csrf

                <div class="form-row">

                    <div class="col-12">
                        @if(session('success'))
                            <div class="alerta p-0">
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            </div>
                        @elseif(session('error'))
                            <div class="alerta p-0">
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            </div>
                        @endif
                    </div>


                    <div class="form-group col-md-4">
                        <label for="venda">Id da venda</label>
                        <input type="text" class="form-control" id="venda"
                               value="{{$sale->id or ''}}" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cliente">Cliente</label>
                        <input type="text" class="form-control" id="cliente"
                               value="{{$sale->budget->client->nome or ''}}" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="data_pagamento" class="obrigatorio">Data de pagamento</label>
                        <input type="date" class="form-control" id="data_pagamento" name="data_pagamento" placeholder="00/00/0000"
                               value="{{date('Y-m-d')}}" required>
                    </div>
                </div>
                <div class="form-row">

                    <table class="table table-hover" style="margin: 6px 0px 6px 0px;">
                        <thead>
                        <tr>
                            <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">N° da parcela</th>
                            <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Data de vencimento</th>
                            <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Valor da parcela</th>
                            <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Status</th>
                            <th class="noborder" scope="col" style="padding: 12px 30px 12px 16px;">Pagar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $contador = 0; @endphp
                        @foreach($sale->installments as $installment)
                            @php $contador++; @endphp
                            <tr>
                                <th scope="row">{{$contador}}</th>
                                <td>{{date_format(date_create($installment->data_vencimento), 'd/m/Y')}}</td>
                                <td>{{$installment->valor_parcela}}</td>
                                <td>{{$installment->status_parcela}}</td>
                                <td>
                                    <input type="checkbox" class="form-check-input" @if($installment->status_parcela === 'ABERTO') name="parcelas[]" @else checked disabled @endif id="parcelas" value="{{$installment->id}}">
                                    <label class="form-check-label" for="parcelas">{{$installment->status_parcela === 'ABERTO'? 'Pagar' : 'Pago'}}</label>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>


                </div>

                <button id="bt-sale-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}}</h4>
                <button id="bt-client-visible" class="btn btn-primary btn-custom"
                        type="button">{{empty($client) ? 'Adicionar': 'Atualizar'}}</button>
            </div>

            <form class="formulario" method="POST" role="form"
                  action="{{ !empty($client) ? route('clients.update',['id'=> $client->id]) : route('clients.store') }}">
                @if(!empty($client))
                    <input type="hidden" name="_method" value="PATCH">
                @endif
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-12 m-0">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach

                            <div id="erro-js"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="nome" class="obrigatorio">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="{{$client->nome or old('nome')}}"
                               placeholder="Nome" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="select-documento">Selecione um tipo de documento</label>
                        <select id="select-documento" class="custom-select">
                            <option value="cpf" @if(!empty($client)){{strlen($client->documento) <= 11? 'selected':''}}@else {{'selected'}} @endif>CPF</option>
                            <option value="cnpj" @if(!empty($client)){{strlen($client->documento) > 11? 'selected':''}}@endif>CNPJ</option>
                        </select>
                    </div>

                    <div id="doc-cpf-input" class="form-group col-md-4" @if(!empty($client))style="{{strlen($client->documento) <= 11? '':'display: none'}}"@endif>
                        <label for="cpf" class="obrigatorio">Cpf</label>
                        <input type="text" class="form-control" id="cpf" @if(!empty($client))name="{{strlen($client->documento) <= 11? 'documento':''}}"@else name="documento" @endif value="{{$client->documento or old('cpf')}}"
                               placeholder="cpf"  @if(!empty($client)){{strlen($client->documento) <= 11? 'required':''}} @else required @endif>
                    </div>

                    <div id="doc-cnpj-input" class="form-group col-md-4" @if(!empty($client))style="{{strlen($client->documento) > 11? '':'display: none'}}"@else style="display: none" @endif>
                        <label for="cnpj" class="obrigatorio">Cnpj</label>
                        <input type="text" class="form-control" id="cnpj" @if(!empty($client))name="{{strlen($client->documento) > 11? 'documento':''}}"@endif value="{{$client->documento or old('cnpj')}}"
                               placeholder="cnpj" @if(!empty($client)){{strlen($client->documento) > 11? 'required':''}}@endif>
                    </div>
                    
                    @php 
                    if(!empty($client)){
                        $location = $client->location()->first();
                        $contact = $client->contact()->first();
                    } 
                    @endphp

                    <div class="form-group col-md-4">
                        <label for="telefone">Telefone</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone"
                               placeholder="(00)0000-0000"
                               value="{{$contact->telefone or old('telefone')}}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="celular">Celular</label>
                        <input type="tel" class="form-control" id="celular" name="celular"
                               placeholder="(00)00000-0000"
                               value="{{$contact->celular or old('celular')}}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="email@email.com"
                               value="{{$contact->email or old('email')}}">
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="endereco">Endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco"
                               placeholder="Av. exemplo, n° 250"
                               value="{{$location->endereco or old('endereco')}}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="cep" class="obrigatorio">Cep</label>
                        <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000"
                               value="{{$location->cep or old('cep')}}" minlength="9" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="bairro">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro"
                               placeholder="bairro" value="{{$location->bairro or old('bairro')}}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="select-UF">UF</label>
                        <select id="select-UF" name="uf" class="custom-select">
                            @foreach ($states as $uf => $estado)
                                <option value="{{$uf}}"
                                @if(!empty($client)){{ $location->uf == $uf ? 'selected' :''}} @endif>{{$estado}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="cidade">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade"
                               placeholder="cidade" value="{{$location->cidade or old('cidade')}}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="complemento">Complemento</label>
                        <input type="text" class="form-control" id="complemento" name="complemento"
                               placeholder="complemento"
                               value="{{$location->complemento or old('complemento')}}">
                    </div>
                    @if(!empty($client))
                    <div class="form-check col-md-12 ml-4">
                        <input type="checkbox" class="form-check-input" name="att_budgets" id="att_budgets">
                        <label class="form-check-label" for="att_budgets">Marque se deseja atualizar os dados em todos os orçamentos deste cliente.</label>
                    </div>
                    @endif
                </div>

                <button id="bt-client-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        @can('empresa_atualizar')
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}} </h4>
                @if($company)
                    <button id="{{$company->id}}" onclick="deletar(event,this.id,'companies')"
                            class="btn btn-danger ml-auto mr-3" type="button">Deletar
                    </button>
                @endif
                <button id="bt-company-visible" class="btn btn-primary btn-custom"
                        type="button">{{empty($company) ? 'Adicionar': 'Atualizar'}}</button>
            </div>

            <form class="formulario" method="POST" role="form"
                  action="{{($company) ?  route('companies.update',['id'=>$company->id]) : route('companies.store')}}">
                @if($company)
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
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group col-md-4">
                        <label for="nome" class="obrigatorio">Nome</label>
                        <input type="text" id="nome" class="form-control" name="nome" value="{{ $company->nome or old('nome')}}"
                               placeholder="Nome" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="endereco" class="obrigatorio">Endereço</label>
                        <input type="text" id="endereco" class="form-control" name="endereco"
                               value="{{ $company->endereco or old('endereco')}}" placeholder="Av. exemplo, n° 250" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="cidade" class="obrigatorio">Cidade</label>
                        <input type="text" id="cidade" class="form-control" name="cidade"
                               value="{{ $company->cidade or old('cidade')}}" placeholder="Cidade" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="bairro" class="obrigatorio">Bairro</label>
                        <input type="text" id="bairro" class="form-control" name="bairro"
                               value="{{ $company->bairro or old('bairro') }}" placeholder="Bairro" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="cep" class="obrigatorio">Cep</label>
                        <input type="text" class="form-control" name="cep" id="cep"
                               value="{{ $company->cep or old('cep') }}" placeholder="Cep" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="uf" class="obrigatorio">Selecione uma UF</label>
                        <select id="uf" class="custom-select" name="uf" required>
                            {{--<option value="" selected>Selecione...</option>--}}
                            @foreach ($states as $uf => $estado)
                                <option value="{{$uf}}"
                                @if($company){{ $company->uf == $uf ? 'selected' :''}} @endif>{{$estado}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="email" class="obrigatorio">E-mail</label>
                        <input type="email" class="form-control" name="email" id="email"
                               value="{{ $company->email or old('email') }}" placeholder="E-mail:" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="telefone" class="obrigatorio">Telefone</label>
                        <input type="tel" class="form-control" name="telefone" id="telefone"
                               value="{{ $company->telefone or old('telefone') }}" placeholder="Telefone" required>
                    </div>

                </div>

                <button id="bt-company-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
        @endcan
        @can('configuracao')
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title2}} </h4>
                
                <button id="bt-configuration-visible" class="btn btn-primary btn-custom"
                        type="button">Atualizar</button>
            </div>

            <form class="formulario" method="POST" role="form"
                  action="{{route('configuration.update',['id'=>$configuration->id])}}">
                
                <input type="hidden" name="_method" value="PATCH">
                @csrf
                <div class="form-row">
                    
                    <div class="form-group col-md-4">
                        <label for="reajuste_parcela" class="obrigatorio">Porcentagem de reajuste das parcelas</label>
                        <input type="number" step=".01" id="reajuste_parcela" class="form-control" name="porcent_reajuste" value="{{ $configuration->porcent_reajuste or old('porcent_reajuste')}}"
                               placeholder="5" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="interval_dias" class="obrigatorio">Intervalo de dias entre parcelas</label>
                        <input type="number" id="interval_dias" class="form-control" name="dias_parcelas"
                               value="{{ $configuration->dias_parcelas or old('dias_parcelas')}}" placeholder="30" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="porcent_marg_lucro" class="obrigatorio">Margem de lucro padrão</label>
                        <input type="text" id="porcent_marg_lucro" class="form-control" name="porcent_m_lucro"
                               value="{{ $configuration->porcent_m_lucro or old('porcent_m_lucro')}}" placeholder="100" required>
                    </div>

                </div>

                <button id="bt-configuration-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
        @endcan
    </div>
@endsection
@extends('layouts.app')
@section('content')

    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-material custom-card">

            <div class="topo">
                <h4 class="titulo">{{$title}} </h4>
                <button id="bt-company-visible" class="btn btn-primary btn-custom" type="button">Adicionar</button>
            </div>

            <form class="formulario" method="POST" role="form" action="{{route('companies.create')}}">
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="endereco">Endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço:" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="cidade">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="bairro">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="select-categoria">Selecione uma UF</label>
                        <select id="select-categoria" class="custom-select" required>
                            <option value="" selected>Selecione uma UF</option>
                            <option value="">MG</option>
                            <option value="">SP</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="e-mail">E-mail</label>
                        <input type="email" class="form-control" id="e-mail" name="e-mail" placeholder="E-mail:" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="telefone">Telefone</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="" required>
                    </div>

                </div>

                <button id="bt-company-invisible" class="d-none" type="submit"></button>

            </form>
        </div>
    </div>
@endsection
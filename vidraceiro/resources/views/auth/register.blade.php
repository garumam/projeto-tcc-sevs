@extends('layouts.auth')

@section('content')
    <form id="formulario" class="card-shadow-2dp" role="form" method="POST" action="{{ route('register') }}"
          aria-label="{{ __('Register') }}">
        @csrf
        <div class="text-center mb-4">
            <img class="" src="img/vidraceiro-solid.svg" alt="" width="72" height="72">
        </div>
        <h1 class="title">{{ __('Registrar') }}</h1>
        <div class="form-label-group">
            <label for="name">{{ __('Nome') }}</label>
            <input type="text" id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                   value="{{ old('name') }}" placeholder="Nome" required>
            @if($errors->has('name'))
                <span class="badge badge-danger mt-3">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-label-group">
            <label for="email">{{ __('E-Mail') }}</label>
            <input id="email" name="email" type="email"
                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}"
                   placeholder="Email" required>
            @if($errors->has('email'))
                <span class="badge badge-danger mt-3">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="form-label-group">
            <label for="password">{{ __('Senha') }}</label>
            <input type="password" id="password" name="password"
                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Senha"
                   required>
            @if($errors->has('password'))
                <span class="badge badge-danger mt-3">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="form-label-group mb-3">
            <label for="password_confirmation">{{ __('Confirmar Senha') }}</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                   placeholder="Confirmar Senha" required>
        </div>

        <button class="btn btn-md btn-primary btn-block btn-custom" type="submit">{{ __('Registrar') }}</button>
    </form>

@endsection
@section('content-footer')
    <a class="botao text-muted" href="{{ route('login') }}">
        Você já tem uma conta ?
    </a>
@endsection


@extends('layouts.auth')

@section('content')
    <form id="formulario" class="card-shadow-2dp" role="form" method="POST"
          action="{{ route('login') }}" aria-label="{{ __('Login') }}">
        @csrf
        <div class="text-center mb-4">
            <img class="" src="{{ asset('img/vidraceiro-solid.svg') }}" alt="" width="72" height="72">
        </div>
        <h1 class="title">{{ __('Login') }}</h1>
        <div class="form-label-group">
            <label for="email">{{ __('E-Mail') }}</label>
            <input type="email" id="email"
                   class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                   value="{{ old('email') }}" placeholder="Email" required>
            @if($errors->has('email'))
                <span class="badge badge-danger mt-3">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="form-label-group">
            <label for="password">{{ __('Senha') }}</label>
            <input type="password" id="password"
                   class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                   name="password" placeholder="Password" required>
            @if ($errors->has('password'))
                <span class="badge badge-danger mt-3">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember" name="remember"
                       id="remember" {{ old('remember') ? 'checked' : '' }}>
                {{ __('Lembrar-me') }}
            </label>
        </div>
        <button class="btn btn-md btn-primary btn-block btn-custom"
                type="submit">{{ __('Logar') }}</button>
    </form>
@endsection

@section('content-footer')
    <a class="botao text-muted" href="{{ route('password.request') }}">
        {{ __('Perdeu sua senha?') }}
    </a>
@endsection

@extends('layouts.auth')

@section('content')

    <form id="formulario" class="card-shadow-2dp" role="form" method="POST" action="{{ route('password.request') }}"
          aria-label="{{ __('Reset Password') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="text-center mb-4">
            <img class="" src="{{ asset('img/bootstrap-solid.svg') }}" alt="" width="72" height="72">
            <!-- <h1 class="title">Vidraceiro</h1> -->
        </div>
        <h1 class="title">{{ __('Reset Password') }}</h1>
        <div class="form-label-group mb-2">
            <label for="email">{{ __('E-Mail') }}</label>
            <input type="email" id="email" placeholder="Email address"
                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                   value="{{ $email ?? old('email') }}" required autofocus>
            @if ($errors->has('email'))
                <span class="badge badge-danger mt-3">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="form-label-group">
            <label for="password">{{ __('Password') }}</label>
            <input type="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                   name="password" placeholder="Password" required>
            @if ($errors->has('password'))
                <span class="badge badge-danger mt-3">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="form-label-group">
            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                   placeholder="Password Confirmation" required>
        </div>
        <button class="btn btn-md btn-primary btn-block btn-custom" type="submit">{{ __('Reset Password') }}</button>
        <!-- <p class="mt-5 mb-3 text-muted text-center">&copy; 2018</p> -->

    </form>
@endsection

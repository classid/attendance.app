@extends('layouts.auth')

@section('content')
  <div class="container container-login animated fadeIn">
    <h3 class="text-center">{{ __('Login') }}</h3>
    <form method="post" action="{{ route('auth.login') }}" class="login-form">
      @csrf
      <div class="form-group form-floating-label">
        <input id="username" name="username" type="text" class="form-control input-border-bottom @error('username') is-invalid @enderror" value="{{ old('username') }}" required autofocus>
        <label for="username" class="placeholder">Username</label>

        @error('username')
          <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
      </div>
      <div class="form-group form-floating-label">
        <input id="password" name="password" type="password" class="form-control input-border-bottom @error('password') is-invalid @enderror" required autofocus>
        <label for="password" class="placeholder">Password</label>
        <div class="show-password"><i class="icon-eye"></i></div>

        @error('password')
          <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
      </div>
      <div class="row form-sub m-0">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
          <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
        </div>

{{--        <a href="#" class="link float-right">Forget Password ?</a>--}}
      </div>
      <div class="form-action mb-3">
        <button class="btn btn-primary btn-rounded btn-login">Sign In</button>
      </div>
    </form>
  </div>
@endsection

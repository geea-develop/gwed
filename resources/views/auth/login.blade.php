@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card col-md-4 offset-4 mt-3">
        <h2 class="text-center mt-3">Login</h2>
        <form class="mt-3" role="form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-12 control-label">E-Mail Address</label>

                <div class="col-md-12">
                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" name="email" value="{{ old('email') }}" required autofocus>

                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-12 control-label">Password</label>

                <div class="col-md-12">
                    <input id="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : ''}}" name="password" required>

                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12 col-md-offset-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12 col-md-offset-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        Login
                    </button>
                </div>
            </div>
            <p class="text-center">
                <a href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
            </p>
        </form>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card col-md-4 offset-4 mt-3">
        <h2 class="text-center mt-3">Register</h2>
        <form class="mt-3" role="form" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-12 control-label">Name</label>

                <div class="col-md-12">
                    <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : ''}}" name="name" value="{{ old('name') }}" required autofocus>

                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-12 control-label">E-Mail Address</label>

                <div class="col-md-12">
                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" name="email" value="{{ old('email') }}" required>

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
                <label for="password-confirm" class="col-md-12 control-label">Confirm Password</label>

                <div class="col-md-12">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12 col-md-offset-4">
                    <button type="submit" class="btn btn-lg btn-primary btn-block">
                        Register
                    </button>
                </div>
            </div>

            <p class="text-center"><a href="{{url('login')}}" title="Login">I already have an account. </a> </p>
            <p class="text-center small">Why do I need to register? </p>
        </form>
    </div>
</div>

@endsection

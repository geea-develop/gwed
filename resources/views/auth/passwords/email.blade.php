@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card col-md-4 offset-4 mt-3">
        <h2 class="text-center mt-3">Reset Password</h2>

        @if (session('status'))
            <div class="alert alert-success mt-3">
                {{ session('status') }}
            </div>
        @endif

        <form class="mt-3" role="form" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-12 control-label">E-Mail Address</label>

                <div class="col-md-12">
                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" name="email" value="{{ old('email') }}" required>

                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12 col-md-offset-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        Send Password Reset Link
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.web')

@section('content')

    <div class="container">

        <div class="jumbotron bg-light">

            <h1 class="display-4">Contact</h1>

            <h2>Please don't hesitate to contact us...</h2>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="row">
            <div class="col-md-6">

                {!! Form::open(['route' => 'contact.store']) !!}

                <div class="form-group">
                    {!! Form::label('name', 'Your Name') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'E-mail Address') !!}
                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::textarea('msg', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('Submit', ['class' => 'btn btn-info']) !!}

                {!! Form::close() !!}
            </div>

            <div class="col-md-6 text-left">
                <h2> Contact Information</h2>
                <p>Email: example@example.com</p>
                <p>Address: Nowhere Land</p>
                <p>PO Address: Pl200, Virginia</p>
            </div>
        </div>

    </div>
@endsection
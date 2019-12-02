
@extends('layouts.web')

@section('content')

    <div class="container">
        <div class="jumbotron bg-light">
            <div class="title m-b-md">
                {{ config('app.name') }}
            </div>

            <p class="lead">
                The leading wedding planning platform
            </p>
            <hr class="my-4">
            <p>
                We have plenty of venues and professionals that fit to your current location.
                Use our information to create your dream wedding.
            </p>
            <p>Join now for free.</p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="{{ url('/register') }}" role="button">
                    Get Started, Create your wedding
                </a>
            </p>
        </div>

        <h2>Upcoming Weddings {{ showIfDebug("(" . count($weddings) . ")") }}</h2>

        @if(count($weddings) > 0)
            <ul class="list-group list-group-flush">
            @foreach($weddings as $wedding)
                    <li href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{$wedding->brideName}} & {{ $wedding->groomName }} </h5>
                            <p>{{$wedding->date->format('jS \o\f F, Y')}}
                                <br />
                                <small>in {{$wedding->date->diffForHumans(null, true)}}</small>
                            </p>

                        </div>
                        {{--<small></small>--}}
                    </li>

            @endforeach
            </ul>
        @else
            <p>Wow. No upcoming weddings. That's odd. </p>
            <p>Maybe try refreshing the page. </p>
        @endif
    </div>
@endsection

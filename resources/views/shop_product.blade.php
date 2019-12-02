@extends('layouts.web')

@section('content')

    <div class="container">

        {{--<div class="jumbotron bg-light">--}}
            {{--<h1 class="display-4">Shop</h1>--}}

            {{--<h2>Welcome to our shop! Please feel free to browse </h2>--}}
        {{--</div>--}}

        <div class="">
            <div class="jumbotron bg-light">
                <h1>{{ $product->title }}</h1>
                <h4>
                    <small><a href="{{  url('/shop/category/' . $product->category) }}" title="{{ $product->category }}">{{ $product->category }}</a></small></h4>

                <button type="button" class="btn btn-outline-primary mt-4"> Buy Now</button>

                <p class="card-text mt-2"><small class="text-muted">Product ID: {{ $product->_id }}</small></p>
            </div>


            <div class="card mt-4 text-left">
                <div class="row">
                    <div class="col-6">
                        <a href="{{url('shop/product/'. $product->uname)}}"><img class="card-img-top" src="{{ $product->image }}" alt="Image cap"></a>
                    </div>
                    <div class="col-6">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{ $product->logo }}" alt="Logo cap" class="rounded-circle">

                                </div>
                                <div class="col-md-6">
                                    <h4>{{ $product->title }}</h4>
                                    <h6><a href="{{ url('/shop/category/' . $product->category) }}" title="{{ $product->category }}">{{ $product->category }}</a></h6>



                                    <button type="button" class="btn btn-outline-primary mt-4"> Buy Now</button>

                                    <p class="card-text mt-2"><small class="text-muted">Product ID: {{ $product->_id }}</small></p>
                                </div>
                            </div>

                            <hr />

                            <p class="card-text mt-2">
                                {{ $product->description }}
                            </p>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

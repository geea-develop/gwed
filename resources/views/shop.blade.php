@extends('layouts.web')

@section('content')

    <div class="container">

        <div class="jumbotron bg-light">
            <h1 class="display-4">Shop</h1>

            <h2>Welcome to our shop! Please feel free to browse </h2>
        </div>

        <div class="card-columns mt-4">

        @foreach($products as $product)

            <div class="card text-left">
                <a href="{{url('shop/product/'. $product->uname)}}"><img class="card-img-top" src="{{ $product->image }}" alt="Image cap"></a>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <img src="{{ $product->logo }}" alt="Logo cap" class="rounded-circle">
                        </div>
                        <div class="col-6">
                            <h5 class="card-title">{{ $product->title }} <small><a href="/shop/category/{{$product->category}}" title="{{ $product->category }}">{{ $product->category }}</a></small></h5>
                        </div>
                    </div>

                    <p class="card-text mt-2">{{ $product->description }}</p>

                    <button type="button" class="btn btn-outline-primary"> Buy Now</button>

                    <p class="card-text mt-2"><small class="text-muted">Product ID: {{ $product->_id }}</small></p>
                </div>
            </div>

        @endforeach

        </div>

    </div>
@endsection

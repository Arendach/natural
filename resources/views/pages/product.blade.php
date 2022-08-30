@extends('layout')

@section('content')
    <div class="container-fluid">
        <hr style="margin-top: 0">
    </div>

    <div id="product-app">
        <product :product="{{ $product }}" :deliveries="{{ $deliveries }}" :social-links="{{ $socialLinks }}"/>
    </div>

    @include('parts.cart')
@endsection

@section('js')
    <script src="{{ mix('js/product.js') }}"></script>
@endsection

@extends('layout')

@section('content')

    <style>
        table p {
            margin: 0;
        }

        table span {
            font-size: 95%;
        }
    </style>

    <div class="container-fluid">
        <hr style="margin-top: 0">
    </div>

    <div id="product-app">
        <product :product="{{ $product }}" :deliveries="{{ $deliveries }}"></product>
    </div>

@endsection

@section('js')
    <script src="{{ mix('js/product.js') }}"></script>
@endsection

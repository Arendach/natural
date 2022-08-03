@extends('layout')

@section('content')
    <h1 class="none">{{ setting('Сео h1 головної сторінки') }}</h1>

    <section>
        <div
            class="layer"
            style="background-image: url({{ asset('images/banner.png') }}); color: {!! setting('layer.color') !!}"
        >
            {!! setting('layer.text') !!}
        </div>

        <div id="index-app">
            <index :categories="{{ json_encode($categories) }}"/>
        </div>
    </section>

    @include('parts.cart')
@endsection

@section('js')
    <script src="{{ mix('js/index.js') }}"></script>
@endsection
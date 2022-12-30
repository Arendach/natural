@extends('layout')

@section('content')
    <h1 class="none">{{ setting('Сео h1 головної сторінки') }}</h1>

    <div id="index-app">
        <index :categories="{{ json_encode($categories) }}" :banners="{{ json_encode($banners) }}"/>
    </div>

    @include('parts.cart')
@endsection

@section('js')
    <script src="{{ mix('js/index.js') }}"></script>
@endsection
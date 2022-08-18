@php /** @var \App\Models\Seo $seo */ @endphp
@extends('layout')

@section('content')
    <h1 class="none">{{ $seo->getH1() }}</h1>

    <div class="container-fluid">
        <hr style="margin-top: 0">
    </div>

    <div id="category-app">
        <category
            :category="{{ json_encode($categoryResource) }}"
            :banners="{{ json_encode($banners) }}"
        />
    </div>

    @include('parts.cart')
@endsection

@section('js')
    <script src="{{ mix('js/category.js') }}"></script>
@endsection

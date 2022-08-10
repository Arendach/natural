@extends('layout')

@section('content')

    <div id="thank-app">
        <thank
            :banners="{{ json_encode($banners) }}"
            :order="{{ json_encode($order) }}"
            :products="{{ json_encode($products) }}"
        ></thank>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/thank.js') }}"></script>
@endsection

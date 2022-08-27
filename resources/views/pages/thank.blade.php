@extends('layout')

@section('content')

    <div id="thank-app">
        <thank :banners="{{ $banners }}" :order="{{ $order }}"></thank>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/thank.js') }}"></script>
@endsection

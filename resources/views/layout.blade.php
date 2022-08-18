@php
    /** @var \App\Models\Seo $seo */
@endphp
<!doctype html>
<html lang="ua">
<head>
    @include('parts.google-analytics')

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if(isset($seo) && $seo instanceof \App\Models\Seo)
        <meta name="description" content="{{ $seo->getDescription() }}">
        <meta name="keywords" content="{{ $seo->getKeywords() }}">
        <meta name="robots" content="index,follow">
        <meta property="og:title" content="{{ $seo->getTitle() }}"/>
        <meta property="og:description" content="{{ $seo->getDescription() }}"/>
        <meta property="og:site_name" content="{{ setting('Назва сайту(og)', request()->getHost()) }}"/>
        <title>{{ $seo->getTitle() }}</title>

    @endif

    @isset($product->photo)
        <meta property="og:url" content="{{ $product->photo }}"/>
    @endisset
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf" content="{{ csrf_token() }}">
</head>
<body>
<header>
    <div class="container-fluid">
        <div class="row top-head">
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 align-self-center centered">
                {!! setting('Адреса') !!}
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 align-self-center">
                <a target="_blank" href="tel:{{ clearPhone(setting('Номер телефону')) }}">
                    <i class="fa fa-phone"></i> {{ setting('Номер телефону') }}
                </a>
                <br>
                <a target="_blank" href="viber://chat?number={{ clearPhone(setting('Номер телефону')) }}">
                    <i class="fa fa-whatsapp"></i> Viber
                </a>
                <br>
                <a target="_blank" href="https://t.me/zakaz_sharov_vozdushno">
                    <i class="fa fa-telegram"></i> Telegram
                </a>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 align-self-center">
                {!! preg_replace('/\,/', '<br>', setting('Графік роботи')) !!}
            </div>
        </div>

        <hr>

        {{--        <div class="container">
                    <form id="search" class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 mb-3 mb-sm-3 mb-md-3 mb-lg-0 mb-xl-0">
                            <input
                                    required
                                    value="{{ $search_query ?? '' }}"
                                    placeholder="Пошук товарів ..."
                                    name="query"
                                    type="search"
                                    class="form-control"
                            >
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-search"></i> Почати
                            </button>
                        </div>
                    </form>
                </div>

                <hr>--}}

        <div class="row align-items-center">
            <div class="col-12">
                <ul style="-webkit-padding-start: 0;">
                    @foreach($categories as $categoryItem)
                        @continue(!$categoryItem->products_count)
                        <li>
                            <a href="{{ $categoryItem->getUrl() }}">
                                {{ $categoryItem->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <hr style="margin-top: 0">

    </div>
</header>

@include('parts.breadcrumbs')

@yield('content')

<footer>
    {!! setting('Копірайт в футері') !!}
</footer>

<a href="#" style="z-index: 2" class="scrollup"></a>

@yield('js')

</body>
</html>

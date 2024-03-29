@php /** @var \App\Models\Seo $seo */ @endphp
<!doctype html>
<html lang="ua">
<head>
    @include('parts.google-analytics')

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if(isset($seo) && $seo instanceof \App\Models\Seo)
        <meta name="description" content="{{ $seo->getDescription() }}">
        <meta name="keywords" content="{{ $seo->getKeywords() }}">
        <meta name="robots" content="{{ $seo->is_index ? 'index' : 'noindex' }},{{ $seo->is_follow ? 'follow' : 'nofollow' }}">
        <meta property="og:title" content="{{ $seo->getTitle() }}"/>
        <meta property="og:description" content="{{ $seo->getDescription() }}"/>
        <title>{{ $seo->getTitle() }}</title>
    @elseif(isset($title))
        <title>{{ $title }}</title>
    @endif

    <meta property="og:site_name" content="{{ setting('Назва сайту(og)', request()->getHost()) }}"/>
    <meta property="og:type" content="website">
    <meta property="og:locale" content="uk_UA">
    <meta property="og:url" content="{{ request()->fullUrl() }}">

    @if(isset($page) && $page instanceof \App\Contracts\Seo)
        <meta property="og:image" content="{{ $page->getOGImage() }}"/>
    @endif
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
                    <img src="/images/phone.svg" style="display: inline; width: 22px; color: #7360F2" alt="Phone"> {{ setting('Номер телефону') }}
                </a>
                <br>
                <a target="_blank" href="viber://chat?number={{ clearPhone(setting('Номер телефону')) }}">
                    <img src="/images/viber.svg" style="display: inline; width: 22px; color: #7360F2" alt="Viber"> Viber
                </a>
                <br>
                <a target="_blank" href="https://t.me/zakaz_sharov_vozdushno">
                    <img src="/images/telegram.svg" style="display: inline; width: 22px; color: #0088CC" alt="Telegram"> Telegram
                </a>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 align-self-center">
                {!! preg_replace('/\,/', '<br>', setting('Графік роботи')) !!}
            </div>
        </div>

        <hr>

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

@include('parts.scroll-up')
@include('parts.feedback')

@yield('js')

</body>
</html>

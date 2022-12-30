<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    @include('parts.google-analytics')

    @if(isset($seo) && $seo instanceof \App\Models\Seo)
        <meta name="description" content="{{ $seo->getDescription() }}">
        <meta name="keywords" content="{{ $seo->getKeywords() }}">
        <meta name="robots"
              content="{{ $seo->is_index ? 'index' : 'noindex' }},{{ $seo->is_follow ? 'follow' : 'nofollow' }}">
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

    <meta name="csrf" content="{{ csrf_token() }}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/modern-normalize/1.1.0/modern-normalize.min.css"/>
    <link rel="stylesheet" href="{{ mix('css/main.css') }}"/>
</head>

<body>
<header class="page-header">
    <div class="container__page-header">
        <div class="header-logo">
            <a class="header-logo__link" href="">
                <p class="logo__text">{{ setting('Назва сайту', 'Simplify') }}</p>
                <span class="logo__span">{{ setting('Опис сайту', 'SimplifyCMS - точно вам підійде') }}</span>
            </a>
        </div>

        <!-- ................... nav ................... -->
        <nav class="nav">
            <ul class="nav__list list">
                <li class="nav__item">
                    <a
                        href="tel:{{ clearPhone(setting('Номер телефону', '+38 (066) 68-17-731')) }}"
                        target="_blank"
                        rel="noopener noindex nofollow"
                        class="nav__link"
                    >
                        <svg class="nav__social-icon">
                            <use href="/images/icons.svg#icon-phone"></use>
                        </svg>
                        {{ setting('Номер телефону', '+38 (066) 68-17-731') }}
                    </a>
                </li>
                <li class="nav__item">
                    <a
                        href="https://goo.gl/maps/R2SxpzTBWNpm6xfB9"
                        class="nav__link"
                        target="_blank"
                    >
                        <svg class="nav__social-icon">
                            <use href="/images/icons.svg#icon-map"></use>
                        </svg>
                        {{ setting('Адреса компанії', 'с. Хітар, Львівська обл.') }}
                    </a>
                </li>
            </ul>

            <!-- ................... second-nav__list ................... -->
            <ul class="second-nav__list list">
                <li class="second-nav__item">
                    <a
                        target="_blank"
                        class="second-nav__link"
                        href="https://play.google.com/store/apps/details?id=com.viber.voip&hl=uk&gl=US"
                    >
                        <svg class="second-nav__social-icon">
                            <use href="/images/icons.svg#icon-viber"></use>
                        </svg>
                    </a>
                </li>
                <li class="second-nav__item">
                    <a
                        target="_blank"
                        class="second-nav__link"
                        href="https://desktop.telegram.org/"
                    >
                        <svg class="second-nav__social-icon">
                            <use href="/images/icons.svg#icon-telegram"></use>
                        </svg>
                    </a>
                </li>
                <li class="second-nav__item">
                    @include('parts.cart')
                </li>
            </ul>
        </nav>
    </div>

    <!-- ........................ menu-hed ........................ -->
    <div class="menu-hed">
        <div class="container">
            <ul class="menu-hed__list list">
                @foreach($categories as $categoryItem)
                    @continue(!$categoryItem->products_count)
                    <li class="menu-hed__item">
                        <a class="menu-hed__link" href="{{ $categoryItem->getUrl() }}">
                            {{ $categoryItem->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!------------------- mob__menu__hed -------------------->
    <section class="mobile__container__tel">
        <button
            class="menu-toggle js-open-menu"
            type="button"
            aria-expanded="false"
            aria-controls="mobile-menu"
        >
            <svg class="menu-toggle__icon-menu" width="23" height="14">
                <use href="/images/icons.svg#icon-Group-3"></use>
            </svg>
        </button>

        <div class="mobile__container__logo">
            <a class="mobile__header-logo__link" href="">
                <p class="mobile__logo__text">
                    {{ setting('Назва сайту', 'Simplify') }}
                </p>
                <span class="mobile__logo__span">
                    {{ setting('Опис сайту', 'SimplifyCMS - точно вам підійде') }}
                </span>
            </a>
        </div>

        <button
            class="secondery__menu__basket"
            type="button"
            aria-expanded="false"
            aria-controls="mobile-menu"
        >
            <svg class="secondery__menu__basket__icon" width="23" height="14">
                <use href="/images/icons.svg#icon-koshik__white"></use>
            </svg>
        </button>
    </section>
</header>

@include('parts.breadcrumbs')

@yield('content')

<!-- ..................................... footer ..................................... -->
<footer class="footer">
    <div class="container footer__container">
        <!-- .................................. address .................................. -->
        <address class="address">
            <ul class="address__list list">
                <li class="address__item">
                    <a
                        href="tel:{{ clearPhone(setting('Номер телефону', '+38 (066) 68-17-731')) }}"
                        target="_blank"
                        rel="noopener noindex nofollow"
                        class="address__link"
                        text-align="center"
                    >
                        <svg class="address__phone-icon">
                            <use href="/images/icons.svg#icon-phone"></use>
                        </svg>
                        {{ setting('Номер телефону', '+38 (066) 68-17-731') }}
                    </a>
                </li>
                <li class="address__item">
                    <a
                        href="https://goo.gl/maps/R2SxpzTBWNpm6xfB9"
                        class="address__link"
                        target="_blank"
                    >
                        <svg class="address__map-icon">
                            <use href="/images/icons.svg#icon-map"></use>
                        </svg>
                        {{ setting('Адреса компанії', 'с. Хітар, Львівська обл.') }}
                    </a>
                </li>
            </ul>
        </address>

        <!-- .................................. footer__second .................................. -->
        <div class="footer__second">
            {{--<ul class="second__list list">
                <li class="second__item">
                    <a class="second__link" href="">Карпатський мед</a>
                </li>
                <li class="second__item">
                    <a class="second__link" href="">Карпатський чай</a>
                </li>
            </ul>--}}
        </div>

        <!-- .................................. footer__third .................................. -->
        <div class="footer__third">
            {{--<ul class="third__list list">
                <li class="third__item">
                    <a class="third__link" href="">Варення з чорниці</a>
                </li>
                <li class="third__item">
                    <a class="third__link" href="">Кошик</a>
                </li>
            </ul>--}}
        </div>

        <!-- .................................. footer__fourth .................................. -->
        <div class="footer__fourth">
            <ul class="fourth__list list">
                <li class="fourth__item">
                    <a
                        class="fourth__link"
                        target="_blank"
                        href="https://play.google.com/store/apps/details?id=com.viber.voip&hl=uk&gl=US"
                    >
                        <svg class="fourth__social-icon">
                            <use href="/images/icons.svg#icon-viber"></use>
                        </svg>
                    </a>
                </li>
                <li class="fourth__item">
                    <a
                        class="fourth__link"
                        target="_blank"
                        href="https://desktop.telegram.org/"
                    >
                        <svg class="fourth__social-icon">
                            <use href="/images/icons.svg#icon-telegram"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <section class="section footer__and">
        <div class="and_container container">
            <p class="and__text">
                {!! setting('Копірайт', '&copy; SimplifyCMS - всі права захищені') !!}
            </p>
        </div>
    </section>
</footer>

<div class="menu-container js-menu-container" id="mobile-menu">
    <div class="mobil-container">
        <section class="mobile__container__tel">
            <button class="menu-toggle js-close-menu">
                <svg class="menu-toggle__icon-menu" width="40" height="40">
                    <use href="/images/icons.svg#icon-close"></use>
                </svg>
            </button>

            <div class="mobile__container__logo">
                <a class="mobile__header-logo__link" href="">
                    <p class="mobile__logo__text">
                        {{ setting('Назва сайту', 'Simplify') }}
                    </p>
                    <span class="mobile__logo__span">
                        {{ setting('Опис сайту', 'SimplifyCMS - точно вам підійде') }}
                    </span>
                </a>
            </div>

            <button
                class="secondery__menu__basket"
                type="button"
                aria-expanded="false"
                aria-controls="mobile-menu"
            >
                <svg class="secondery__menu__basket__icon" width="23" height="14">
                    <use href="/images/icons.svg#icon-koshik__white"></use>
                </svg>
            </button>
        </section>

        <section class="mobile__main">
            <ul class="mobile-menu list">
                @foreach($categories as $categoryItem)
                    @continue(!$categoryItem->products_count)
                    <li class="mobile-menu__item">
                        <a href="{{ $categoryItem->getUrl() }}" class="mobile-menu__link">
                            {{ $categoryItem->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="mobile__footer">
            <footer class="footer">
                <div class="container footer__container">
                    <address class="address">
                        <ul class="address__list list">
                            <li class="address__item">
                                <a
                                    href="tel:{{ clearPhone(setting('Номер телефону', '+38 (066) 68-17-731')) }}"
                                    target="_blank"
                                    rel="noopener noindex nofollow"
                                    class="address__link"
                                    text-align="center"
                                >
                                    <svg class="address__phone-icon">
                                        <use href="/images/icons.svg#icon-phone"></use>
                                    </svg>
                                    {{ setting('Номер телефону', '+38 (066) 68-17-731') }}
                                </a>
                            </li>
                            <li class="address__item">
                                <a
                                    href="https://goo.gl/maps/R2SxpzTBWNpm6xfB9"
                                    class="address__link"
                                    target="_blank"
                                >
                                    <svg class="address__map-icon">
                                        <use href="/images/icons.svg#icon-map"></use>
                                    </svg>
                                    {{ setting('Адреса компанії', 'с. Хітар, Львівська обл.') }}
                                </a>
                            </li>
                        </ul>
                    </address>
                    <div class="footer__fourth">
                        <ul class="fourth__list list">
                            <li class="fourth__item">
                                <a
                                    class="fourth__link"
                                    href="https://play.google.com/store/apps/details?id=com.viber.voip&hl=uk&gl=US"
                                >
                                    <svg class="fourth__social-icon">
                                        <use href="/images/icons.svg#icon-viber"></use>
                                    </svg>
                                </a>
                            </li>
                            <li class="fourth__item">
                                <a
                                    class="fourth__link"
                                    href="https://desktop.telegram.org/"
                                >
                                    <svg class="fourth__social-icon">
                                        <use href="/images/icons.svg#icon-telegram"></use>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </footer>
        </section>
    </div>
</div>


@include('parts.scroll-up')
@include('parts.feedback')

@yield('js')
</body>
</html>
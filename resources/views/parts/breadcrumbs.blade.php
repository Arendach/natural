@isset($breadcrumbs)
    <div class="gallery__wraper__is-none container">
        <ul class="wraper__is-none__list list">
            <li class="wraper__is-none__item">
                <a class="wraper__is-none__link" href="{{ url('/') }}">
                    {{ setting('Назва головної сторінки', request()->getHost()) }}
                    <svg class="wraper__is-none__icon">
                        <use href="/images/icons.svg#icon-arrow-left-bold"></use>
                    </svg>
                </a>
            </li>

            @foreach($breadcrumbs as $item)
                <li class="wraper__is-none__item">
                    @if (!$loop->last && $loop->count != 1)
                        <a class="wraper__is-none__link" href="{{ url($item[1]) }}">
                            {{ $item[0] }}
                            <svg class="wraper__is-none__icon">
                                <use href="./img/icons.svg#icon-arrow-left-bold"></use>
                            </svg>
                        </a>
                    @else
                        <span class="wraper__is-none__link">
                            {!! $item[0] !!}
                        </span>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endisset
@isset($breadcrumbs)
    <div class="container breadcrumbs">
        <a href="{{ url('/') }}">
            <i class="fa fa-home"></i> {{ setting('Назва головної сторінки', request()->getHost()) }}
        </a> &#8250;
        @foreach($breadcrumbs as $item)
            @if (!$loop->last && $loop->count != 1)
                <a href="{{ url($item[1]) }}">
                    {{ $item[0] }}
                </a> &#8250;
            @else
                {!! $item[0] !!}
            @endif
        @endforeach

    </div>
@endisset
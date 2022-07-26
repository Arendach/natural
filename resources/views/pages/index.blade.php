@php /** @var \App\Models\Product $product */ @endphp
@php /** @var \App\Models\Category $category */ @endphp
@extends('layout')

@section('content')
    <h1 class="none">
        {{ setting('Сео h1 головної сторінки') }}
    </h1>

    <section>
        <div
                class="layer"
                style="background-image: url({!! setting('layer.image') !!}); color: {!! setting('layer.color') !!}"
        >
            {!! setting('layer.text') !!}
        </div>

        @forelse($categories as $category)
            @continue(!$category->products_count)

            <h2 class="title">
                {{ $category->title }}
                <div class="description">
                    {!! $category->description !!}
                </div>
            </h2>

            <div class="container">
                <div class="products-cat">
                    @foreach($category->products as $product)
                        <div class="product-cat">
                            <a href="{{ $product->getUrl() }}">
                                <img
                                        class="lazy"
                                        src="{{ $product->getLazy() }}"
                                        data-src="{{ $product->getPictureMin() }}"
                                        alt="{{ $product->title }}"
                                >
                            </a>
                            <h3 class="product-name">{{ $product->title }}</h3>

                            <div class="product-cat-footer">
                                <div class="product-cat-price">
                                    Ціна: <b>{{ number_format($product->price) }}</b> грн
                                </div>
                                <div class="product-cat-buttons">
                                    <a class="btn btn-primary" href="{{ $product->getUrl() }}">
                                        Детальніше
                                    </a>
                                    <button
                                            data-data="{{ json_encode([
                                                'name' => $product->title,
                                                'price' => $product->price,
                                                'id' => $product->id,
                                                'photo' => $product->getPictureMin()
                                                ]) }}"
                                            class="btn btn-primary to_cart"
                                    >
                                        В корзину
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($category->products_count > $category->products->count())
                        <div class="product-cat" style="text-align: center; display: flex">
                            <div style="margin: auto">
                                <a href="{{ $category->url }}">
                                    <img
                                            class="lazy"
                                            src=""
                                            data-src="{{ asset('images/more.svg') }}"
                                            alt="Більше товарів даної категорії"
                                    >
                                </a>

                                <br>

                                <a style="font-size: 25px" href="{{ $category->url }}">
                                    Більше товарів даної категорії
                                </a>
                            </div>

                        </div>
                    @endif
                </div>
            </div>
        @empty

            <h1 style="text-align: center; margin: 100px 0">Тут порожньо:(</h1>

        @endforelse

    </section>

@endsection

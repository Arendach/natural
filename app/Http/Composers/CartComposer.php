<?php

namespace App\Http\Composers;

use App\Models\Product;
use Illuminate\View\View;

class CartComposer
{
    public function compose(View $view): void
    {
        $cartProducts = json_decode($_COOKIE['cartProducts'] ?? '[]');
        $cartProducts = collect($cartProducts);

        $products = Product::whereIn('id', $cartProducts->pluck('id'))
            ->get()
            ->map(function (Product $product) use ($cartProducts) {
                return [
                    'id'      => $product->id,
                    'title'   => $product->title,
                    'price'   => $product->price,
                    'picture' => $product->picture,
                    'url'     => $product->url,
                    'count'   => $cartProducts->where('id', $product->id)->first()->count,
                ];
            })
            ->toArray();

        $view->with(compact('products'));
    }
}
<?php

namespace App\Http\Composers;

use App\Models\Product;
use App\Resources\ProductResource;
use Illuminate\View\View;

class CartComposer
{
    public function compose(View $view): void
    {
        $cartProducts = json_decode($_COOKIE['cartProducts'] ?? '[]');
        $cartProducts = collect($cartProducts);

        if (!$cartProducts->count()) {
            $view->with(['products' => []]);
            return;
        }

        $products = Product::with('category', 'relatedImages')
            ->whereIn('id', $cartProducts->pluck('id'))
            ->orderByDesc('id')
            ->get()
            ->each(function (Product $product) use ($cartProducts) {
                $product->setAttribute('count', $cartProducts->where('id', $product->id)->first()->count);
            });

        $products = ProductResource::collection($products);

        $view->with(compact('products'));
    }
}
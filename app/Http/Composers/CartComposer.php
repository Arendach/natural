<?php

namespace App\Http\Composers;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CartComposer
{
    public function compose(View $view): void
    {
        $cartProducts = $_COOKIE['cart_products'];

        $products = Product::whereIn('id', array_keys($cartProducts))->get();
        $countProducts = array_sum(array_values($cartProducts));
        $cartSum = $this->getCartSum($products, $cartProducts);

        $view->with(compact('products', 'countProducts', 'cartProducts', 'cartSum'));
    }

    private function getCartSum(Collection $products, array $cartProducts): float
    {
        return $products->sum(fn (Product $product) => $product->price * $cartProducts[$product->id]);
    }
}
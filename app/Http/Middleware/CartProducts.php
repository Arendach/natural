<?php

namespace App\Http\Middleware;

use Closure;

class CartProducts
{
    public function handle($request, Closure $next)
    {
        if (isset($_COOKIE['cart_products'])) {
            $_COOKIE['cart_products'] = json_decode($_COOKIE['cart_products'], true);
        } else {
            $_COOKIE['cart_products'] = [];
        }

        return $next($request);
    }
}

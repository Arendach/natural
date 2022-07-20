<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gumlet\ImageResize;

class ProductController extends Controller
{
    public function index(Product $product)
    {
        abort_if(!$product->is_active, 404);

        $data = [
            'title'            => $product->seo->title,
            'meta_description' => $product->seo->description,
            'meta_keywords'    => $product->seo->keywords,
            'product'          => $product,
            'breadcrumbs'      => [
                [$product->category->name, $product->category->url],
                [$product->title]
            ]
        ];

        return view('product.main', $data);
    }
}

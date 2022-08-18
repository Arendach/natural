<?php

namespace App\Transformers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;

class CategoryWithProductsTransformer
{
    public function run(Category $category): array
    {
        return [
            'id'          => $category->id,
            'url'         => $category->getUrl(),
            'description' => $category->description,
            'title'       => $category->title,
            'products'    => $this->transformProducts($category->products),
        ];
    }

    private function transformProducts(Collection $products): array
    {
        return $products->map(function (Product $product) {
            return [
                'id'         => $product->id,
                'title'      => $product->title,
                'picture'    => (string)$product->getImage('picture', 474, 474, 50),
                'pictureMin' => $product->getPictureMin(),
                'url'        => $product->getUrl(),
                'price'      => $product->price,
                'discount'   => $product->discount,
            ];
        })->toArray();
    }
}
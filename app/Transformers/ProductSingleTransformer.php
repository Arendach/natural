<?php

namespace App\Transformers;

use App\Models\Product;

class ProductSingleTransformer
{
    public function run(Product $product): array
    {
        return [
            'id'                => $product->id,
            'title'             => $product->title,
            'url'               => $product->getUrl(),
            'price'             => $product->price,
            'discount'          => $product->discount,
            'category'          => $product->category,
            'pictureOriginal'   => asset($product->picture),
            'picture'           => $product->getImage('picture', 474, 474, 50),
            'gallery'           => $this->mapGallery($product),
            'is_storage'        => $product->is_storage,
            'is_active'         => $product->is_active,
            'description'       => $product->description,
            'short_description' => $product->short_description,
            'article'           => $product->id,
        ];
    }

    private function mapGallery(Product $product): array
    {
        $gallery = [];

        $gallery[] = [
            'src'       => $product->picture,
            'thumbnail' => $product->getImage('picture', 474, 474, 50),
            'w'         => $product->getOriginalWidth('picture'),
            'h'         => $product->getOriginalHeight('picture'),
            'alt'       => $product->title,
        ];

        return $gallery;
    }
}
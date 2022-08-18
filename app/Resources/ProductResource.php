<?php

namespace App\Resources;

use App\Models\Product;
use App\Resource\Resource;

/** @mixin Product */
class ProductResource extends Resource
{
    public function toArray(): array
    {
        return [
            'id'                => $this->id,
            'title'             => $this->title,
            'url'               => $this->getUrl(),
            'price'             => $this->price,
            'discount'          => $this->discount,
            'category'          => new CategoryResource($this->whenLoaded('category')),
            'pictureOriginal'   => asset($this->picture),
            'picture'           => $this->getImage('picture', 474, 474, 50),
            'gallery'           => $this->mapGallery($this->resource),
            'is_storage'        => $this->is_storage,
            'is_active'         => $this->is_active,
            'description'       => $this->description,
            'short_description' => $this->short_description,
            'article'           => $this->id,
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
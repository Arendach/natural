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
            'mainPicture'       => $this->getMainPicture($this->resource),
            'gallery'           => RelatedImageResource::collection($this->whenLoaded('relatedImages')),
            'is_storage'        => $this->is_storage,
            'is_active'         => $this->is_active,
            'description'       => $this->description,
            'short_description' => $this->short_description,
            'article'           => $this->id,
            'orderCount'        => $this->whenPivotLoaded('order_product', fn() => $this->pivot->count),
            'orderPrice'        => $this->whenPivotLoaded('order_product', fn() => $this->pivot->price),
            'count'             => $this->when($this->count, $this->count), // для корзини
        ];
    }

    private function getMainPicture(Product $product): array
    {
        return [
            'src'       => $product->picture,
            'thumbnail' => $product->getImage('picture', 474, 474, 50),
            'w'         => $product->getOriginalWidth('picture'),
            'h'         => $product->getOriginalHeight('picture'),
            'alt'       => $product->title,
            'title'     => $product->title,
        ];
    }
}
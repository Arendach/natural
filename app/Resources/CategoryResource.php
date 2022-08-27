<?php

namespace App\Resources;

use App\Models\Category;
use App\Resource\Resource;

/** @mixin Category */
class CategoryResource extends Resource
{
    public function toArray(): array
    {
        return [
            'id'               => $this->id,
            'url'              => $this->getUrl(),
            'description'      => $this->description,
            'title'            => $this->title,
            'productsCount'    => $this->whenLoaded('products', fn() => $this->products->count()),
            'allProductsCount' => $this->whenCounted('products'),
            'products'         => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
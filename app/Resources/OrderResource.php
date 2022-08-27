<?php

namespace App\Resources;

use App\Models\Order;
use App\Resource\Resource;

/** @mixin Order */
class OrderResource extends Resource
{
    public function toArray(): array
    {
        return [
            'id'             => $this->id,
            'created_at'     => $this->created_at->format('Y.m.d H:i'),
            'updated_at'     => $this->updated_at->format('Y.m.d H:i'),
            'name'           => $this->name,
            'phone'          => $this->phone,
            'comment'        => $this->comment,
            'products_price' => $this->products_price,
            'discount_price' => $this->discount_price,
            'delivery_price' => $this->delivery_price,
            'products'       => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
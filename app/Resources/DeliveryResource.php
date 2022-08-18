<?php

namespace App\Resources;

use App\Models\Delivery;
use App\Resource\Resource;

/** @mixin Delivery */
class DeliveryResource extends Resource
{
    public function toArray(): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'slug'        => $this->slug,
            'description' => $this->description,
            'picture'     => asset($this->picture),
            'is_active'   => $this->is_active,
        ];
    }
}
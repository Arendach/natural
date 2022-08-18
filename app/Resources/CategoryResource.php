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
            'id'    => $this->id,
            'title' => $this->title,
        ];
    }
}
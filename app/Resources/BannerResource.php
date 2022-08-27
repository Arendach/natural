<?php

namespace App\Resources;

use App\Models\Banner;
use App\Resource\Resource;

/** @mixin Banner */
class BannerResource extends Resource
{
    public function toArray(): array
    {
        return [
            'id'              => $this->id,
            'title'           => $this->title,
            'url'             => $this->url,
            'color'           => $this->color,
            'picture_desktop' => $this->getImage('picture_desktop', 1920, 400, 70),
            'picture_mobile'  => $this->getImage('picture_mobile', 991, 400, 70),
        ];
    }
}
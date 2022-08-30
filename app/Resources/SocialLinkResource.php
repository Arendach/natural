<?php

namespace App\Resources;

use App\Models\SocialLink;
use App\Resource\Resource;

/** @mixin SocialLink */
class SocialLinkResource extends Resource
{
    public function toArray(): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'picture'   => asset($this->picture),
            'url'       => $this->url,
            'is_active' => $this->is_active,
            'priority'  => $this->priority,
        ];
    }
}
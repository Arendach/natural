<?php

namespace App\Resources;

use App\Models\RelatedImage;
use App\Resource\Resource;

/** @mixin RelatedImage */
class RelatedImageResource extends Resource
{
    public function toArray(): array
    {
        return [
            'src'       => $this->path,
            'thumbnail' => $this->getImage('path', 474, 474, 50),
            'w'         => $this->getOriginalWidth('path'),
            'h'         => $this->getOriginalHeight('path'),
            'alt'       => $this->alt,
            'title'     => $this->alt,
        ];
    }
}
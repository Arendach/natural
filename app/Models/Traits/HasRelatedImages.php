<?php

namespace App\Models\Traits;

use App\Models\Model;
use App\Models\RelatedImage;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/** @mixin Model */
trait HasRelatedImages
{
    public function relatedImages(): MorphMany
    {
        return $this->morphMany(RelatedImage::class, 'model');
    }
}
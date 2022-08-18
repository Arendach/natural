<?php

namespace App\Models\Traits;

use App\Models\Model;
use App\Models\Seo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/** @mixin Model */
trait HasSeo
{
    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'model');
    }

    public function getSeo(): Seo
    {
        return $this->seo ?: new Seo;
    }

    public function getBreadcrumbs(): array
    {
        return [
            [$this->title]
        ];
    }
}
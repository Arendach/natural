<?php

namespace App\Transformers;

use App\Models\Banner;
use Illuminate\Support\Collection;

class BannersTransformer
{
    public function run(Collection $banners): array
    {
        return $banners
            ->map(function (Banner $banner) {
                return [
                    'id'              => $banner->id,
                    'title'           => $banner->title,
                    'url'             => $banner->url,
                    'color'           => $banner->color,
                    'picture_desktop' => $banner->getImage('picture_desktop', 1920, 400, 70),
                    'picture_mobile'  => $banner->getImage('picture_mobile', 991, 400, 70),
                ];
            })
            ->toArray();
    }
}
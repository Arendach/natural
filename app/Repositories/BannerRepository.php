<?php

namespace App\Repositories;

use Cache;
use App\Models\Banner;
use Illuminate\Support\Collection;

class BannerRepository
{
    public function getBanners(): Collection
    {
        return Cache::tags(['images', 'banners'])->rememberForever('banners', function () {
            return Banner::where('is_active', true)
                ->with('images')
                ->orderByDesc('priority')
                ->get();
        });
    }
}
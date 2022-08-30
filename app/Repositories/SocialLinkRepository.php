<?php

namespace App\Repositories;

use App\Models\SocialLink;
use Illuminate\Support\Collection;

class SocialLinkRepository
{
    public function activeLinks(): Collection
    {
        return SocialLink::where('is_active', true)->orderByDesc('id')->get();
    }
}
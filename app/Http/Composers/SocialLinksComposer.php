<?php

namespace App\Http\Composers;

use App\Repositories\SocialLinkRepository;
use App\Resources\SocialLinkResource;
use Illuminate\View\View;

class SocialLinksComposer
{
    public function compose(View $view): void
    {
        $socialLinks = SocialLinkResource::collection(
            app(SocialLinkRepository::class)->activeLinks()
        );

        $view->with(compact('socialLinks'));
    }
}
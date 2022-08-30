<?php

namespace App\Providers;

use App\Http\Composers\CartComposer;
use App\Http\Composers\DeliveriesComposer;
use App\Http\Composers\MainComposer;
use App\Http\Composers\SocialLinksComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('layout', MainComposer::class);
        View::composer('parts.cart', CartComposer::class);
        View::composer('pages.product', DeliveriesComposer::class);
        View::composer('pages.product', SocialLinksComposer::class);
    }
}

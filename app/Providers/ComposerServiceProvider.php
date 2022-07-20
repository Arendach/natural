<?php

namespace App\Providers;

use App\Http\Composers\CartComposer;
use App\Http\Composers\MainComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('layout', MainComposer::class);
        View::composer('parts.cart', CartComposer::class);
    }
}

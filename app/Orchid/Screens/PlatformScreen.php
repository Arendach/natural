<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    public function query(): iterable
    {
        return [];
    }

    public function name(): ?string
    {
        return 'Початок роботи';
    }


    public function description(): ?string
    {
        return 'Ласково просимо до адмін панелі';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Веб-сайт')
                ->href(url('/'))
                ->icon('globe-alt'),
        ];
    }

    public function layout(): iterable
    {
        return [
            //Layout::view('platform::partials.welcome'),
        ];
    }
}

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
        return 'Get Started';
    }


    public function description(): ?string
    {
        return 'Welcome to your Orchid application.';
    }

    public function commandBar(): iterable
    {
        return [
            Link::make('Website')
                ->href('http://orchid.software')
                ->icon('globe-alt'),

            Link::make('Documentation')
                ->href('https://orchid.software/en/docs')
                ->icon('docs'),

            Link::make('GitHub')
                ->href('https://github.com/orchidsoftware/platform')
                ->icon('social-github'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('platform::partials.welcome'),
        ];
    }
}

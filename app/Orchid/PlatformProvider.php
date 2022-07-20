<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    public function registerMainMenu(): array
    {
        return [
            Menu::make('Категорії')
                ->icon('folder')
                ->route('platform.categories')
                ->permission('platform.categories')
                ->title('Каталог'),

            Menu::make('Товари')
                ->icon('note')
                ->route('platform.products')
                ->permission('platform.products'),

            Menu::make('Користувачі')
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title('Налаштування доступу'),

            Menu::make('Ролі')
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),

            ItemPermission::group('Каталог')
                ->addPermission('platform.categories', 'Категорії')
                ->addPermission('platform.products', 'Товари')
        ];
    }
}

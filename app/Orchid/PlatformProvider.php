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

            Menu::make('Замовлення')
                ->icon('basket')
                ->route('platform.orders')
                ->permission('platform.orders')
                ->title('Клієнтська частина'),

            Menu::make('Користувачі')
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title('Налаштування доступу'),

            Menu::make('Ролі')
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),

            Menu::make('Перемінні')
                ->icon('config')
                ->route('platform.settings')
                ->permission('platform.settings')
                ->title('Налаштування сайту'),
        ];
    }

    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Профіль')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    public function registerPermissions(): array
    {
        return [
            ItemPermission::group('Система')
                ->addPermission('platform.systems.roles', 'Ролі')
                ->addPermission('platform.systems.users', 'Користувачі'),

            ItemPermission::group('Каталог')
                ->addPermission('platform.categories', 'Категорії')
                ->addPermission('platform.products', 'Товари'),

            ItemPermission::group('Налаштування')
                ->addPermission('platform.settings', 'Перемінні'),

            ItemPermission::group('Клієнтська частина')
                ->addPermission('platform.orders', 'Замовлення'),
        ];
    }
}

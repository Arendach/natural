<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Models\Feedback;
use App\Models\Order;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

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

            Menu::make('Баннери')
                ->icon('picture')
                ->route('platform.banners')
                ->permission('platform.banners'),

            Menu::make('Замовлення')
                ->icon('basket')
                ->route('platform.orders')
                ->permission('platform.orders')
                ->title('Клієнтська частина')
                ->badge(fn() => '+' . Order::whereNull('accepted_at')->count(), Color::DANGER()),

            Menu::make('Зворотні дзвінки')
                ->icon('earphones-alt')
                ->route('platform.feedbacks')
                ->permission('platform.feedbacks')
                ->badge(fn() => '+' . Feedback::where('is_accepted', false)->count(), Color::DANGER()),

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

            Menu::make('Способи доставки')
                ->icon('move')
                ->route('platform.deliveries')
                ->permission('platform.deliveries'),

            Menu::make('Соцмережі')
                ->icon('facebook')
                ->route('platform.social_links')
                ->permission('platform.social_links'),
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
                ->addPermission('platform.products', 'Товари')
                ->addPermission('platform.banners', 'Баннери'),

            ItemPermission::group('Налаштування')
                ->addPermission('platform.settings', 'Перемінні')
                ->addPermission('platform.deliveries', 'Способи доставки')
                ->addPermission('platform.social_links', 'Соцмережі'),

            ItemPermission::group('Клієнтська частина')
                ->addPermission('platform.orders', 'Замовлення')
                ->addPermission('platform.feedbacks', 'Зворотні дзвінки'),
        ];
    }
}

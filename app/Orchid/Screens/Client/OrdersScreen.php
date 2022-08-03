<?php

namespace App\Orchid\Screens\Client;

use App\Models\Category;
use App\Models\Order;
use App\Orchid\ScreenAbstract;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class OrdersScreen extends ScreenAbstract
{
    protected string $model = Order::class;

    public function name(): ?string
    {
        return 'Замовлення';
    }

    public function description(): ?string
    {
        return 'Замовлені товари на сайті';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.orders',
        ];
    }

    public function query(): array
    {
        return [
            'orders' => Order::with('products')->orderByDesc('id')->paginate(50)
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::table('orders', [
                TD::make('id', 'ID')
                    ->sort()
                    ->filter(),

                TD::make('title', 'Клієнт')
                    ->sort()
                    ->filter(),

                TD::make('phone', 'Номер телефону')
                    ->sort()
                    ->filter(),

                TD::make('comment', 'Коментар')
                    ->sort()
                    ->filter(),

                TD::make('price', 'Повна вартість')
                    ->render(fn(Order $order) => $order->products_price + $order->delivery_price - $order->discount_price),

                TD::make('Дії')
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(function (Category $category) {
                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list([

                            ]);
                    }),
            ])
        ];
    }
}
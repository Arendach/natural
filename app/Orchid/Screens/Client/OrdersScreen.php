<?php

namespace App\Orchid\Screens\Client;

use App\Models\Order;
use App\Orchid\ScreenAbstract;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Auth;
use Orchid\Support\Facades\Toast;

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

    public function asyncAcceptOrder(Order $order)
    {
        $order->accepted_at = now();
        $order->accepted_id = Auth::id();

        $order->save();

        Toast::info('Замовлення вдало прийняте вами!');
    }

    public function layout(): iterable
    {
        return [
            Layout::table('orders', [
                TD::make('id', 'ID')
                    ->sort()
                    ->filter(),

                TD::make('name', 'Імя')
                    ->sort()
                    ->filter(),

                TD::make('phone', 'Номер телефону')
                    ->sort()
                    ->filter(),

                TD::make('price', 'Повна вартість')
                    ->render(fn(Order $order) => $order->products_price + $order->delivery_price - $order->discount_price),

                TD::make('created_at', 'Створено')
                    ->filter(TD::FILTER_DATE_RANGE)
                    ->sort()
                    ->render(fn(Order $order) => $order->created_at?->format('Y.m.d H:i') ?? '-'),

                TD::make('accepted_at', 'Прийняте')
                    ->filter(TD::FILTER_DATE_RANGE)
                    ->sort()
                    ->render(fn(Order $order) => $order->accepted_at?->format('Y.m.d H:i') ?? '-'),

                TD::make('accepted_at', 'Прийняв')
                    ->sort()
                    ->render(fn(Order $order) => $order->accepted?->name ?? '-'),

                TD::make('Дії')
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(function (Order $order) {
                        $actions = [];

                        $actions[] = Link::make('Редагувати')
                            ->route('platform.orders.edit', ['order' => $order->id])
                            ->icon('pencil');

                        if (!$order->accepted_id || !$order->accepted_at) {
                            $actions[] = Button::make('Прийняти замовлення')
                                ->icon('check')
                                ->method('asyncAcceptOrder')
                                ->parameters(['order' => $order->id]);
                        }

                        return DropDown::make()
                            ->icon('options-vertical')
                            ->list($actions);
                    }),
            ])
        ];
    }
}
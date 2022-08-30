<?php

namespace App\Orchid\Screens\Client;

use App\Models\Order;
use App\Models\Product;
use App\Orchid\ScreenAbstract;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class OrdersEditScreen extends ScreenAbstract
{
    public function name(): ?string
    {
        return 'Замовлення :: Редагування';
    }

    public function description(): ?string
    {
        return 'Замовлені товари на сайті :: Редагування';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.orders',
        ];
    }

    public function query(Order $order): array
    {
        $order->load('products', 'products.relatedImages', 'accepted');

        return compact('order');
    }

    public function layout(): iterable
    {
        return [
            Layout::tabs([
                'Інформація' => Layout::block(Layout::rows([
                    Input::make('order.id')->hidden(),
                    Input::make('order.name')->title('Імя клієнта')->required(),
                    Input::make('order.phone')->title('Номер телефону')->required(),
                    TextArea::make('order.comment')->title('Коментар'),
                ]))
                    ->title('Інформація')
                    ->description('Контактна інформація клієнта! Коментар до замовлення')
                    ->commands(
                        Button::make('Зберегти')
                            ->type(Color::DEFAULT())
                            ->icon('check')
                            ->method('save')
                    ),
                'Товари'     => [
                    Layout::table('order.products', [
                        TD::make('title', 'Товар')
                            ->render(fn(Product $product) => "<a target='_blank' href='{$product->getUrl()}'>$product->title</a>"),

                        TD::make('count', 'Кількість')
                            ->render(fn(Product $product) => $product->pivot->count),

                        TD::make('price', 'Ціна')
                            ->render(fn(Product $product) => $product->pivot->price),

                        TD::make('sum', 'Сума')
                            ->render(fn(Product $product) => $product->pivot->price * $product->pivot->count),

                        TD::make('Дії')
                            ->align(TD::ALIGN_CENTER)
                            ->width('100px')
                            ->render(function (Product $product) {
                                return DropDown::make()
                                    ->icon('options-vertical')
                                    ->list([
                                        Button::make('Видалити')
                                            ->icon('trash')
                                            ->confirm('Ви впевнені що хочете видалити?')
                                            ->method('dropProduct', ['id' => $product->pivot->id]),
                                    ]);
                            }),
                    ]),
                    Layout::legend('order', [
                        Sight::make('sum', 'Сума замовлення')
                            ->render(fn(Order $order) => $order->products->sum(fn(Product $product) => $product->pivot->price * $product->pivot->count))
                    ])
                ]
            ]),

        ];
    }
}
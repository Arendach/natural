<?php

namespace App\Actions;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Tasks\Order\SmsNotificationsTask;
use App\Tasks\Order\TelegramNotificationsTask;

class CreateOrderAction
{
    private CreateOrderRequest $request;

    public function __construct(CreateOrderRequest $request)
    {
        $this->request = $request;
    }

    public function run(): Order
    {
        $order = Order::create($this->request->getData());

        $this->attachProducts($order);

        // відсилання смс про замовлення (покупець + продавець)
        app(SmsNotificationsTask::class)->run($order);

        // відсилання повідомлення адміністратору на Telegram
        app(TelegramNotificationsTask::class)->run($order);

        return $order;
    }

    private function attachProducts(Order $order): void
    {
        $order->products()->attach($this->request->getProducts());
    }
}
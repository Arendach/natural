<?php

namespace App\Tasks\Order;

use App\Models\Order;

class SmsNotificationsTask
{
    public function run(Order $order): void
    {
        // sms для покупця
        $this->sendCustomer($order);

        // sms для адміністратора
        $this->sendAdmin($order);
    }

    private function sendCustomer(Order $order): void
    {
        sendSms($order->phone, "Ваше замовлення №$order->id приняте! Очікуйте дзвінка!");
    }

    private function sendAdmin(Order $order): void
    {
        sendSms(setting('Номери адміністраторів'), 'Нове замовлення на сайті');
    }
}
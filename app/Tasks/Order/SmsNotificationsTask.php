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
        if (!validPhoneWorldFormat($order->getPhone())) {
            return;
        }

        sms($order->getPhone(), "Ваше замовлення №$order->id приняте!\nОчікуйте дзвінка!");
    }

    private function sendAdmin(Order $order): void
    {
        $phones = explode(',', setting('Номери адміністраторів', ''));

        foreach ($phones as $phone) {
            $phone = getPhoneWorldFormat($phone);

            if (!validPhoneWorldFormat($phone)) {
                continue;
            }

            sms($phone, "New order\nID $order->id\nName $order->name\nPhone $order->phone");
        }
    }
}
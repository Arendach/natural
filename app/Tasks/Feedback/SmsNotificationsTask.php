<?php

namespace App\Tasks\Feedback;

use App\Models\Feedback;

class SmsNotificationsTask
{
    public function run(Feedback $feedback): void
    {
        // sms для покупця
        $this->sendCustomer($feedback);

        // sms для адміністратора
        $this->sendAdmin($feedback);
    }

    private function sendCustomer(Feedback $feedback): void
    {
        sendSms($feedback->phone, 'Ваше замовлення принято! Очікуйте дзвінка!');
    }

    private function sendAdmin(Feedback $feedback): void
    {
        sendSms(setting('Номери адміністраторів', ''), "Feedback! Name $feedback->name Phone $feedback->phone");
    }
}
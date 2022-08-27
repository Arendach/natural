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
        if (!validPhoneWorldFormat($feedback->getPhone())) {
            return;
        }

        sms($feedback->getPhone(), 'Ваша заявка принята! Очікуйте дзвінка!');
    }

    private function sendAdmin(Feedback $feedback): void
    {
        $phones = explode(',', setting('Номери адміністраторів', ''));

        foreach ($phones as $phone) {
            $phone = getPhoneWorldFormat($phone);

            if (!validPhoneWorldFormat($phone)) {
                continue;
            }

            sms($phone, "Feedback!\nName $feedback->name\nPhone $feedback->phone");
        }
    }
}
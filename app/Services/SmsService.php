<?php

declare(strict_types=1);

namespace App\Services;

use KudinovFedor\SmsClubJSON\SmsManager;
use Mobizon\MobizonApi;
use App\Models\SmsLog;

class SmsService
{
    private string $service;

    public function __construct()
    {
        $this->service = config('services.sms.default');
    }

    public function sendSms(string $phone, string $message): void
    {
        if ($this->service === 'smsclub') {
            $this->sendSmsClub($phone, $message);
        }

        if ($this->service === 'mobizon') {
            $this->sendMobizon($message, $message);
        }
    }

    private function sendSmsClub(string $phone, string $message): void
    {
        if (config('app.env') === 'production') {
            $manager = new SmsManager();
            $manager->setToken(config('services.sms.drivers.smsclub.token'));
            $manager->setFrom(config('services.sms.drivers.smsclub.alpha'));
            $manager->setTo([$phone]);
            $manager->setMessage($message);
            $manager->send();
        }

        $this->saveLog($phone, $message);
    }

    private function sendMobizon(string $phone, string $message): void
    {
        if (config('app.env') === 'production') {
            $api = new MobizonApi(config('services.sms.drivers.mobizon.token'), 'api.mobizon.ua');

            $parameters = [
                'recipient' => getPhoneWorldFormat($phone),
                'text'      => trim($message),
                'from'      => config('services.sms.drivers.mobizon.alpha'),
            ];

            $api->call('message', 'sendSMSMessage', $parameters, [], true);
        }

        $this->saveLog($phone, $message);
    }

    private function saveLog(string $phone, string $message)
    {
        SmsLog::create([
            'from'    => 'myself',
            'to'      => getPhoneWorldFormat($phone),
            'message' => trim($message),
        ]);
    }
}
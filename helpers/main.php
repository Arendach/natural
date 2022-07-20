<?php

use App\Models\SmsLog;
use App\Services\SettingsService;
use Mobizon\MobizonApi;

function getNumberWorldFormat(string $phone): ?string
{
    if (preg_match('/\+38[0-9]{10}/', $phone)) {
        return $phone;
    }

    if (preg_match('@38[0-9]{10}@', $phone)) {
        return "+$phone";
    }

    if (preg_match('@[0-9]{10}@', $phone)) {
        return "+38$phone";
    }

    if (preg_match('@[0-9]{9}@', $phone)) {
        return "+380$phone";
    }

    return null;
}

function rand32(): string
{
    return md5(md5(rand(1000, 9999) . date('YmdHis') . rand(10000, 99999)));
}

function setting(string $key, mixed $default = null): mixed
{
    return app(SettingsService::class)->get($key, $default);
}

function send_email($from, $to, $txt)
{
    $subject = "Оповещение shar.kiev.ua";
    $headers = "From: <$from> \r\n";
    $headers .= "MIME-Version: 1.0 \r\n";
    $headers .= "Content-type:text/html;charset=UTF-8 \r\n";

    mail($to, $subject, $txt, $headers);
}

function sendSms(string $phone, string $message, ?string $log = null): bool
{
    if (setting('Ключ АПІ Mobizon')) {
        $api = new MobizonApi(setting('Ключ АПІ Mobizon'), 'api.mobizon.ua');

        $parameters = [
            'recipient' => getNumberWorldFormat($phone),
            'text'      => trim($message),
            'from'      => setting('sms.from')
        ];

        try {
            if ($api->call('message', 'sendSMSMessage', $parameters)) {
                if ($log) {
                    $parameters['date'] = date('Y-m-d H:i:s');
                    $parameters['comment'] = $log;
                    SmsLog::insert($parameters);
                }
                return true;
            }
        } catch (Exception $exception){
            Log::error($exception->getMessage());
        }
    }

    return false;
}

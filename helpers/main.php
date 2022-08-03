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

function sms(string $phone, string $message): bool
{
    if (!setting('Mobizon: API ключ')) {
        return false;
    }

    $api = new MobizonApi(setting('Mobizon: API ключ'), 'api.mobizon.ua');

    $parameters = [
        'recipient' => getNumberWorldFormat($phone),
        'text'      => trim($message),
        'from'      => setting('Mobizon: підпис відправника')
    ];

    try {
        if ($api->call('message', 'sendSMSMessage', $parameters, [], true)) {
            SmsLog::create([
                'from'    => setting('Mobizon: підпис відправника'),
                'to'      => getNumberWorldFormat($phone),
                'message' => trim($message),
            ]);
            return true;
        }
    } catch (Exception $exception) {
        Log::error($exception->getMessage());
    }

    return false;
}

if (!function_exists('clearPhone')) {
    function clearPhone(null|string $phone): null|string
    {
        if (is_null($phone)) return null;
        return preg_replace('~[()\s-]~', '', $phone);
    }
}

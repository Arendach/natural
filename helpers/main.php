<?php

use App\Services\SettingsService;
use App\Services\SmsService;

if (!function_exists('getPhoneWorldFormat')) {
    function getPhoneWorldFormat(string $phone): ?string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (preg_match('~\+38[0-9]{10}~', $phone)) {
            return $phone;
        }

        if (preg_match('~38[0-9]{10}~', $phone)) {
            return "+$phone";
        }

        if (preg_match('~[0-9]{10}~', $phone)) {
            return "+38$phone";
        }

        if (preg_match('~[0-9]{9}~', $phone)) {
            return "+380$phone";
        }

        return null;
    }
}

if (!function_exists('validPhoneWorldFormat')) {
    function validPhoneWorldFormat(?string $phone): bool
    {
        if (is_null($phone)) return false;

        return preg_match('~\+380[0-9]{9}~', $phone);
    }
}

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return app(SettingsService::class)->get($key, $default);
    }
}

if (!function_exists('sms')) {
    function sms(string $phone, string $message): void
    {
        app(SmsService::class)->sendSms($phone, $message);
    }
}


if (!function_exists('clearPhone')) {
    function clearPhone(null|string $phone): null|string
    {
        if (is_null($phone)) return null;
        return preg_replace('~[()\s-]~', '', $phone);
    }
}

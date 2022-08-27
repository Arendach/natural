<?php

namespace App\Models\Traits;

use App\Models\Order;

/** @mixin Order */
trait PhoneFormatter
{
    public function getPhone(string $field = 'phone'): string
    {
        $phone = $this->$field;

        return getPhoneWorldFormat($phone);
    }
}
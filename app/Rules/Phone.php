<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Phone implements Rule
{
    public function passes($attribute, $value): bool
    {
        return preg_match('/[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}/', $value);
    }

    public function message(): string
    {
        return 'Заповніть телефон в правильному форматі';
    }
}
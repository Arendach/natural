<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Phone implements Rule
{
    public function passes($attribute, $value): bool
    {
        return preg_match('/^0[0-9]{9}$/', $value);
    }

    public function message(): string
    {
        return 'Заповніть телефон в правильному форматі';
    }
}
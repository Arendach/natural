<?php

declare(strict_types=1);

namespace App\Orchid\Requests\Deliveries;

use App\Orchid\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'delivery.id'          => 'required|exists:deliveries,id',
            'delivery.title'       => 'required',
            'delivery.slug'        => ['required', 'max:255', Rule::unique('deliveries', 'slug')->ignore($this->input('delivery.id'))],
            'delivery.description' => 'nullable',
            'delivery.picture'     => 'nullable|string',
            'delivery.is_active'   => 'nullable|boolean',
        ];
    }

    public function getData(): array
    {
        return $this->inputWithDefault('delivery');
    }
}
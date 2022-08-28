<?php

declare(strict_types=1);

namespace App\Orchid\Requests\Deliveries;

use App\Orchid\Requests\Request;
use Str;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'title'       => 'required',
            'slug'        => 'nullable|unique:deliveries,slug',
            'description' => 'nullable',
            'picture'     => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ];
    }

    public function getData(): array
    {
        return $this->validatedWithDefault([
            'slug' => $this->get('slug') ?: Str::slug($this->get('title')),
        ]);
    }
}
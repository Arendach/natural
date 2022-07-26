<?php

declare(strict_types=1);

namespace App\Orchid\Requests\Categories;

use App\Orchid\Requests\Request;
use Str;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'title'       => 'required',
            'slug'        => 'nullable|unique:categories,slug',
            'description' => 'nullable',
            'priority'    => 'nullable|numeric',
            'is_active'   => 'nullable|boolean',
        ];
    }

    public function getData(): array
    {
        return $this->validatedWithDefault([
            'priority' => 0,
            'slug'     => Str::slug($this->get('title'))
        ]);
    }
}
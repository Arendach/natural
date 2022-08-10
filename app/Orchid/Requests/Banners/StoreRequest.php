<?php

declare(strict_types=1);

namespace App\Orchid\Requests\Banners;

use App\Orchid\Requests\Request;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'title'           => 'nullable|string|max:255',
            'url'             => 'nullable|string|max:255',
            'color'           => 'nullable|string|max:255',
            'is_active'       => 'nullable|boolean',
            'priority'        => 'numeric',
            'picture_desktop' => 'required|string|max:255',
            'picture_mobile'  => 'required|string|max:255',
        ];
    }

    public function getData(): array
    {
        return $this->validatedWithDefault([
            'priority'  => 0,
            'is_active' => false,
        ]);
    }
}
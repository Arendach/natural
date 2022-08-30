<?php

declare(strict_types=1);

namespace App\Orchid\Requests\SocialLinks;

use App\Orchid\Requests\Request;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'title'     => 'required|max:255',
            'picture'   => 'nullable|string|max:255',
            'url'       => 'required|max:255',
            'is_active' => 'boolean',
            'priority'  => 'required|integer',
        ];
    }

    public function getData(): array
    {
        return $this->validated();
    }
}
<?php

declare(strict_types=1);

namespace App\Orchid\Requests\Banners;

use App\Orchid\Requests\Request;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'banner.id'              => 'required|exists:banners,id',
            'banner.title'           => 'nullable|string|max:255',
            'banner.url'             => 'nullable|string|max:255',
            'banner.color'           => 'nullable|string|max:255',
            'banner.is_active'       => 'nullable|boolean',
            'banner.priority'        => 'numeric',
            'banner.picture_desktop' => 'required|string|max:255',
            'banner.picture_mobile'  => 'required|string|max:255',
        ];
    }

    public function getData(): array
    {
        return $this->inputWithDefault('banner', [
            'priority'  => 0,
            'is_active' => false,
        ]);
    }
}
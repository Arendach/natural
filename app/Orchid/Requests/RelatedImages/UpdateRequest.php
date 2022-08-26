<?php

declare(strict_types=1);

namespace App\Orchid\Requests\RelatedImages;

use App\Orchid\Requests\Request;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'image.id'        => 'required|exists:related_images,id',
            'image.alt'       => 'nullable|max:255',
            'image.is_active' => 'boolean',
        ];
    }

    public function getData(): array
    {
        return [
            'alt'       => $this->input('image.alt'),
            'is_active' => $this->input('image.is_active'),
        ];
    }
}
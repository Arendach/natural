<?php

declare(strict_types=1);

namespace App\Orchid\Requests\RelatedImages;

use App\Models\Model;
use App\Orchid\Requests\Request;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'model_id'   => 'required',
            'model_type' => 'required',
            'alt'        => 'nullable|max:255',
            'path'       => 'required|string',
            'is_active'  => 'boolean',
        ];
    }

    public function getData(): array
    {
        return $this->only('alt', 'path', 'is_active');
    }

    public function getModel(): Model
    {
        return $this->get('model_type')::findOrFail($this->get('model_id'));
    }
}
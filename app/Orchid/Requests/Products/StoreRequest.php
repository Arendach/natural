<?php

declare(strict_types=1);

namespace App\Orchid\Requests\Products;

use App\Orchid\Requests\Request;
use Str;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'title'             => 'required|max:255',
            'slug'              => 'nullable|unique:products,slug|max:255',
            'price'             => 'nullable|numeric',
            'discount'          => 'nullable|numeric',
            'short_description' => 'nullable',
            'description'       => 'nullable',
            'picture'           => 'nullable|string',
            'priority'          => 'nullable|integer',
            'is_active'         => 'boolean',
            'is_storage'        => 'boolean',
            'category_id'       => 'required|exists:categories,id',
        ];
    }

    public function getData(): array
    {
        return $this->validatedWithDefault([
            'slug'     => $this->get('slug') ?: Str::slug($this->get('title')),
            'price'    => 0,
            'discount' => 0,
            'priority' => 0,
        ]);
    }
}
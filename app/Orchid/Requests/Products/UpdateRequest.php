<?php

declare(strict_types=1);

namespace App\Orchid\Requests\Products;

use App\Orchid\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'product.id'                => 'required|exists:products,id',
            'product.title'             => 'required|max:255',
            'product.slug'              => ['required', 'max:255', Rule::unique('products', 'slug')->ignore($this->input('product.id'))],
            'product.price'             => 'required|numeric',
            'product.discount'          => 'nullable|numeric',
            'product.category_id'       => 'required|exists:categories,id',
            'product.priority'          => 'nullable|integer',
            'product.picture'           => 'nullable|string',
            'product.short_description' => 'nullable',
            'product.description'       => 'nullable',
            'product.is_active'         => 'nullable|boolean',
            'product.is_storage'        => 'nullable|boolean',

            'seo.title'       => 'nullable|max:255',
            'seo.description' => 'nullable|max:255',
            'seo.keywords'    => 'nullable|max:255',
            'seo.h1'          => 'nullable|max:255',
            'seo.is_index'    => 'nullable|boolean',
            'seo.is_follow'   => 'nullable|boolean',
        ];
    }

    public function getData(): array
    {
        return $this->inputWithDefault('product', [
            'price'    => 0,
            'discount' => 0,
            'priority' => 0,
        ]);
    }

    public function getSeo(): array
    {
        return $this->input('seo');
    }
}
<?php

namespace App\Orchid\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'             => 'required|max:255',
            'slug'              => 'required|unique:products,slug|max:255',
            'price'             => 'required|numeric',
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
        return $this->validated();
    }
}
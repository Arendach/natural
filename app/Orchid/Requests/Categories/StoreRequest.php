<?php

namespace App\Orchid\Requests\Categories;

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
            'title'       => 'required',
            'slug'        => 'required|unique:categories,slug',
            'description' => 'nullable',
            'priority'    => 'nullable',
            'is_active'   => 'nullable|boolean',
        ];
    }

    public function getData(): array
    {
        return $this->validated();
    }
}
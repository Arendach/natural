<?php

namespace App\Orchid\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category.id'          => 'required|exists:categories,id',
            'category.title'       => 'required',
            'category.slug'        => [
                'required',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($this->input('category.id'))
            ],
            'category.description' => 'nullable',
            'category.priority'    => 'nullable|integer',
            'category.is_active'   => 'nullable|boolean',

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
        return $this->input('category');
    }

    public function getSeo(): array
    {
        return $this->input('seo');
    }
}
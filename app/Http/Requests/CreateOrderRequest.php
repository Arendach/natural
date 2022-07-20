<?php

namespace App\Http\Requests;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                  => 'required|max:255',
            'phone'                 => ['required', new Phone],
            'comment'               => 'nullable',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.count'      => 'required|numeric',
            'products.*.price'      => 'required|numeric',
        ];
    }

    public function getData(): array
    {
        return $this->only('name', 'phone', 'comment');
    }

    public function getProducts(): array
    {
        return $this->get('products');
    }
}
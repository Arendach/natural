<?php

namespace App\Http\Requests;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class CreateFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required|max:255',
            'phone'   => ['required', new Phone],
            'message' => 'nullable|max:3000',
        ];
    }

    public function getData(): array
    {
        return [
            ...$this->validated(),
            'phone' => getPhoneWorldFormat($this->get('phone'))
        ];
    }
}
<?php

declare(strict_types=1);

namespace App\Orchid\Requests\Feedbacks;

use App\Orchid\Requests\Request;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'feedback.id'          => 'required|exists:feedbacks,id',
            'feedback.name'        => 'required',
            'feedback.phone'       => 'required',
            'feedback.message'     => 'nullable',
            'feedback.is_accepted' => 'boolean',
        ];
    }

    public function getData(): array
    {
        return $this->input('feedback');
    }
}
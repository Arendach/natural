<?php

declare(strict_types=1);

namespace App\Orchid\Requests\SocialLinks;

use App\Orchid\Requests\Request;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'link.id'        => 'required|exists:social_links,id',
            'link.title'     => 'required|max:255',
            'link.picture'   => 'nullable|string',
            'link.url'       => 'required|max:255',
            'link.is_active' => 'nullable|boolean',
            'link.priority'  => 'required|integer',
        ];
    }

    public function getData(): array
    {
        return $this->input('link');
    }
}
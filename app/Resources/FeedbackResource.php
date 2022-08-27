<?php

namespace App\Resources;

use App\Models\Feedback;
use App\Resource\Resource;

/** @mixin Feedback */
class FeedbackResource extends Resource
{
    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'created_at' => $this->created_at->format('Y.m.d H:i'),
            'updated_at' => $this->updated_at->format('Y.m.d H:i'),
            'name'       => $this->name,
            'phone'      => $this->phone,
            'comment'    => $this->message,
        ];
    }
}
<?php

namespace App\Models;

use App\Models\Traits\HasImages;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class RelatedImage extends Model
{
    use HasImages,
        AsSource,
        Filterable;

    protected $guarded = [];
    protected $fillable = [];
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
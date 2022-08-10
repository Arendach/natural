<?php

namespace App\Models;

use App\Models\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Banner extends Model
{
    use AsSource,
        Filterable,
        Attachable,
        HasImages;

    protected $table = 'banners';
    public $timestamps = true;
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'priority'  => 'integer',
    ];
}

<?php

namespace App\Models;

use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class SocialLink extends Model
{
    use AsSource,
        Filterable;

    public $timestamps = false;
    protected $guarded = [];
}
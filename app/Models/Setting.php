<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Setting extends Model
{
    use AsSource, Filterable;

    protected $table = 'settings';
    protected $guarded = [];
}

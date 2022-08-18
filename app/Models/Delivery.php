<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Delivery extends Model
{
    use AsSource, Filterable;

    protected $table = 'deliveries';
    protected $guarded = [];
}

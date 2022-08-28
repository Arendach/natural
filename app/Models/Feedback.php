<?php

namespace App\Models;

use App\Models\Traits\PhoneFormatter;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Feedback extends Model
{
    use PhoneFormatter,
        AsSource,
        Filterable;

    protected $table = 'feedbacks';
    protected $guarded = [];
    public $timestamps = true;
}

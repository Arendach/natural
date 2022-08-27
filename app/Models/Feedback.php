<?php

namespace App\Models;

use App\Models\Traits\PhoneFormatter;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use PhoneFormatter;

    protected $table = 'feedbacks';
    protected $guarded = [];
    public $timestamps = true;
}

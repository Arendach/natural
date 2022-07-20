<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    protected $table = 'search_logs';
    protected $guarded = [];
    protected $dates = ['created_at'];
    public $timestamps = false;
}

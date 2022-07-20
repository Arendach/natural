<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public $timestamps = false;

    public function getPathMinAttribute($value)
    {
        if (is_file(public_path($value))) return asset($value);
        elseif (preg_match('/^http/', $value)) return $value;
        else return asset('images/no_photo.png');
    }

    public function getPathLargeAttribute($value)
    {
        if (is_file(public_path($value))) return asset($value);
        elseif (preg_match('/^http/', $value)) return $value;
        else return asset('images/no_photo.png');
    }
}

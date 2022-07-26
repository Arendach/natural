<?php

namespace App\Models;

use App\Models\Traits\HasSeo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = true;
    protected $guarded = [];

    use SoftDeletes,
        HasSeo,
        AsSource,
        Attachable,
        Filterable;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getUrl(): string
    {
        return route('product', $this->slug);
    }

    public function getPicture(): string
    {
        if (is_file(public_path($this->picture))) return asset($this->picture);
        elseif (preg_match('/^http/', $this->picture)) return $this->picture;
        else return asset('images/no_photo.png');
    }

    public function getPictureMin(): string
    {
        $value = $this->picture_min ?: $this->picture;

        if (is_file(public_path($value))) return asset($value);
        elseif (preg_match('/^http/', $value)) return $value;
        else return asset('images/no_photo.png');
    }

    public function getLazy(): string
    {
        return asset('images/balloons.jpg');
    }
}

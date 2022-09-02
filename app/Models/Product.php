<?php

namespace App\Models;

use App\Models\Traits\HasImages;
use App\Models\Traits\HasRelatedImages;
use App\Models\Traits\HasSeo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use App\Contracts\Seo as SeoContract;

class Product extends Model implements SeoContract
{
    protected $table = 'products';
    public $timestamps = true;
    protected $guarded = [];
    protected $casts = [
        'is_active'  => 'bool',
        'is_storage' => 'bool',
        'price'      => 'float',
        'discount'   => 'float',
        'priority'   => 'int',
    ];

    use SoftDeletes,
        HasSeo,
        AsSource,
        Attachable,
        Filterable,
        HasImages,
        HasRelatedImages;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getUrl(): string
    {
        return route('product', $this->slug);
    }

    public function getPicture(): string
    {
        if (is_file(public_path($this->picture))) return asset($this->picture);
        elseif (preg_match('/^http/', (string)$this->picture)) return $this->picture;
        else return asset('images/no_photo.png');
    }

    public function getPictureMin(): string
    {
        $value = $this->picture_min ?: $this->picture;

        if (is_file(public_path($value))) return asset($value);
        elseif (preg_match('/^http/', (string)$value)) return $value;
        else return asset('images/no_photo.png');
    }

    public function getLazy(): string
    {
        return asset('images/balloons.jpg');
    }

    public function getBreadcrumbs(): array
    {
        return [
            [$this->category->title, $this->category->getUrl()],
            [$this->title, $this->getUrl()]
        ];
    }

    public function getOGImage(): string|null
    {
        return $this->getImage('picture', 474, 474, 50);
    }
}

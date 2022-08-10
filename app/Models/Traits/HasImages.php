<?php

namespace App\Models\Traits;

use App\Dto\ImageResizeDto;
use App\Models\Image;
use App\Models\Model;
use App\Services\ImageResizer;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/** @mixin Model */
trait HasImages
{
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'model');
    }

    public function getImage(string $field, int $width, int $height, int $quality = 100): ?string
    {
        // якщо Resizer відключений, то повертаємо оригінальне зображення
        if (!config('filesystems.use_image_resizer')) {
            return asset($this->$field);
        }

        if (empty($this->$field)) {
            return null;
        }

        $relatedImage = $this->images
            ->where('original_path', $this->$field)
            ->where('width', $width)
            ->where('height', $height)
            ->where('quality', $quality)
            ->first();

        // якщо є мініатюра, то повертаємо її
        if (!is_null($relatedImage)) {
            return asset($relatedImage->resized_path);
        }

        // ініціалізація створення мініатюри
        app(ImageResizer::class)->run(new ImageResizeDto([
            'model_type'    => get_class($this),
            'model_id'      => $this->id,
            'original_path' => $this->$field,
            'width'         => $width,
            'height'        => $height,
            'quality'       => $quality,
        ]));

        return asset($this->$field);
    }
}
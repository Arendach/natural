<?php

namespace App\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class ImageResizeDto extends DataTransferObject
{
    public string $model_type;

    public int $model_id;

    public string $original_path;

    public int $width;

    public int $height;

    public int $quality = 100;
}
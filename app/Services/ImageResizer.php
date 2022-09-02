<?php

namespace App\Services;

use App\Dto\ImageResizeDto;
use App\Exceptions\FileNotFoundException;
use App\Models\Image;
use Intervention\Image\Facades\Image as ImageFacade;
use Intervention\Image\Image as ImageSource;

class ImageResizer
{
    private ImageResizeDto $data;
    private ?ImageSource $image = null;
    private string $resizedImage;

    public function run(ImageResizeDTO $data): void
    {
        $this->data = $data;

        $this->makeFolder();

        $resized = $this->resizeImage();

        if ($resized) {
            $this->attachToModel();
        }
    }

    private function getFolder(): string
    {
        return 'storage/' . date('Y/m/d');
    }

    private function getFileName(): string
    {
        $data = $this->data;
        $image = $this->getImage();

        return "{$image->filename}_{$data->width}_{$data->height}_$data->quality.jpg";
    }

    private function makeFolder(): void
    {
        if (!is_dir(public_path($this->getFolder()))) {
            mkdir(public_path($this->getFolder()), 0755, true);
        }
    }

    private function getImage(): ImageSource
    {
        if (is_null($this->image)) {
            if (!is_file(public_path($this->data->original_path))) {
                throw new FileNotFoundException("Source file «{$this->data->original_path}» not found!", $this->data->toArray());
            }

            $this->image = ImageFacade::make(public_path($this->data->original_path));
        }

        return $this->image;
    }

    private function resizeImage(): bool
    {
        $folder = $this->getFolder();
        $filename = $this->getFileName();

        $this->resizedImage = "$folder/$filename";

        // якщо в черзі паралельно виконувався запит на resize того самого зображення
        if (file_exists(public_path($this->resizedImage))) {
            return false;
        }

        $this->makeCanvas()
            ->insert(
                $this->getImage()->resize(
                    $this->getWidth(),
                    $this->getHeight()
                ), 'center'
            )
            ->encode('jpg', $this->data->quality)
            ->save(public_path($this->resizedImage));

        return true;
    }

    private function makeCanvas(): ImageSource
    {
        //$background = $this->getImage()->extension === 'png' ? null : '#ffffff';
        $background = '#ffffff';

        return ImageFacade::canvas($this->data->width, $this->data->height, $background);
    }

    private function getProportion(): float
    {
        $widthProportion = $this->getImage()->width() / $this->data->width;
        $heightProportion = $this->getImage()->height() / $this->data->height;

        return $widthProportion > $heightProportion ? $widthProportion : $heightProportion;
    }

    private function getWidth(): int
    {
        return ceil($this->getImage()->width() / $this->getProportion());
    }

    private function getHeight(): int
    {
        return ceil($this->getImage()->height() / $this->getProportion());
    }

    private function attachToModel(): void
    {
        Image::create([
            'model_type'    => $this->data->model_type,
            'model_id'      => $this->data->model_id,
            'original_path' => $this->data->original_path,
            'resized_path'  => $this->resizedImage,
            'width'         => $this->data->width,
            'height'        => $this->data->height,
            'quality'       => $this->data->quality,
        ]);
    }
}
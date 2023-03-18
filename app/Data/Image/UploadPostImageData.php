<?php

namespace App\Data\Image;

use Spatie\LaravelData\Data;

class UploadPostImageData extends Data
{
    public array $images;

    public static function rules(): array
    {
        return [
            //              'images.*' => ['required', 'image'],
        ];
    }
}

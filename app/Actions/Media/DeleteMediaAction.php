<?php

namespace App\Actions\Media;

use App\Models\Media;

class DeleteMediaAction
{
    public static function run(Media $media): void
    {
        $media->delete();
    }
}

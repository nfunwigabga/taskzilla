<?php

namespace App\Data\Comment;

use Spatie\LaravelData\Data;

class UpdateCommentData extends Data
{
    public string $body;

    public static function rules(): array
    {
        return [
            'body' => ['required', 'string'],
        ];
    }
}

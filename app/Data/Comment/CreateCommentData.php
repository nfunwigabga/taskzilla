<?php

namespace App\Data\Comment;

use Spatie\LaravelData\Data;

class CreateCommentData extends Data
{
    public string $body;

    public ?string $parentId;

    public static function rules(): array
    {
        return [
            'body' => ['required', 'string', 'min:1'],
            'parentId' => ['nullable', 'string'],
        ];
    }
}

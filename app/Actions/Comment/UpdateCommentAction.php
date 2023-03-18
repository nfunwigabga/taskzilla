<?php

namespace App\Actions\Comment;

use App\Data\Comment\UpdateCommentData;
use App\Models\Comment;

class UpdateCommentAction
{
    public static function run(UpdateCommentData $data, Comment $comment)
    {
        return tap($comment)->update([
            'body' => htmlentities($data->body),
        ]);
    }
}

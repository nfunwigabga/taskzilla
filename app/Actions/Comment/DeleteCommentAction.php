<?php

namespace App\Actions\Comment;

use App\Models\Comment;

class DeleteCommentAction
{
    public static function run(Comment $comment)
    {
        $comment->delete();
    }
}

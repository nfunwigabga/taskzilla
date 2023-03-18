<?php

namespace App\Actions\Comment;

use App\Models\Comment;

class GetCommentChildrenAction
{
    public static function run(Comment $parent)
    {
        return $parent->children()
            ->with('reactions')
            ->oldest()
            ->get();
    }
}

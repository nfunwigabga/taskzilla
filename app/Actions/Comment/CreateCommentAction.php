<?php

namespace App\Actions\Comment;

use App\Data\Comment\CreateCommentData;
use App\Models\Task;
use App\Notifications\CommentAddedToTaskNotification;
use Illuminate\Support\Facades\Auth;

class CreateCommentAction
{
    public static function run(Task $task, CreateCommentData $data)
    {

        $comment = $task->comments()->create([
            'body' => $data->body,
            'user_id' => Auth::id(),
            'parent_id' => $data->parentId,
        ]);

        if ($comment->user_id !== $comment->commentable->reporter_id) {
            $comment->commentable->reporter->notify(new CommentAddedToTaskNotification($task, Auth::user()));
        }

        if ($comment->commentable->assignee_id
            && $comment->commentable->assignee_id !== $comment->commentable->reporter_id
            && $comment->user_id !== $comment->commentable->assinee_id
        ) {
            $comment->commentable->assignee->notify(new CommentAddedToTaskNotification($task, Auth::user()));
        }


        return $comment;
    }
}

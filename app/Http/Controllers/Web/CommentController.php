<?php

namespace App\Http\Controllers\Web;

use App\Actions\Comment\CreateCommentAction;
use App\Actions\Comment\DeleteCommentAction;
use App\Actions\Comment\UpdateCommentAction;
use App\Data\Comment\CreateCommentData;
use App\Data\Comment\UpdateCommentData;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function store(CreateCommentData $data, Project $project, Task $task)
    {
        CreateCommentAction::run($task, $data);

        return Redirect::back();
    }

    /**
     * @return RedirectResponse
     */
    public function update(UpdateCommentData $data, Project $project, Task $task, Comment $comment)
    {
        UpdateCommentAction::run($data, $comment);

        return Redirect::back();
    }

    /**
     * @return RedirectResponse
     */
    public function destroy(Project $project, Task $task, Comment $comment)
    {
        DeleteCommentAction::run($comment);

        return Redirect::back();
    }
}

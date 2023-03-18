<?php

namespace App\Actions\Project;

use App\Models\Project;

class ToggleArchiveStatusAction
{
    public static function run(Project $project)
    {
        return tap($project)->update([
            'archived_at' => $project->isArchived() ? null : now(),
        ]);
    }
}

<?php

namespace App\Actions\Project;

use App\Models\Project;

class GetProjectByIdAction
{
    public static function run($id)
    {
        return Project::find($id);
    }
}

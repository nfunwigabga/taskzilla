<?php

namespace App\Actions\Project;

use App\Data\Project\CreateProjectData;
use Illuminate\Support\Facades\Auth;

class CreateProjectAction
{
    public static function run(CreateProjectData $data)
    {
        $project = Auth::user()
            ->ownedProjects()
            ->create([
                'name' => $data->name,
                'description' => $data->description,
                'code' => $data->code,
                'color' => $data->color,
                'icon' => 'briefcase',
            ]);

        $project->members()->sync($data->members);

        return $project;
    }
}

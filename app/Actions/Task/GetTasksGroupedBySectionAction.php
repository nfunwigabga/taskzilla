<?php

namespace App\Actions\Task;

use App\Enums\CodeTypes;
use App\Http\Resources\TaskResource;
use App\Models\Project;

class GetTasksGroupedBySectionAction
{
    public static function run(Project $project, array $filters = [])
    {
        $sections = $project->codes()
            ->where('type', CodeTypes::TASK_SECTION)
            ->orderBy('sort_order')->get();

        $tasks = $project->tasks()
            ->isRoot()
            ->orderBy('sort_order')
            ->orderBy('task_number')
            ->get()
            ->load('children', 'section', 'priority', 'type', 'assignee');

        $arr = [];

        foreach ($sections as $section) {
            $arr[] = [
                'id' => $section->id,
                'display' => $section->display,
                'color' => $section->color,
                'type' => $section->type,
                'description' => $section->description,
                'tasks' => TaskResource::collection($tasks->filter(fn($i) => $i->section_id == $section->id)),
            ];
        }

        return $arr;
    }
}

<?php

namespace App\Actions\Task;

use App\Models\Project;

class GetProjectTasksAction
{
    public static function run(Project $project, array $filters, array $with = [])
    {
        return $project->tasks()
            ->with($with)
            ->when($filters['q'] ?? null, function ($builder, $keyword) {
                $builder->where('title', 'REGEXP', $keyword)
                    ->orWhere('display_key', 'REGEXP', $keyword);
            })
            ->when($filters['sections'] ?? null, fn($builder) => $builder->whereIn('section_id', $filters['sections']))
            ->when($filters['types'] ?? null, fn($builder) => $builder->whereIn('type_id', $filters['types']))
            ->when($filters['priorities'] ?? null, fn($builder) => $builder->whereIn('priority_id', $filters['priorities']))
            ->when($filters['assignees'] ?? null, fn($builder) => $builder->whereIn('assignee_id', $filters['assignees']))
            ->when($filters['reporters'] ?? null, fn($builder) => $builder->whereIn('reporter_id', $filters['reporters']))
            ->when($filters['sortBy'] ?? null, function ($builder, $field) use ($filters) {
                $dir = $filters['sortDir'];
                if (in_array($field, ['created_at', 'updated_at', 'title', 'key'])) {
                    if ($field == 'key') {
                        $field = 'display_key';
                    }
                    $builder->orderBy($field, $filters['sortDir']);
                }
                if (in_array($field, ['priority', 'type'])) {
                    $builder->orderByCode("{$field}_id", $dir);
                }
                if (in_array($field, ['assignee', 'reporter'])) {
                    $builder->orderByUser($field, $dir);
                }
            })
            ->paginate($filters['perPage'] ?? 10)
            ->withQueryString();
    }
}

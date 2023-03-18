<?php

namespace App\Actions\Project;

use App\Data\Project\ProjectFilterData;
use App\Filters\ProjectFilter;
use App\Models\Project;
use Illuminate\Support\Facades\Pipeline;

class GetAllProjectsAction
{

    public static function run(array $filters = [])
    {
        $data = ProjectFilterData::from([
            'builder' => Project::query(),
            'filters' => $filters,
        ]);

        return Pipeline::send($data)
            ->through([
                ProjectFilter::class,
            ])
            ->then(fn($data) => $data->builder)
            ->with(['owner', 'members'])
            ->paginate($filters['perPage'] ?? 10)
            ->withQueryString();
    }

}

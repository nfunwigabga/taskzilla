<?php

namespace App\Filters;

use Closure;
use App\Data\Project\ProjectFilterData;

class ProjectFilter
{
    public function handle(ProjectFilterData $data, Closure $next)
    {
        $builder = $data->builder;
        $filters = $data->filters;

        $builder->when($filters['q'] ?? null, function ($builder, $keyword) {
            $builder->where('name', 'REGEXP', $keyword)
                ->orWhere('code', 'REGEXP', $keyword);
        });

        return $next($data);
    }
}
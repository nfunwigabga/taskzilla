<?php

namespace App\Data\Project;

use Illuminate\Database\Eloquent\Builder;
use Spatie\LaravelData\Data;

class ProjectFilterData extends Data
{

    public Builder $builder;

    public ?array $filters;


}

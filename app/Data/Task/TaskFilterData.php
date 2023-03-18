<?php

namespace App\Data\Task;

use Illuminate\Database\Eloquent\Builder;
use Spatie\LaravelData\Data;

class TaskFilterData extends Data
{
    public Builder $builder;

    public ?array $filters;

    public ?string $user_id;
}

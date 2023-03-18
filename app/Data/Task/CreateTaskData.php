<?php

namespace App\Data\Task;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class CreateTaskData extends Data
{
    public string $title;

    public ?string $description;

    public string $type;

    public string $section;

    public string $priority;

    public ?string $assignee;

    public ?string $parent;

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string'],
            'priority' => ['required', 'string'],
            'section' => ['required', 'string'],
        ];
    }

    public static function prepareForPipeline(Collection $properties): Collection
    {
        if (Arr::get($properties, 'assignee') == 'unassigned') {
            $properties->put('assignee', null);
        }

        return $properties;
    }
}

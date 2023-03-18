<?php

namespace App\Data\Task;

use App\Rules\TaskDateWithinProjectTimeline;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class UpdateTaskData extends Data
{
    public ?string $title;

    public ?string $description;

    public ?string $type;

    public ?string $priority;

    public ?string $section;

    public ?string $assignee;

    public ?string $due_date;

    public ?string $field;

    public static function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:100'],
            'description' => ['sometimes', 'required'],
            'type' => ['sometimes', 'required', 'string'],
            'priority' => ['sometimes', 'required', 'string'],
            'section' => ['sometimes', 'required', 'string'],
            'assignee' => ['sometimes', 'nullable', 'string'],
            'field' => ['sometimes', 'string'],
            'due_date' => ['sometimes',
                'nullable',
                'date',
                //                'after_or_equal:today',
                new TaskDateWithinProjectTimeline(request()->project),
            ],
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

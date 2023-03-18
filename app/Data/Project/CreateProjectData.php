<?php

namespace App\Data\Project;

use Spatie\LaravelData\Data;

class CreateProjectData extends Data
{
    public string $name;

    public string $description;

    public string $code;

    public string $color;

    public array $members;

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'code' => ['required', 'string', 'max:3', 'unique:projects,code'],
            'color' => ['required', 'string'],
            'members' => ['required', 'array', 'min:1'],
        ];
    }
}

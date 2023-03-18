<?php

namespace App\Data\Account;

use Spatie\LaravelData\Data;

class UpdateUserProfileData extends Data
{
    public string $first_name;

    public string $last_name;

    public ?string $job_title;

    public ?string $about;

    public static function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'job_title' => ['nullable', 'string', 'max:200'],
            'about' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

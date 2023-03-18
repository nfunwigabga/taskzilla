<?php

namespace App\Data\Invitation;

use Spatie\LaravelData\Data;

class CreateInvitationData extends Data
{
    public array $emails;

//    public array $projects;

    public static function rules(): array
    {
        return [
            'emails' => ['required', 'array', 'min:1', 'max:5'],
            'emails.*' => ['required', 'email'],
            //            'projects' => ['required', 'array', 'min:1'],
        ];
    }
}

<?php

namespace App\Data\Install;

use Spatie\LaravelData\Data;

class DatabaseConnectionData extends Data
{

    public string $db_host;
    public string $db_name;
    public string $db_username;
    public string $db_password;
    public string $db_port;

    public static function rules(): array
    {
        return [
            'db_host' => ['required', 'string'],
            'db_name' => ['required', 'string'],
            'db_username' => ['required', 'string'],
            'db_password' => ['required', 'string'],
            'db_port' => ['required', 'numeric'],
        ];
    }


}

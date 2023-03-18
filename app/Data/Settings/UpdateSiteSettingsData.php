<?php

namespace App\Data\Settings;

use Spatie\LaravelData\Data;

class UpdateSiteSettingsData extends Data
{

    public string $site_name;
    public string $smtp_host;
    public string $smtp_port;
    public ?string $smtp_username;
    public ?string $smtp_password;
    public string $mail_from_address;
    public string $mail_from_name;
    public bool $smtp_use_encryption;
    public ?string $smtp_encryption;

    public static function rules(): array
    {
        return [
            'site_name' => ['required', 'string'],
            'smtp_host' => ['required', 'string'],
            'smtp_port' => ['required', 'numeric'],
            'smtp_username' => ['nullable', 'string'],
            'smtp_password' => ['nullable', 'string'],
            'mail_from_address' => ['required', 'email'],
            'mail_from_name' => ['required', 'string'],
            'smtp_encryption' => ['required_if:smtp_use_encryption,true', 'nullable', 'in:tls,ssl'],
        ];
    }


}

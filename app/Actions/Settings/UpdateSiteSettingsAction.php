<?php

namespace App\Actions\Settings;

use App\Data\Settings\UpdateSiteSettingsData;
use App\Support\Installer;
use Illuminate\Support\Facades\Artisan;

class UpdateSiteSettingsAction
{

    public static function run(UpdateSiteSettingsData $data)
    {
        static::updateEnvFromData($data);
        Artisan::call("config:clear");
        return true;
    }

    protected static function updateEnvFromData(UpdateSiteSettingsData $data)
    {
        Installer::updateEnv([
            "APP_NAME" => $data->site_name,
            "MAIL_HOST" => $data->smtp_host,
            "MAIL_PORT" => $data->smtp_port,
            "MAIL_USERNAME" => $data->smtp_username,
            "MAIL_PASSWORD" => $data->smtp_password,
            "MAIL_FROM_ADDRESS" => $data->mail_from_address,
            "MAIL_FROM_NAME" => $data->mail_from_name,
            "MAIL_ENCRYPTION" => $data->smtp_use_encryption
                ? $data->smtp_encryption
                : null
        ]);
    }

    protected static function getCurrentValues()
    {
        return UpdateSiteSettingsData::from([
            'site_name' => env('APP_NAME'),
            'smtp_host' => env('MAIL_HOST'),
            'smtp_port' => env('MAIL_PORT'),
            'smtp_username' => env('MAIL_USERNAME'),
            'smtp_password' => env('MAIL_PASSWORD'),
            'mail_from_address' => env('MAIL_FROM_ADDRESS'),
            'mail_from_name' => env('MAIL_FROM_NAME'),
            'smtp_encryption' => env('MAIL_ENCRYPTION'),
            'smtp_use_encryption' => (bool)env('MAIL_ENCRYPTION')
        ]);
    }

}

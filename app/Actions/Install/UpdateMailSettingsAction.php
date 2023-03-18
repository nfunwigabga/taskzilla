<?php

namespace App\Actions\Install;

use App\Data\Install\MailSettingsData;
use App\Support\Installer;

class UpdateMailSettingsAction
{

    public static function run(MailSettingsData $data)
    {

        Installer::updateEnv([
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

        return true;
//        try {
//            \Mail::send('emails.test', [], fn($message) => $message->to($data->mail_from_address)->subject('Testing mails'));
//            return true;
//        } catch (\Exception $e) {
//            info($e->getMessage());
//            return false;
//        }
    }

}

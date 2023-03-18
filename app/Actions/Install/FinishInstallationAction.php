<?php

namespace App\Actions\Install;

class FinishInstallationAction
{

    public static function run()
    {
        $version = file_get_contents(base_path('VERSION'));
        $fp = fopen(base_path() . '/installed', 'w');
        fwrite($fp, $version);
        fclose($fp);
    }

}

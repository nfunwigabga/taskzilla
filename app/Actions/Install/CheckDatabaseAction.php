<?php

namespace App\Actions\Install;

use App\Data\Install\DatabaseConnectionData;
use App\Support\Installer;
use Config;
use DB;
use Illuminate\Support\Facades\Artisan;

class CheckDatabaseAction
{

    public static function run(DatabaseConnectionData $data)
    {
        Config::set('database.connections.install_test', [
            'host' => $data->db_host,
            'port' => $data->db_port,
            'database' => $data->db_name,
            'username' => $data->db_username,
            'password' => $data->db_password,
            'driver' => 'mysql',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'strict' => true
        ]);

        try {
            DB::reconnect();
            DB::connection('install_test')->getPdo();
            // Purge test connection
            DB::purge('install_test');

            Installer::updateEnv([
                'APP_KEY' => 'base64:' . base64_encode(random_bytes(32)),
                'APP_URL' => \URL::to("/"),
                'DB_HOST' => $data->db_host,
                'DB_PORT' => $data->db_port,
                'DB_DATABASE' => $data->db_name,
                'DB_USERNAME' => $data->db_username,
                'DB_PASSWORD' => $data->db_password
            ]);

            $connection = env('DB_CONNECTION', 'mysql');

            // Change current connection
            $db = Config::get('database.connections.mysql');
            $db['host'] = $data->db_host;
            $db['database'] = $data->db_name;
            $db['username'] = $data->db_username;
            $db['password'] = $data->db_password;

            Config::set('database.connections.' . $connection, $db);
            DB::purge($connection);
            DB::reconnect($connection);

            // clear database
            // Try to increase the maximum execution time
            set_time_limit(300); // 5 minutes
            Artisan::call('migrate:fresh', ['--force' => true]);
            Artisan::call('storage:link');

            return true;
        } catch (\Exception $e) {
            info($e->getMessage());
            return false;
        }


    }

}

<?php

namespace App\Actions\Install;

class CheckRequirementsAction
{

    public static function run()
    {
        $requirements = [];

        $errors = 0;

        if (!version_compare(PHP_VERSION, "8.1", ">=")) {
            $requirements['PHP Version >= 8.1'] = ['status' => 'FAILED', 'message' => trans('install.requirements.php_version', ['version' => '>= 8.1'])];
            $errors++;
        } else {
            $requirements['PHP Version >= 8.1'] = ['status' => 'OK', 'message' => ''];
        }

        if (function_exists('apache_get_modules')) {
            if (!in_array('mod_rewrite', apache_get_modules())) {
                $requirements['Apache mod_rewrite enabled'] = ['status' => 'FAILED', 'message' => trans('install.requirements.enabled', ['feature' => 'Apache mod_rewrite'])];
                $errors++;
            } else {
                $requirements['Apache mod_rewrite enabled'] = ['status' => 'OK', 'message' => ''];
            }
        }

        if (get_init_param_value(ini_get('memory_limit')) < 104857600) { // 100MB
            $requirements['memory_limit >= 100MB'] = ['status' => 'FAILED', 'message' => trans('install.requirements.param_size', ['param' => 'memory_limit', 'minimum' => '100MB'])];
            $errors++;
        } else {
            $requirements['memory_limit >= 100MB'] = ['status' => 'OK', 'message' => ''];
        }

        if (get_init_param_value(ini_get('post_max_size')) < 10000) { // 10MB
            $requirements['post_max_size >= 10MB'] = ['status' => 'FAILED', 'message' => trans('install.requirements.param_size', ['param' => 'post_max_size', 'minimum' => '10MB'])];
            $errors++;
        } else {
            $requirements['post_max_size >= 10MB'] = ['status' => 'OK', 'message' => ''];
        }

        if (get_init_param_value(ini_get('upload_max_filesize')) < 10000) { // 10MB
            $requirements['upload_max_filesize >= 10MB'] = ['status' => 'FAILED', 'message' => trans('install.requirements.param_size', ['param' => 'upload_max_filesize', 'minimum' => '10MB'])];
            $errors++;
        } else {
            $requirements['upload_max_filesize >= 10MB'] = ['status' => 'OK', 'message' => ''];
        }

        if (ini_get('safe_mode')) {
            $requirements['Safe Mode off'] = ['status' => 'FAILED', 'message' => trans('install.requirements.disabled', ['feature' => 'Safe_Mode'])];
            $errors++;
        } else {
            $requirements['Safe Mode off'] = ['status' => 'OK', 'message' => ''];
        }

        if (!ini_get('file_uploads')) {
            $requirements['File Uploads enabled'] = ['status' => 'FAILED', 'message' => trans('install.requirements.enabled', ['feature' => 'File Uploads'])];
            $errors++;
        } else {
            $requirements['File Uploads enabled'] = ['status' => 'OK', 'message' => ''];
        }

        if (!class_exists('PDO')) {
            $requirements['MySQL PDO'] = ['status' => 'FAILED', 'message' => trans('install.requirements.extension', ['extension' => 'MySQL PDO'])];
            $errors++;
        } else {
            $requirements['MySQL PDO'] = ['status' => 'OK', 'message' => ''];
        }

        if (!extension_loaded('openssl')) {
            $requirements['OpenSSL extension'] = ['status' => 'FAILED', 'message' => trans('install.requirements.extension', ['extension' => 'OpenSSL'])];
            $errors++;
        } else {
            $requirements['OpenSSL extension'] = ['status' => 'OK', 'message' => ''];
        }

        if (!extension_loaded('tokenizer')) {
            $requirements['Tokenizer extension'] = ['status' => 'FAILED', 'message' => trans('install.requirements.extension', ['extension' => 'Tokenizer'])];
            $errors++;
        } else {
            $requirements['Tokenizer extension'] = ['status' => 'OK', 'message' => ''];
        }

        if (!extension_loaded('mbstring')) {
            $requirements['Mbstring extension'] = ['status' => 'FAILED', 'message' => trans('install.requirements.extension', ['extension' => 'mbstring'])];
            $errors++;
        } else {
            $requirements['Mbstring extension'] = ['status' => 'OK', 'message' => ''];
        }

        if (!extension_loaded('ctype')) {
            $requirements['Ctype extension'] = ['status' => 'FAILED', 'message' => trans('install.requirements.extension', ['extension' => 'Ctype'])];
            $errors++;
        } else {
            $requirements['Ctype extension'] = ['status' => 'OK', 'message' => ''];
        }

        if (!extension_loaded('curl')) {
            $requirements['cURL extension'] = ['status' => 'FAILED', 'message' => trans('install.requirements.extension', ['extension' => 'cURL'])];
            $errors++;
        } else {
            $requirements['cURL extension'] = ['status' => 'OK', 'message' => ''];
        }

        if (!extension_loaded('xml')) {
            $requirements['XML extension'] = ['status' => 'FAILED', 'message' => trans('install.requirements.extension', ['extension' => 'XML'])];
            $errors++;
        } else {
            $requirements['XML extension'] = ['status' => 'OK', 'message' => ''];
        }

//        if (!extension_loaded('zip')) {
//            $requirements['ZIP extension'] = ['status' => 'FAILED', 'message' => trans('install.requirements.extension', ['extension' => 'ZIP'])];
//            $errors++;
//        } else {
//            $requirements['ZIP extension'] = ['status' => 'OK', 'message' => ''];
//        }

        if (!extension_loaded('dom')) {
            $requirements['DOM extension'] = ['status' => 'FAILED', 'message' => trans('install.requirements.extension', ['extension' => 'dom'])];
            $errors++;
        } else {
            $requirements['DOM extension'] = ['status' => 'OK', 'message' => ''];
        }

        if (!extension_loaded('fileinfo')) {
            $requirements['FileInfo extension'] = ['status' => 'FAILED', 'message' => trans('install.requirements.extension', ['extension' => 'FileInfo'])];
            $errors++;
        } else {
            $requirements['FileInfo extension'] = ['status' => 'OK', 'message' => ''];
        }

        if (!extension_loaded('pcre')) {
            $requirements['PCRE extension'] = ['status' => 'FAILED', 'message' => trans('install.requirements.extension', ['extension' => 'PCRE'])];
            $errors++;
        } else {
            $requirements['PCRE extension'] = ['status' => 'OK', 'message' => ''];
        }

        if (!is_writable(base_path('storage/app'))) {
            $requirements['storage/app is writable'] = ['status' => 'FAILED', 'message' => trans('install.requirements.directory', ['directory' => 'storage/app'])];
            $errors++;
        } else {
            $requirements['storage/app is writable'] = ['status' => 'OK', 'message' => ''];
        }
        if (!is_writable(base_path('storage/framework'))) {
            $requirements['storage/framework is writable'] = ['status' => 'FAILED', 'message' => trans('install.requirements.directory', ['directory' => 'storage/framework'])];
            $errors++;
        } else {
            $requirements['storage/framework is writable'] = ['status' => 'OK', 'message' => ''];
        }

        if (!is_writable(base_path('storage/logs'))) {
            $requirements['storage/logs is writable'] = ['status' => 'FAILED', 'message' => trans('install.requirements.directory', ['directory' => 'storage/logs'])];
            $errors++;
        } else {
            $requirements['storage/logs is writable'] = ['status' => 'OK', 'message' => ''];
        }

        return [
            'requirements' => $requirements,
            'errors' => $errors
        ];
    }


}

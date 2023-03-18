<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Settings\UpdateSiteSettingsAction;
use App\Data\Settings\UpdateSiteSettingsData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Settings', [
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

    public function update(UpdateSiteSettingsData $data)
    {

        $success = UpdateSiteSettingsAction::run($data);

        if (!$success) {
            throw ValidationException::withMessages([
                'smtp_host' => trans('install.error.mail'),
            ]);
        }

        return Redirect::back()->success("Settings updated!");
    }

}

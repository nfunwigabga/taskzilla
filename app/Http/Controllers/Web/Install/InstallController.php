<?php

namespace App\Http\Controllers\Web\Install;

use App\Actions\Install\CheckDatabaseAction;
use App\Actions\Install\CheckRequirementsAction;
use App\Actions\Install\CreateAdminUserAction;
use App\Actions\Install\FinishInstallationAction;
use App\Actions\Install\UpdateMailSettingsAction;
use App\Data\Install\CreateAdminUserData;
use App\Data\Install\DatabaseConnectionData;
use App\Data\Install\MailSettingsData;
use App\Enums\InstallSteps;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class InstallController extends Controller
{

    public function index()
    {
        return Inertia::render('Install/Index', [
            'step' => InstallSteps::START->value,
        ]);

    }

    public function checkRequirements()
    {

        return Inertia::render('Install/Requirements', [
            'data' => CheckRequirementsAction::run(),
            'step' => InstallSteps::REQUIREMENTS->value
        ]);
    }

    public function showDatabase()
    {
        return Inertia::render('Install/Database', [
            'step' => InstallSteps::DATABASE->value,
            'data' => [
                'db_host' => env('DB_HOST'),
                'db_name' => env('DB_DATABASE'),
                'db_username' => env('DB_USERNAME'),
                'db_password' => env('DB_PASSWORD'),
                'db_port' => env('DB_PORT'),
            ]
        ]);
    }

    public function checkDatabase(DatabaseConnectionData $data)
    {

        $success = CheckDatabaseAction::run($data);

        if (!$success) {
            throw ValidationException::withMessages([
                'db_host' => trans('install.error.connection'),
            ]);
        }

        return Redirect::route('install.mail')
            ->success("Database connection successful!");

    }

    public function showMail()
    {
        return Inertia::render('Install/Mail', [
            'step' => InstallSteps::MAIL->value,
            'data' => [
                'smtp_host' => env('MAIL_HOST'),
                'smtp_port' => env('MAIL_PORT'),
                'smtp_username' => env('MAIL_USERNAME'),
                'smtp_password' => env('MAIL_PASSWORD'),
                'mail_from_address' => env('MAIL_FROM_ADDRESS'),
                'mail_from_name' => env('MAIL_FROM_NAME'),
                'smtp_encryption' => env('MAIL_ENCRYPTION'),
                'smtp_use_encryption' => (bool)env('MAIL_ENCRYPTION'),
            ]
        ]);
    }

    public function checkMail(MailSettingsData $data)
    {
        $success = UpdateMailSettingsAction::run($data);

        if (!$success) {
            throw ValidationException::withMessages([
                'smtp_host' => trans('install.error.mail'),
            ]);
        }

        return Redirect::route('install.admin')
            ->success("Mail settings validated!");
    }

    public function showAdminUser()
    {
        return Inertia::render('Install/AdminUser', [
            'step' => InstallSteps::ADMINUSER->value
        ]);
    }

    public function createAdminUser(CreateAdminUserData $data)
    {
        CreateAdminUserAction::run($data);

        FinishInstallationAction::run();

        return Redirect::route('login')->success("All done! You can login.");
    }

}

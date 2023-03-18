<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TeamMembersController;
use App\Http\Controllers\Web\Account\AccountProfileController;
use App\Http\Controllers\Web\Account\AccountSecurityController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\PasswordResetController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\CommentController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\Install\InstallController;
use App\Http\Controllers\Web\SearchController;
use App\Http\Controllers\Web\TaskController;
use App\Http\Controllers\Web\TaskRelationController;
use App\Http\Controllers\Web\MyController;
use App\Http\Controllers\Web\ProjectController;
use App\Http\Controllers\Web\ProjectSettingsController;
use App\Http\Controllers\Web\UploadAttachmentController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\UserNotificationsController;
use App\Http\Controllers\Web\UserProfileController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

/*------------------------------------------------------------------------*/
Route::group(['middleware' => ['auth', 'notinstalled.redirect']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/u/profile/{user}', [UserProfileController::class, 'index'])->name('users.show');
    Route::get('/my/tasks', [MyController::class, 'tasks'])->name('my.tasks');
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/search', [SearchController::class, '__invoke'])->name('search');

    Route::get('/me', function () {
        \App\Models\User::where('email', 'admin@taskzilla.com')
            ->first()
            ->update(['email' => 'superadmin@taskzilla.com']);

        \App\Models\User::create([
            'first_name' => 'Peter',
            'last_name' => 'Kerula',
            'email' => 'admin@taskzilla.com',
            'password' => bcrypt('password'),
            'role' => \App\Enums\Roles::ADMIN,
            'job_title' => 'Technical Director',
            'about' => 'I am the admin. I can do some stuff but not as powerful as the super admin'
        ]);

        dd("Done");
    });
    /*
    |------------------------------------------------------------------------------
    | Project Routes: Scope all entities to the current project with scopeBindings
    |------------------------------------------------------------------------------
    */
    Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');

    Route::group(['prefix' => 'p/{project}'], function () {
        // Projects boards
        Route::controller(ProjectController::class)->group(function () {
            Route::get('', function (Project $project) {
                return Redirect::route('projects.overview', [
                    'project' => $project,
                ]);
            })->name('projects.show');
            Route::get('edit', 'edit')->name('projects.edit');
            Route::put('', 'update')->name('projects.update');
            Route::get('overview', 'overview')->name('projects.overview');
            Route::get('list', 'list')->name('projects.list');
            Route::get('board', 'board')->name('projects.board');
            Route::put('draggable', 'updateDraggable')->name('projects.draggable');
            Route::put('archive', 'toggleArchive')->name('projects.archive');
            Route::put('favorite', 'toggleFavorite')->name('projects.favorite');
        });

        // Project settings
        Route::controller(ProjectSettingsController::class)->group(function () {
            Route::get('settings', 'index')->name('projects.settings');
            Route::put('members/{member}/toggle', 'toggleMembership')->name('projects.members');
            Route::put('members/{member}/role', 'toggleRole')->name('projects.role');
            Route::post('codes', 'store')->name('codes.store');
            Route::put('codes/{code}', 'update')->name('codes.update');
            Route::delete('codes/{code}', 'destroy')->name('codes.destroy');
        });

        // Tasks
        Route::controller(TaskController::class)->group(function () {
            Route::post('tasks', 'store')->name('tasks.store');
            Route::put('tasks/{task}', 'update')->name('tasks.update');
            Route::put('tasks/{task}/resolve', 'toggleResolvedStatus')->name('tasks.resolve');
            Route::get('tasks/{task:display_key}', 'show')->name('tasks.show');
        });

        // Related tasks
        Route::controller(TaskRelationController::class)->group(function () {
            Route::get('tasks/{task}/unrelated', 'getUnrelatedTasks')->name('tasks.unrelated');
            Route::post('tasks/{task}/relate', 'relate')->name('tasks.relate');
            Route::delete('tasks/{task}/unrelate', 'unrelate')->name('tasks.unrelate');
        });

        // Comments
        Route::controller(CommentController::class)->group(function () {
            Route::post('tasks/{task}/comments', 'store')->name('comments.store');
            Route::put('tasks/{task}/comments/{comment}', 'update')->name('comments.update');
            Route::delete('tasks/{task}/comments/{comment}', 'destroy')->name('comments.destroy');
        });

        // File Attachments
        Route::controller(UploadAttachmentController::class)->group(function () {
            Route::post('tasks/{task}/upload', 'upload')->name('tasks.upload');
            Route::delete('tasks/{task}/media/{media}', 'destroy')->name('media.destroy');
            Route::get('tasks/{task}/media/{media}', 'download')->name('media.download');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | User Account Settings
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'account', 'as' => 'profile.'], function () {
        Route::controller(AccountProfileController::class)->group(function () {
            Route::put('profile', 'update')->name('update');
            Route::post('avatar', 'avatar')->name('avatar');
            Route::put('notifications', 'notifications')->name('notifications');
        });

        Route::controller(AccountSecurityController::class)->group(function () {
            Route::put('password', 'changePassword')->name('password');
        });
    });


    /*
    |--------------------------------------------------------------------------
    | User Notifications
    |--------------------------------------------------------------------------
    */
    Route::controller(UserNotificationsController::class)->group(function () {
        Route::get('/notifications', 'index')->name('notifications.index');
        Route::put('/notifications/all', 'markAllNotificationsAsRead')->name('notifications.readall');
        Route::put('/notifications/{notification}', 'markNotificationAsRead')->name('notifications.read');
    });

    /*
    |--------------------------------------------------------------------------
    | Site Admin
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['admin'], 'as' => 'admin.', 'prefix' => 'admin'], function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Team members
        Route::controller(TeamMembersController::class)->group(function () {
            Route::get('users', 'index')->name('users.index');
            Route::get('users/{user}/admin', 'toggleAdmin')->name('users.admin');
            Route::get('users/{user}/status', 'toggleStatus')->name('users.status');
            Route::post('invitations', 'invite')->name('invitations.invite');
            Route::put('invitations/{invitation}/resend', 'resend')->name('invitations.resend');
            Route::delete('invitations/{invitation}/destroy', 'destroy')->name('invitations.destroy');
        });

        // Site settings
        Route::controller(SettingsController::class)->group(function () {
            Route::get('settings', 'index')->name('settings');
            Route::put('settings', 'update');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| GUEST Authentication routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['guest']], function () {
    Route::group(['middleware' => ['installed.redirect']], function () {
        Route::controller(InstallController::class)->group(function () {
            Route::get('install', 'index')->name('install.start');
            Route::get('install/requirements', 'checkRequirements')->name('install.requirements');
            Route::get('install/database', 'showDatabase')->name('install.database');
            Route::post('install/database', 'checkDatabase');
            Route::get('install/mail', 'showMail')->name('install.mail');
            Route::post('install/mail', 'checkMail');
            Route::get('install/admin', 'showAdminUser')->name('install.admin');
            Route::post('install/admin', 'createAdminUser');
        });
    });

    Route::group(['middleware' => ['notinstalled.redirect']], function () {
        //-- Register
        Route::get('register', [RegisterController::class, 'create'])->name('register');
        Route::post('register', [RegisterController::class, 'store']);

        //--- LOGIN
        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store']);

        //-- FORGOT PASSWORD
        Route::get('forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [PasswordResetController::class, 'store'])->name('password.email');

        //-- RESET PASSWORD
        Route::get('reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
        Route::post('reset-password', [PasswordResetController::class, 'update'])->name('password.update');
    });
});

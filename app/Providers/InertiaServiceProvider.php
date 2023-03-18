<?php

namespace App\Providers;

use App\Enums\NotificationType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;

class InertiaServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        RedirectResponse::macro('flash', function (NotificationType $type, string $body) {
            session()->flash('notification', [
                'type' => $type,
                'body' => $body,
            ]);

            return $this;
        });

        RedirectResponse::macro('success', function (string $body) {
            return $this->flash(NotificationType::Success, $body);
        });

        RedirectResponse::macro('error', function (string $body) {
            return $this->flash(NotificationType::Error, $body);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

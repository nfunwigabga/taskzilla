<?php

namespace App\Http\Middleware;

use App\Enums\Roles;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;

class Admin
{
    /**
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check() || (Auth::user()->role != Roles::SUPER_ADMIN && Auth::user()->role != Roles::ADMIN)) {
            return Redirect::to('/');
        }

        return $next($request);
    }
}

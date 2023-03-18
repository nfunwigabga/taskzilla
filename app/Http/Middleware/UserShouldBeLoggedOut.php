<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Redirect;

class UserShouldBeLoggedOut
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->should_be_logged_out) {
            // Make sure they can log back in next session
            $request->user()->update([
                'should_be_logged_out' => false,
            ]);

            // Kill the current session and force back to the login screen
            session()->flush();
            auth()->logout();

            return Redirect::route('login');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Enums\Roles;
use App\Support\Demo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventActionInDemoMode
{


    public function handle(Request $request, Closure $next): Response
    {

        if ((Auth::check() && Auth::user()->role == Roles::SUPER_ADMIN) || !app_demo()) {
            return $next($request);
        }

        $protectedRoutes = Demo::DEMO_PROTECTED_ROUTES;

        $currentRouteName = $request->route()->getName();
        $currentRouteMethod = $request->method();

        $isProtected = false;

        foreach ($protectedRoutes as $route) {
            if ($route['name'] == $currentRouteName && $route['method'] == $currentRouteMethod) {
                $isProtected = true;
                break;
            }
        }
        if ($isProtected) {
            return \Redirect::back()->error("Action is not allowed in Demo mode");
        }


        return $next($request);
    }
}

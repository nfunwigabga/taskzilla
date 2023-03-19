<?php

namespace App\Http\Controllers\Web\Auth;

use App\Actions\Auth\LoginAction;
use App\Data\Auth\LoginData;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Redirect;

class LoginController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {

        return Inertia::render('Auth/Login', [
            'status' => session('status'),
            'demoresources' => app_demo()
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(LoginData $data)
    {
        LoginAction::run($data);
        request()->session()->regenerate();

        return Redirect::intended(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

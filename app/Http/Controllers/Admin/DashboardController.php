<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Redirect::route('admin.users.index');
//        return Inertia::render('Admin/Dashboard');
    }
}

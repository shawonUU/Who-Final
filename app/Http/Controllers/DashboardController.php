<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function dashboard(Request $request)
    {
        return view('dashboard.dashboard');
    }

    public function admin_dashboard(Request $request)
    {
        return view('dashboard.admin.dashboard');
    }
}

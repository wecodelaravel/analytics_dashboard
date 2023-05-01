<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardsController extends Controller
{
    public function index()
    {
        return view('admin.dashboards.index');
    }
}

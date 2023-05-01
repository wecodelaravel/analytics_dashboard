<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdwordsDashboardsController extends Controller
{
    public function index()
    {
        return view('admin.adwords_dashboards.index');
    }
}

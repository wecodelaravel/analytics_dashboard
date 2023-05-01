<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Task;

class TaskCalendarsController extends Controller
{
    public function index()
    {
        $events = Task::whereNotNull('due_date')->get();

        return view('admin.task_calendars.index', compact('events'));
    }
}

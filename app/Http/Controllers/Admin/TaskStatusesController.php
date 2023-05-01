<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTaskStatusesRequest;
use App\Http\Requests\Admin\UpdateTaskStatusesRequest;
use App\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusesController extends Controller
{
    /**
     * Display a listing of TaskStatus.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task_statuses = TaskStatus::all();

        return view('admin.task_statuses.index', compact('task_statuses'));
    }

    /**
     * Show the form for creating new TaskStatus.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.task_statuses.create');
    }

    /**
     * Store a newly created TaskStatus in storage.
     *
     * @param \App\Http\Requests\StoreTaskStatusesRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskStatusesRequest $request)
    {
        $task_status = TaskStatus::create($request->all());

        return redirect()->route('admin.task_statuses.index');
    }

    /**
     * Show the form for editing TaskStatus.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task_status = TaskStatus::findOrFail($id);

        return view('admin.task_statuses.edit', compact('task_status'));
    }

    /**
     * Update TaskStatus in storage.
     *
     * @param \App\Http\Requests\UpdateTaskStatusesRequest $request
     * @param int                                          $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskStatusesRequest $request, $id)
    {
        $task_status = TaskStatus::findOrFail($id);
        $task_status->update($request->all());

        return redirect()->route('admin.task_statuses.index');
    }

    /**
     * Display TaskStatus.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tasks = \App\Task::where('status_id', $id)->get();

        $task_status = TaskStatus::findOrFail($id);

        return view('admin.task_statuses.show', compact('task_status', 'tasks'));
    }

    /**
     * Remove TaskStatus from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task_status = TaskStatus::findOrFail($id);
        $task_status->delete();

        return redirect()->route('admin.task_statuses.index');
    }

    /**
     * Delete all selected TaskStatus at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = TaskStatus::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreTasksRequest;
use App\Http\Requests\Admin\UpdateTasksRequest;
use App\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Task.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating new Task.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = \App\TaskStatus::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $tags = \App\TaskTag::get()->pluck('name', 'id');

        $users = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        return view('admin.tasks.create', compact('statuses', 'tags', 'users'));
    }

    /**
     * Store a newly created Task in storage.
     *
     * @param \App\Http\Requests\StoreTasksRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTasksRequest $request)
    {
        $request = $this->saveFiles($request);
        $task = Task::create($request->all());
        $task->tag()->sync(array_filter((array) $request->input('tag')));

        return redirect()->route('admin.tasks.index');
    }

    /**
     * Show the form for editing Task.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $statuses = \App\TaskStatus::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $tags = \App\TaskTag::get()->pluck('name', 'id');

        $users = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        $task = Task::findOrFail($id);

        return view('admin.tasks.edit', compact('task', 'statuses', 'tags', 'users'));
    }

    /**
     * Update Task in storage.
     *
     * @param \App\Http\Requests\UpdateTasksRequest $request
     * @param int                                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTasksRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $task = Task::findOrFail($id);
        $task->update($request->all());
        $task->tag()->sync(array_filter((array) $request->input('tag')));

        return redirect()->route('admin.tasks.index');
    }

    /**
     * Display Task.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);

        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Remove Task from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('admin.tasks.index');
    }

    /**
     * Delete all selected Task at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Task::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}

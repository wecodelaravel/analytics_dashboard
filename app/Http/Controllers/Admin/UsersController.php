<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('user_access')) {
            return abort(401);
        }

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('user_create')) {
            return abort(401);
        }

        $roles = \App\Role::get()->pluck('title', 'id');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param \App\Http\Requests\StoreUsersRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        if (!Gate::allows('user_create')) {
            return abort(401);
        }
        $user = User::create($request->all());
        $user->role()->sync(array_filter((array) $request->input('role')));

        foreach ($request->input('contacts', []) as $data) {
            $user->contacts()->create($data);
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing User.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('user_edit')) {
            return abort(401);
        }

        $roles = \App\Role::get()->pluck('title', 'id');

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update User in storage.
     *
     * @param \App\Http\Requests\UpdateUsersRequest $request
     * @param int                                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        if (!Gate::allows('user_edit')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->update($request->all());
        $user->role()->sync(array_filter((array) $request->input('role')));

        $contacts = $user->contacts;
        $currentContactData = [];
        foreach ($request->input('contacts', []) as $index => $data) {
            if (is_int($index)) {
                $user->contacts()->create($data);
            } else {
                $id = explode('-', $index)[1];
                $currentContactData[$id] = $data;
            }
        }
        foreach ($contacts as $item) {
            if (isset($currentContactData[$item->id])) {
                $item->update($currentContactData[$item->id]);
            } else {
                $item->delete();
            }
        }

        return redirect()->route('admin.users.index');
    }

    /**
     * Display User.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('user_view')) {
            return abort(401);
        }

        $roles = \App\Role::get()->pluck('title', 'id');
        $contacts = \App\Contact::where('user_id', $id)->get();
        $clinics = \App\Clinic::whereHas('users',
                    function ($query) use ($id) {
                        $query->where('id', $id);
                    })->get();
        $tasks = \App\Task::where('user_id', $id)->get();
        $locations = \App\Location::where('created_by_id', $id)->get();

        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user', 'contacts', 'clinics', 'tasks', 'locations'));
    }

    /**
     * Remove User from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('user_delete')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('user_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}

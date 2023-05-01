<?php

namespace App\Http\Controllers\Admin;

use App\ApiTest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreApiTestsRequest;
use App\Http\Requests\Admin\UpdateApiTestsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class ApiTestsController extends Controller
{
    public function newcharts()
    {
        return view('newcharts');
    }

    /**
     * Display a listing of ApiTest.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('api_test_access')) {
            return abort(401);
        }

        if (request()->ajax()) {
            $query = ApiTest::query();
            $template = 'actionsTemplate';
            if (request('show_deleted') == 1) {
                if (!Gate::allows('api_test_delete')) {
                    return abort(401);
                }
                $query->onlyTrashed();
                $template = 'restoreTemplate';
            }
            $query->select([
                'api_tests.id',
                'api_tests.submitted',
                'api_tests.name',
                'api_tests.email',
                'api_tests.subject',
                'api_tests.message',
                'api_tests.submitted_user_city',
                'api_tests.submitted_user_state',
                'api_tests.searched_for',
                'api_tests.country',
                'api_tests.latitude',
                'api_tests.longitude',
            ]);
            $table = Datatables::of($query);

            $table->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
            $table->addColumn('massDelete', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) use ($template) {
                $gateKey = 'api_test_';
                $routeKey = 'admin.api_tests';

                return view($template, compact('row', 'gateKey', 'routeKey'));
            });
            $table->editColumn('submitted', function ($row) {
                return $row->submitted ? $row->submitted : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('subject', function ($row) {
                return $row->subject ? $row->subject : '';
            });
            $table->editColumn('message', function ($row) {
                return $row->message ? $row->message : '';
            });
            $table->editColumn('submitted_user_city', function ($row) {
                return $row->submitted_user_city ? $row->submitted_user_city : '';
            });
            $table->editColumn('submitted_user_state', function ($row) {
                return $row->submitted_user_state ? $row->submitted_user_state : '';
            });
            $table->editColumn('searched_for', function ($row) {
                return $row->searched_for ? $row->searched_for : '';
            });
            $table->editColumn('country', function ($row) {
                return $row->country ? $row->country : '';
            });
            $table->editColumn('latitude', function ($row) {
                return $row->latitude ? $row->latitude : '';
            });
            $table->editColumn('longitude', function ($row) {
                return $row->longitude ? $row->longitude : '';
            });

            $table->rawColumns(['actions', 'massDelete']);

            return $table->make(true);
        }

        return view('admin.api_tests.index');
    }

    /**
     * Show the form for creating new ApiTest.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('api_test_create')) {
            return abort(401);
        }

        return view('admin.api_tests.create');
    }

    /**
     * Store a newly created ApiTest in storage.
     *
     * @param \App\Http\Requests\StoreApiTestsRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApiTestsRequest $request)
    {
        if (!Gate::allows('api_test_create')) {
            return abort(401);
        }
        $api_test = ApiTest::create($request->all());

        return redirect()->route('admin.api_tests.index');
    }

    /**
     * Show the form for editing ApiTest.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('api_test_edit')) {
            return abort(401);
        }
        $api_test = ApiTest::findOrFail($id);

        return view('admin.api_tests.edit', compact('api_test'));
    }

    /**
     * Update ApiTest in storage.
     *
     * @param \App\Http\Requests\UpdateApiTestsRequest $request
     * @param int                                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApiTestsRequest $request, $id)
    {
        if (!Gate::allows('api_test_edit')) {
            return abort(401);
        }
        $api_test = ApiTest::findOrFail($id);
        $api_test->update($request->all());

        return redirect()->route('admin.api_tests.index');
    }

    /**
     * Display ApiTest.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('api_test_view')) {
            return abort(401);
        }
        $api_test = ApiTest::findOrFail($id);

        return view('admin.api_tests.show', compact('api_test'));
    }

    /**
     * Remove ApiTest from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('api_test_delete')) {
            return abort(401);
        }
        $api_test = ApiTest::findOrFail($id);
        $api_test->delete();

        return redirect()->route('admin.api_tests.index');
    }

    /**
     * Delete all selected ApiTest at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('api_test_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = ApiTest::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    /**
     * Restore ApiTest from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('api_test_delete')) {
            return abort(401);
        }
        $api_test = ApiTest::onlyTrashed()->findOrFail($id);
        $api_test->restore();

        return redirect()->route('admin.api_tests.index');
    }

    /**
     * Permanently delete ApiTest from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('api_test_delete')) {
            return abort(401);
        }
        $api_test = ApiTest::onlyTrashed()->findOrFail($id);
        $api_test->forceDelete();

        return redirect()->route('admin.api_tests.index');
    }
}

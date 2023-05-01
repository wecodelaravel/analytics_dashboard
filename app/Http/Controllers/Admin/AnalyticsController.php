<?php

namespace App\Http\Controllers\Admin;

use App\Analytic;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAnalyticsRequest;
use App\Http\Requests\Admin\UpdateAnalyticsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AnalyticsController extends Controller
{
    /**
     * Display a listing of Analytic.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('show_deleted') == 1) {
            if (!Gate::allows('analytic_delete')) {
                return abort(401);
            }
            $analytics = Analytic::onlyTrashed()->get();
        } else {
            $analytics = Analytic::all();
        }

        return view('admin.analytics.index', compact('analytics'));
    }

    /**
     * Show the form for creating new Analytic.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $websites = \App\Website::get()->pluck('website', 'id')->prepend(trans('global.app_please_select'), '');

        return view('admin.analytics.create', compact('websites'));
    }

    /**
     * Store a newly created Analytic in storage.
     *
     * @param \App\Http\Requests\StoreAnalyticsRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnalyticsRequest $request)
    {
        $analytic = Analytic::create($request->all());

        return redirect()->route('admin.analytics.index');
    }

    /**
     * Show the form for editing Analytic.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $websites = \App\Website::get()->pluck('website', 'id')->prepend(trans('global.app_please_select'), '');

        $analytic = Analytic::findOrFail($id);

        return view('admin.analytics.edit', compact('analytic', 'websites'));
    }

    /**
     * Update Analytic in storage.
     *
     * @param \App\Http\Requests\UpdateAnalyticsRequest $request
     * @param int                                       $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnalyticsRequest $request, $id)
    {
        $analytic = Analytic::findOrFail($id);
        $analytic->update($request->all());

        return redirect()->route('admin.analytics.index');
    }

    /**
     * Display Analytic.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $analytic = Analytic::findOrFail($id);

        return view('admin.analytics.show', compact('analytic'));
    }

    /**
     * Remove Analytic from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $analytic = Analytic::findOrFail($id);
        $analytic->delete();

        return redirect()->route('admin.analytics.index');
    }

    /**
     * Delete all selected Analytic at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Analytic::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    /**
     * Restore Analytic from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $analytic = Analytic::onlyTrashed()->findOrFail($id);
        $analytic->restore();

        return redirect()->route('admin.analytics.index');
    }

    /**
     * Permanently delete Analytic from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        $analytic = Analytic::onlyTrashed()->findOrFail($id);
        $analytic->forceDelete();

        return redirect()->route('admin.analytics.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreWebsitesRequest;
use App\Http\Requests\Admin\UpdateWebsitesRequest;
use App\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class WebsitesController extends Controller
{
    /**
     * Display a listing of Website.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('website_access')) {
            return abort(401);
        }

        if (request()->ajax()) {
            $query = Website::query();
            $query->with('company');
            $query->with('clinic');
            $template = 'actionsTemplate';
            if (request('show_deleted') == 1) {
                if (!Gate::allows('website_delete')) {
                    return abort(401);
                }
                $query->onlyTrashed();
                $template = 'restoreTemplate';
            }
            $query->select([
                'websites.id',
                'websites.company_id',
                'websites.clinic_id',
                'websites.website',
            ]);
            $table = Datatables::of($query);

            $table->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
            $table->addColumn('massDelete', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) use ($template) {
                $gateKey = 'website_';
                $routeKey = 'admin.websites';

                return view($template, compact('row', 'gateKey', 'routeKey'));
            });
            $table->editColumn('company.name', function ($row) {
                return $row->company ? $row->company->name : '';
            });
            $table->editColumn('clinic.nickname', function ($row) {
                return $row->clinic ? $row->clinic->nickname : '';
            });

            $table->rawColumns(['actions', 'massDelete']);

            return $table->make(true);
        }

        return view('admin.websites.index');
    }

    /**
     * Show the form for creating new Website.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('website_create')) {
            return abort(401);
        }

        $companies = \App\ContactCompany::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $clinics = \App\Clinic::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');

        return view('admin.websites.create', compact('companies', 'clinics'));
    }

    /**
     * Store a newly created Website in storage.
     *
     * @param \App\Http\Requests\StoreWebsitesRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWebsitesRequest $request)
    {
        if (!Gate::allows('website_create')) {
            return abort(401);
        }
        $website = Website::create($request->all());

        foreach ($request->input('locations', []) as $data) {
            $website->locations()->create($data);
        }
        foreach ($request->input('adwords', []) as $data) {
            $website->adwords()->create($data);
        }
        foreach ($request->input('analytics', []) as $data) {
            $website->analytics()->create($data);
        }

        return redirect()->route('admin.websites.index');
    }

    /**
     * Show the form for editing Website.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('website_edit')) {
            return abort(401);
        }

        $companies = \App\ContactCompany::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $clinics = \App\Clinic::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');

        $website = Website::findOrFail($id);

        return view('admin.websites.edit', compact('website', 'companies', 'clinics'));
    }

    /**
     * Update Website in storage.
     *
     * @param \App\Http\Requests\UpdateWebsitesRequest $request
     * @param int                                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWebsitesRequest $request, $id)
    {
        if (!Gate::allows('website_edit')) {
            return abort(401);
        }
        $website = Website::findOrFail($id);
        $website->update($request->all());

        $locations = $website->locations;
        $currentLocationData = [];
        foreach ($request->input('locations', []) as $index => $data) {
            if (is_int($index)) {
                $website->locations()->create($data);
            } else {
                $id = explode('-', $index)[1];
                $currentLocationData[$id] = $data;
            }
        }
        foreach ($locations as $item) {
            if (isset($currentLocationData[$item->id])) {
                $item->update($currentLocationData[$item->id]);
            } else {
                $item->delete();
            }
        }
        $adwords = $website->adwords;
        $currentAdwordData = [];
        foreach ($request->input('adwords', []) as $index => $data) {
            if (is_int($index)) {
                $website->adwords()->create($data);
            } else {
                $id = explode('-', $index)[1];
                $currentAdwordData[$id] = $data;
            }
        }
        foreach ($adwords as $item) {
            if (isset($currentAdwordData[$item->id])) {
                $item->update($currentAdwordData[$item->id]);
            } else {
                $item->delete();
            }
        }
        $analytics = $website->analytics;
        $currentAnalyticData = [];
        foreach ($request->input('analytics', []) as $index => $data) {
            if (is_int($index)) {
                $website->analytics()->create($data);
            } else {
                $id = explode('-', $index)[1];
                $currentAnalyticData[$id] = $data;
            }
        }
        foreach ($analytics as $item) {
            if (isset($currentAnalyticData[$item->id])) {
                $item->update($currentAnalyticData[$item->id]);
            } else {
                $item->delete();
            }
        }

        return redirect()->route('admin.websites.index');
    }

    /**
     * Display Website.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('website_view')) {
            return abort(401);
        }

        $companies = \App\ContactCompany::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $clinics = \App\Clinic::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');
        $locations = \App\Location::where('parent_website_id', $id)->get();
        $adwords = \App\Adword::where('website_id', $id)->get();
        $analytics = \App\Analytic::where('website_id', $id)->get();

        $website = Website::findOrFail($id);

        return view('admin.websites.show', compact('website', 'locations', 'adwords', 'analytics'));
    }

    /**
     * Remove Website from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('website_delete')) {
            return abort(401);
        }
        $website = Website::findOrFail($id);
        $website->delete();

        return redirect()->route('admin.websites.index');
    }

    /**
     * Delete all selected Website at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('website_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Website::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    /**
     * Restore Website from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('website_delete')) {
            return abort(401);
        }
        $website = Website::onlyTrashed()->findOrFail($id);
        $website->restore();

        return redirect()->route('admin.websites.index');
    }

    /**
     * Permanently delete Website from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('website_delete')) {
            return abort(401);
        }
        $website = Website::onlyTrashed()->findOrFail($id);
        $website->forceDelete();

        return redirect()->route('admin.websites.index');
    }
}

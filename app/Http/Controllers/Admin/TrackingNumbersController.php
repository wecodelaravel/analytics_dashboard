<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTrackingNumbersRequest;
use App\Http\Requests\Admin\UpdateTrackingNumbersRequest;
use App\TrackingNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class TrackingNumbersController extends Controller
{
    /**
     * Display a listing of TrackingNumber.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('tracking_number_access')) {
            return abort(401);
        }

        if (request()->ajax()) {
            $query = TrackingNumber::query();
            $query->with('location');
            $query->with('company');
            $template = 'actionsTemplate';
            if (request('show_deleted') == 1) {
                if (!Gate::allows('tracking_number_delete')) {
                    return abort(401);
                }
                $query->onlyTrashed();
                $template = 'restoreTemplate';
            }
            $query->select([
                'tracking_numbers.id',
                'tracking_numbers.metrics_id',
                'tracking_numbers.number',
                'tracking_numbers.location_id',
                'tracking_numbers.company_id',
                'tracking_numbers.callmetric_filter_id',
            ]);
            $table = Datatables::of($query);

            $table->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
            $table->addColumn('massDelete', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) use ($template) {
                $gateKey = 'tracking_number_';
                $routeKey = 'admin.tracking_numbers';

                return view($template, compact('row', 'gateKey', 'routeKey'));
            });
            $table->editColumn('metrics_id', function ($row) {
                return $row->metrics_id ? $row->metrics_id : '';
            });
            $table->editColumn('number', function ($row) {
                return $row->number ? $row->number : '';
            });
            $table->editColumn('location.nickname', function ($row) {
                return $row->location ? $row->location->nickname : '';
            });
            $table->editColumn('company.name', function ($row) {
                return $row->company ? $row->company->name : '';
            });
            $table->editColumn('callmetric_filter_id', function ($row) {
                return $row->callmetric_filter_id ? $row->callmetric_filter_id : '';
            });

            $table->rawColumns(['actions', 'massDelete']);

            return $table->make(true);
        }

        return view('admin.tracking_numbers.index');
    }

    /**
     * Show the form for creating new TrackingNumber.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('tracking_number_create')) {
            return abort(401);
        }

        $locations = \App\Location::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');
        $companies = \App\ContactCompany::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        return view('admin.tracking_numbers.create', compact('locations', 'companies'));
    }

    /**
     * Store a newly created TrackingNumber in storage.
     *
     * @param \App\Http\Requests\StoreTrackingNumbersRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrackingNumbersRequest $request)
    {
        if (!Gate::allows('tracking_number_create')) {
            return abort(401);
        }
        $tracking_number = TrackingNumber::create($request->all());

        return redirect()->route('admin.tracking_numbers.index');
    }

    /**
     * Show the form for editing TrackingNumber.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('tracking_number_edit')) {
            return abort(401);
        }

        $locations = \App\Location::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');
        $companies = \App\ContactCompany::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        $tracking_number = TrackingNumber::findOrFail($id);

        return view('admin.tracking_numbers.edit', compact('tracking_number', 'locations', 'companies'));
    }

    /**
     * Update TrackingNumber in storage.
     *
     * @param \App\Http\Requests\UpdateTrackingNumbersRequest $request
     * @param int                                             $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrackingNumbersRequest $request, $id)
    {
        if (!Gate::allows('tracking_number_edit')) {
            return abort(401);
        }
        $tracking_number = TrackingNumber::findOrFail($id);
        $tracking_number->update($request->all());

        return redirect()->route('admin.tracking_numbers.index');
    }

    /**
     * Display TrackingNumber.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('tracking_number_view')) {
            return abort(401);
        }
        $tracking_number = TrackingNumber::findOrFail($id);

        return view('admin.tracking_numbers.show', compact('tracking_number'));
    }

    /**
     * Remove TrackingNumber from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('tracking_number_delete')) {
            return abort(401);
        }
        $tracking_number = TrackingNumber::findOrFail($id);
        $tracking_number->delete();

        return redirect()->route('admin.tracking_numbers.index');
    }

    /**
     * Delete all selected TrackingNumber at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('tracking_number_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = TrackingNumber::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    /**
     * Restore TrackingNumber from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('tracking_number_delete')) {
            return abort(401);
        }
        $tracking_number = TrackingNumber::onlyTrashed()->findOrFail($id);
        $tracking_number->restore();

        return redirect()->route('admin.tracking_numbers.index');
    }

    /**
     * Permanently delete TrackingNumber from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('tracking_number_delete')) {
            return abort(401);
        }
        $tracking_number = TrackingNumber::onlyTrashed()->findOrFail($id);
        $tracking_number->forceDelete();

        return redirect()->route('admin.tracking_numbers.index');
    }
}

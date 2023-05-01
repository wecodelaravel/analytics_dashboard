<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreZipcodesRequest;
use App\Http\Requests\Admin\UpdateZipcodesRequest;
use App\Zipcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ZipcodesController extends Controller
{
    /**
     * Display a listing of Zipcode.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('show_deleted') == 1) {
            if (!Gate::allows('zipcode_delete')) {
                return abort(401);
            }
            $zipcodes = Zipcode::onlyTrashed()->get();
        } else {
            $zipcodes = Zipcode::all();
        }

        return view('admin.zipcodes.index', compact('zipcodes'));
    }

    /**
     * Show the form for creating new Zipcode.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clinics = \App\Clinic::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');
        $locations = \App\Location::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');

        return view('admin.zipcodes.create', compact('clinics', 'locations'));
    }

    /**
     * Store a newly created Zipcode in storage.
     *
     * @param \App\Http\Requests\StoreZipcodesRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreZipcodesRequest $request)
    {
        $zipcode = Zipcode::create($request->all());

        return redirect()->route('admin.zipcodes.index');
    }

    /**
     * Show the form for editing Zipcode.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clinics = \App\Clinic::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');
        $locations = \App\Location::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');

        $zipcode = Zipcode::findOrFail($id);

        return view('admin.zipcodes.edit', compact('zipcode', 'clinics', 'locations'));
    }

    /**
     * Update Zipcode in storage.
     *
     * @param \App\Http\Requests\UpdateZipcodesRequest $request
     * @param int                                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateZipcodesRequest $request, $id)
    {
        $zipcode = Zipcode::findOrFail($id);
        $zipcode->update($request->all());

        return redirect()->route('admin.zipcodes.index');
    }

    /**
     * Display Zipcode.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $zipcode = Zipcode::findOrFail($id);

        return view('admin.zipcodes.show', compact('zipcode'));
    }

    /**
     * Remove Zipcode from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $zipcode = Zipcode::findOrFail($id);
        $zipcode->delete();

        return redirect()->route('admin.zipcodes.index');
    }

    /**
     * Delete all selected Zipcode at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Zipcode::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    /**
     * Restore Zipcode from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $zipcode = Zipcode::onlyTrashed()->findOrFail($id);
        $zipcode->restore();

        return redirect()->route('admin.zipcodes.index');
    }

    /**
     * Permanently delete Zipcode from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        $zipcode = Zipcode::onlyTrashed()->findOrFail($id);
        $zipcode->forceDelete();

        return redirect()->route('admin.zipcodes.index');
    }
}

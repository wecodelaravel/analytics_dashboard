<?php

namespace App\Http\Controllers\Admin;

use App\Clinic;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreClinicsRequest;
use App\Http\Requests\Admin\UpdateClinicsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class ClinicsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Clinic.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('clinic_access')) {
            return abort(401);
        }

        if (request()->ajax()) {
            $query = Clinic::query();
            $query->with('company');
            $query->with('users');
            $template = 'actionsTemplate';
            if (request('show_deleted') == 1) {
                if (!Gate::allows('clinic_delete')) {
                    return abort(401);
                }
                $query->onlyTrashed();
                $template = 'restoreTemplate';
            }
            $query->select([
                'clinics.id',
                'clinics.nickname',
                'clinics.logo',
                'clinics.company_id',
                'clinics.notes',
            ]);
            $table = Datatables::of($query);

            $table->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
            $table->addColumn('massDelete', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) use ($template) {
                $gateKey = 'clinic_';
                $routeKey = 'admin.clinics';

                return view($template, compact('row', 'gateKey', 'routeKey'));
            });
            $table->editColumn('logo', function ($row) {
                if ($row->logo) {
                    return '<a href="'.asset(env('UPLOAD_PATH').'/'.$row->logo).'" target="_blank"><img src="'.asset(env('UPLOAD_PATH').'/thumb/'.$row->logo).'"/>';
                }
            });
            $table->editColumn('company.name', function ($row) {
                return $row->company ? $row->company->name : '';
            });
            $table->editColumn('users.name', function ($row) {
                if (count($row->users) == 0) {
                    return '';
                }

                return '<span class="label label-info label-many">'.implode('</span><span class="label label-info label-many"> ',
                        $row->users->pluck('name')->toArray()).'</span>';
            });
            $table->editColumn('notes', function ($row) {
                return $row->notes ? $row->notes : '';
            });

            $table->rawColumns(['actions', 'massDelete', 'logo', 'users.name']);

            return $table->make(true);
        }

        return view('admin.clinics.index');
    }

    /**
     * Show the form for creating new Clinic.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('clinic_create')) {
            return abort(401);
        }

        $companies = \App\ContactCompany::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $users = \App\User::get()->pluck('name', 'id');

        return view('admin.clinics.create', compact('companies', 'users'));
    }

    /**
     * Store a newly created Clinic in storage.
     *
     * @param \App\Http\Requests\StoreClinicsRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClinicsRequest $request)
    {
        if (!Gate::allows('clinic_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $clinic = Clinic::create($request->all());
        $clinic->users()->sync(array_filter((array) $request->input('users')));

        foreach ($request->input('contacts', []) as $data) {
            $clinic->contacts()->create($data);
        }
        foreach ($request->input('websites', []) as $data) {
            $clinic->websites()->create($data);
        }
        foreach ($request->input('zipcodes', []) as $data) {
            $clinic->zipcodes()->create($data);
        }
        foreach ($request->input('locations', []) as $data) {
            $clinic->locations()->create($data);
        }

        return redirect()->route('admin.clinics.index');
    }

    /**
     * Show the form for editing Clinic.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('clinic_edit')) {
            return abort(401);
        }

        $companies = \App\ContactCompany::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $users = \App\User::get()->pluck('name', 'id');

        $clinic = Clinic::findOrFail($id);

        return view('admin.clinics.edit', compact('clinic', 'companies', 'users'));
    }

    /**
     * Update Clinic in storage.
     *
     * @param \App\Http\Requests\UpdateClinicsRequest $request
     * @param int                                     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClinicsRequest $request, $id)
    {
        if (!Gate::allows('clinic_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $clinic = Clinic::findOrFail($id);
        $clinic->update($request->all());
        $clinic->users()->sync(array_filter((array) $request->input('users')));

        $contacts = $clinic->contacts;
        $currentContactData = [];
        foreach ($request->input('contacts', []) as $index => $data) {
            if (is_int($index)) {
                $clinic->contacts()->create($data);
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
        $websites = $clinic->websites;
        $currentWebsiteData = [];
        foreach ($request->input('websites', []) as $index => $data) {
            if (is_int($index)) {
                $clinic->websites()->create($data);
            } else {
                $id = explode('-', $index)[1];
                $currentWebsiteData[$id] = $data;
            }
        }
        foreach ($websites as $item) {
            if (isset($currentWebsiteData[$item->id])) {
                $item->update($currentWebsiteData[$item->id]);
            } else {
                $item->delete();
            }
        }
        $zipcodes = $clinic->zipcodes;
        $currentZipcodeData = [];
        foreach ($request->input('zipcodes', []) as $index => $data) {
            if (is_int($index)) {
                $clinic->zipcodes()->create($data);
            } else {
                $id = explode('-', $index)[1];
                $currentZipcodeData[$id] = $data;
            }
        }
        foreach ($zipcodes as $item) {
            if (isset($currentZipcodeData[$item->id])) {
                $item->update($currentZipcodeData[$item->id]);
            } else {
                $item->delete();
            }
        }
        $locations = $clinic->locations;
        $currentLocationData = [];
        foreach ($request->input('locations', []) as $index => $data) {
            if (is_int($index)) {
                $clinic->locations()->create($data);
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

        return redirect()->route('admin.clinics.index');
    }

    /**
     * Display Clinic.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('clinic_view')) {
            return abort(401);
        }

        $companies = \App\ContactCompany::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $users = \App\User::get()->pluck('name', 'id');
        $contacts = \App\Contact::where('clinic_id', $id)->get();
        $websites = \App\Website::where('clinic_id', $id)->get();
        $zipcodes = \App\Zipcode::where('clinic_id', $id)->get();
        $locations = \App\Location::where('clinic_id', $id)->get();
        $adwords = \App\Adword::where('clinic_id', $id)->get();

        $clinic = Clinic::findOrFail($id);

        return view('admin.clinics.show', compact('clinic', 'contacts', 'websites', 'zipcodes', 'locations', 'adwords'));
    }

    /**
     * Remove Clinic from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('clinic_delete')) {
            return abort(401);
        }
        $clinic = Clinic::findOrFail($id);
        $clinic->delete();

        return redirect()->route('admin.clinics.index');
    }

    /**
     * Delete all selected Clinic at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('clinic_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Clinic::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    /**
     * Restore Clinic from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('clinic_delete')) {
            return abort(401);
        }
        $clinic = Clinic::onlyTrashed()->findOrFail($id);
        $clinic->restore();

        return redirect()->route('admin.clinics.index');
    }

    /**
     * Permanently delete Clinic from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('clinic_delete')) {
            return abort(401);
        }
        $clinic = Clinic::onlyTrashed()->findOrFail($id);
        $clinic->forceDelete();

        return redirect()->route('admin.clinics.index');
    }
}

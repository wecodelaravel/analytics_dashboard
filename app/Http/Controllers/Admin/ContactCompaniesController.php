<?php

namespace App\Http\Controllers\Admin;

use App\ContactCompany;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreContactCompaniesRequest;
use App\Http\Requests\Admin\UpdateContactCompaniesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class ContactCompaniesController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of ContactCompany.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('contact_company_access')) {
            return abort(401);
        }

        if (request()->ajax()) {
            $query = ContactCompany::query();
            $template = 'actionsTemplate';

            $query->select([
                'contact_companies.id',
                'contact_companies.name',
                'contact_companies.logo',
            ]);
            $table = Datatables::of($query);

            $table->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
            $table->addColumn('massDelete', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) use ($template) {
                $gateKey = 'contact_company_';
                $routeKey = 'admin.contact_companies';

                return view($template, compact('row', 'gateKey', 'routeKey'));
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('logo', function ($row) {
                if ($row->logo) {
                    return '<a href="'.asset(env('UPLOAD_PATH').'/'.$row->logo).'" target="_blank"><img src="'.asset(env('UPLOAD_PATH').'/thumb/'.$row->logo).'"/>';
                }
            });

            $table->rawColumns(['actions', 'massDelete', 'logo']);

            return $table->make(true);
        }

        return view('admin.contact_companies.index');
    }

    /**
     * Show the form for creating new ContactCompany.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('contact_company_create')) {
            return abort(401);
        }

        return view('admin.contact_companies.create');
    }

    /**
     * Store a newly created ContactCompany in storage.
     *
     * @param \App\Http\Requests\StoreContactCompaniesRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactCompaniesRequest $request)
    {
        if (!Gate::allows('contact_company_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $contact_company = ContactCompany::create($request->all());

        foreach ($request->input('websites', []) as $data) {
            $contact_company->websites()->create($data);
        }
        foreach ($request->input('clinics', []) as $data) {
            $contact_company->clinics()->create($data);
        }

        return redirect()->route('admin.contact_companies.index');
    }

    /**
     * Show the form for editing ContactCompany.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('contact_company_edit')) {
            return abort(401);
        }
        $contact_company = ContactCompany::findOrFail($id);

        return view('admin.contact_companies.edit', compact('contact_company'));
    }

    /**
     * Update ContactCompany in storage.
     *
     * @param \App\Http\Requests\UpdateContactCompaniesRequest $request
     * @param int                                              $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactCompaniesRequest $request, $id)
    {
        if (!Gate::allows('contact_company_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $contact_company = ContactCompany::findOrFail($id);
        $contact_company->update($request->all());

        $websites = $contact_company->websites;
        $currentWebsiteData = [];
        foreach ($request->input('websites', []) as $index => $data) {
            if (is_int($index)) {
                $contact_company->websites()->create($data);
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
        $clinics = $contact_company->clinics;
        $currentClinicData = [];
        foreach ($request->input('clinics', []) as $index => $data) {
            if (is_int($index)) {
                $contact_company->clinics()->create($data);
            } else {
                $id = explode('-', $index)[1];
                $currentClinicData[$id] = $data;
            }
        }
        foreach ($clinics as $item) {
            if (isset($currentClinicData[$item->id])) {
                $item->update($currentClinicData[$item->id]);
            } else {
                $item->delete();
            }
        }

        return redirect()->route('admin.contact_companies.index');
    }

    /**
     * Display ContactCompany.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('contact_company_view')) {
            return abort(401);
        }
        $contacts = \App\Contact::where('company_id', $id)->get();
        $websites = \App\Website::where('company_id', $id)->get();
        $adwords = \App\Adword::where('company_id', $id)->get();
        $clinics = \App\Clinic::where('company_id', $id)->get();
        $tracking_numbers = \App\TrackingNumber::where('company_id', $id)->get();

        $contact_company = ContactCompany::findOrFail($id);

        return view('admin.contact_companies.show', compact('contact_company', 'contacts', 'websites', 'adwords', 'clinics', 'tracking_numbers'));
    }

    /**
     * Remove ContactCompany from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('contact_company_delete')) {
            return abort(401);
        }
        $contact_company = ContactCompany::findOrFail($id);
        $contact_company->delete();

        return redirect()->route('admin.contact_companies.index');
    }

    /**
     * Delete all selected ContactCompany at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('contact_company_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = ContactCompany::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}

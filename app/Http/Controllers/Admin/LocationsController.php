<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreLocationsRequest;
use App\Http\Requests\Admin\UpdateLocationsRequest;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class LocationsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Location.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('location_access')) {
            return abort(401);
        }
        if ($filterBy = Input::get('filter')) {
            if ($filterBy == 'all') {
                Session::put('Location.filter', 'all');
            } elseif ($filterBy == 'my') {
                Session::put('Location.filter', 'my');
            }
        }

        if (request()->ajax()) {
            $query = Location::query();
            $query->with('parent_website');
            $query->with('clinic');
            $query->with('contact_person');
            $query->with('created_by');
            $template = 'actionsTemplate';
            if (request('show_deleted') == 1) {
                if (!Gate::allows('location_delete')) {
                    return abort(401);
                }
                $query->onlyTrashed();
                $template = 'restoreTemplate';
            }
            $query->select([
                'locations.id',
                'locations.parent_website_id',
                'locations.clinic_website_link',
                'locations.clinic_id',
                'locations.clinic_location_id',
                'locations.nickname',
                'locations.contact_person_id',
                'locations.address',
                'locations.address_2',
                'locations.city',
                'locations.state',
                'locations.location_email',
                'locations.phone',
                'locations.phone2',
                'locations.storefront',
                'locations.google_map_link',
                'locations.created_by_id',
            ]);
            $table = Datatables::of($query);

            $table->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
            $table->addColumn('massDelete', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) use ($template) {
                $gateKey = 'location_';
                $routeKey = 'admin.locations';

                return view($template, compact('row', 'gateKey', 'routeKey'));
            });
            $table->editColumn('parent_website.website', function ($row) {
                return $row->parent_website ? $row->parent_website->website : '';
            });
            $table->editColumn('clinic_website_link', function ($row) {
                return $row->clinic_website_link ? $row->clinic_website_link : '';
            });
            $table->editColumn('clinic.nickname', function ($row) {
                return $row->clinic ? $row->clinic->nickname : '';
            });
            $table->editColumn('clinic_location_id', function ($row) {
                return $row->clinic_location_id ? $row->clinic_location_id : '';
            });
            $table->editColumn('contact_person.first_name', function ($row) {
                return $row->contact_person ? $row->contact_person->first_name : '';
            });
            $table->editColumn('address_2', function ($row) {
                return $row->address_2 ? $row->address_2 : '';
            });
            $table->editColumn('location_email', function ($row) {
                return $row->location_email ? $row->location_email : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->editColumn('phone2', function ($row) {
                return $row->phone2 ? $row->phone2 : '';
            });
            $table->editColumn('storefront', function ($row) {
                if ($row->storefront) {
                    return '<a href="'.asset(env('UPLOAD_PATH').'/'.$row->storefront).'" target="_blank"><img src="'.asset(env('UPLOAD_PATH').'/thumb/'.$row->storefront).'"/>';
                }
            });
            $table->editColumn('google_map_link', function ($row) {
                return $row->google_map_link ? $row->google_map_link : '';
            });
            $table->editColumn('created_by.name', function ($row) {
                return $row->created_by ? $row->created_by->name : '';
            });

            $table->rawColumns(['actions', 'massDelete', 'storefront']);

            return $table->make(true);
        }

        return view('admin.locations.index');
    }

    /**
     * Show the form for creating new Location.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('location_create')) {
            return abort(401);
        }

        $parent_websites = \App\Website::get()->pluck('website', 'id')->prepend(trans('global.app_please_select'), '');
        $clinics = \App\Clinic::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');
        $contact_people = \App\Contact::get()->pluck('first_name', 'id')->prepend(trans('global.app_please_select'), '');
        $created_bies = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        return view('admin.locations.create', compact('parent_websites', 'clinics', 'contact_people', 'created_bies'));
    }

    /**
     * Store a newly created Location in storage.
     *
     * @param \App\Http\Requests\StoreLocationsRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocationsRequest $request)
    {
        if (!Gate::allows('location_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $location = Location::create($request->all());

        foreach ($request->input('zipcodes', []) as $data) {
            $location->zipcodes()->create($data);
        }

        return redirect()->route('admin.locations.index');
    }

    /**
     * Show the form for editing Location.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('location_edit')) {
            return abort(401);
        }

        $parent_websites = \App\Website::get()->pluck('website', 'id')->prepend(trans('global.app_please_select'), '');
        $clinics = \App\Clinic::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');
        $contact_people = \App\Contact::get()->pluck('first_name', 'id')->prepend(trans('global.app_please_select'), '');
        $created_bies = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        $location = Location::findOrFail($id);

        return view('admin.locations.edit', compact('location', 'parent_websites', 'clinics', 'contact_people', 'created_bies'));
    }

    /**
     * Update Location in storage.
     *
     * @param \App\Http\Requests\UpdateLocationsRequest $request
     * @param int                                       $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLocationsRequest $request, $id)
    {
        if (!Gate::allows('location_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request);
        $location = Location::findOrFail($id);
        $location->update($request->all());

        $zipcodes = $location->zipcodes;
        $currentZipcodeData = [];
        foreach ($request->input('zipcodes', []) as $index => $data) {
            if (is_int($index)) {
                $location->zipcodes()->create($data);
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

        return redirect()->route('admin.locations.index');
    }

    /**
     * Display Location.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('location_view')) {
            return abort(401);
        }

        $parent_websites = \App\Website::get()->pluck('website', 'id')->prepend(trans('global.app_please_select'), '');
        $clinics = \App\Clinic::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');
        $contact_people = \App\Contact::get()->pluck('first_name', 'id')->prepend(trans('global.app_please_select'), '');
        $created_bies = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $zipcodes = \App\Zipcode::where('location_id', $id)->get();
        $tracking_numbers = \App\TrackingNumber::where('location_id', $id)->get();

        $location = Location::findOrFail($id);

        return view('admin.locations.show', compact('location', 'zipcodes', 'tracking_numbers'));
    }

    /**
     * Remove Location from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('location_delete')) {
            return abort(401);
        }
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('admin.locations.index');
    }

    /**
     * Delete all selected Location at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('location_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Location::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    /**
     * Restore Location from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('location_delete')) {
            return abort(401);
        }
        $location = Location::onlyTrashed()->findOrFail($id);
        $location->restore();

        return redirect()->route('admin.locations.index');
    }

    /**
     * Permanently delete Location from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('location_delete')) {
            return abort(401);
        }
        $location = Location::onlyTrashed()->findOrFail($id);
        $location->forceDelete();

        return redirect()->route('admin.locations.index');
    }
}

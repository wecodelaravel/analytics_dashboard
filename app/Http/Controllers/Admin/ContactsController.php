<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreContactsRequest;
use App\Http\Requests\Admin\UpdateContactsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class ContactsController extends Controller
{
    /**
     * Display a listing of Contact.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('contact_access')) {
            return abort(401);
        }

        if (request()->ajax()) {
            $query = Contact::query();
            $query->with('company');
            $query->with('clinic');
            $query->with('user');
            $template = 'actionsTemplate';

            $query->select([
                'contacts.id',
                'contacts.company_id',
                'contacts.clinic_id',
                'contacts.user_id',
                'contacts.first_name',
                'contacts.last_name',
                'contacts.phone1',
                'contacts.phone2',
                'contacts.email',
                'contacts.skype',
                'contacts.notes',
            ]);
            $table = Datatables::of($query);

            $table->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
            $table->addColumn('massDelete', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) use ($template) {
                $gateKey = 'contact_';
                $routeKey = 'admin.contacts';

                return view($template, compact('row', 'gateKey', 'routeKey'));
            });
            $table->editColumn('company.name', function ($row) {
                return $row->company ? $row->company->name : '';
            });
            $table->editColumn('clinic.nickname', function ($row) {
                return $row->clinic ? $row->clinic->nickname : '';
            });
            $table->editColumn('user.name', function ($row) {
                return $row->user ? $row->user->name : '';
            });
            $table->editColumn('first_name', function ($row) {
                return $row->first_name ? $row->first_name : '';
            });
            $table->editColumn('last_name', function ($row) {
                return $row->last_name ? $row->last_name : '';
            });
            $table->editColumn('phone1', function ($row) {
                return $row->phone1 ? $row->phone1 : '';
            });
            $table->editColumn('phone2', function ($row) {
                return $row->phone2 ? $row->phone2 : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('skype', function ($row) {
                return $row->skype ? $row->skype : '';
            });
            $table->editColumn('notes', function ($row) {
                return $row->notes ? $row->notes : '';
            });

            $table->rawColumns(['actions', 'massDelete']);

            return $table->make(true);
        }

        return view('admin.contacts.index');
    }

    /**
     * Show the form for creating new Contact.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('contact_create')) {
            return abort(401);
        }

        $companies = \App\ContactCompany::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $clinics = \App\Clinic::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');
        $users = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        return view('admin.contacts.create', compact('companies', 'clinics', 'users'));
    }

    /**
     * Store a newly created Contact in storage.
     *
     * @param \App\Http\Requests\StoreContactsRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactsRequest $request)
    {
        if (!Gate::allows('contact_create')) {
            return abort(401);
        }
        $contact = Contact::create($request->all());

        return redirect()->route('admin.contacts.index');
    }

    /**
     * Show the form for editing Contact.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('contact_edit')) {
            return abort(401);
        }

        $companies = \App\ContactCompany::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $clinics = \App\Clinic::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');
        $users = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        $contact = Contact::findOrFail($id);

        return view('admin.contacts.edit', compact('contact', 'companies', 'clinics', 'users'));
    }

    /**
     * Update Contact in storage.
     *
     * @param \App\Http\Requests\UpdateContactsRequest $request
     * @param int                                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactsRequest $request, $id)
    {
        if (!Gate::allows('contact_edit')) {
            return abort(401);
        }
        $contact = Contact::findOrFail($id);
        $contact->update($request->all());

        return redirect()->route('admin.contacts.index');
    }

    /**
     * Display Contact.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Gate::allows('contact_view')) {
            return abort(401);
        }

        $companies = \App\ContactCompany::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $clinics = \App\Clinic::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');
        $users = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $locations = \App\Location::where('contact_person_id', $id)->get();

        $contact = Contact::findOrFail($id);

        return view('admin.contacts.show', compact('contact', 'locations'));
    }

    /**
     * Remove Contact from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('contact_delete')) {
            return abort(401);
        }
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index');
    }

    /**
     * Delete all selected Contact at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('contact_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Contact::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}

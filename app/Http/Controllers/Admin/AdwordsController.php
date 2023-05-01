<?php

namespace App\Http\Controllers\Admin;

use App\Adword;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdwordsRequest;
use App\Http\Requests\Admin\UpdateAdwordsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdwordsController extends Controller
{
    /**
     * Display a listing of Adword.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('show_deleted') == 1) {
            if (!Gate::allows('adword_delete')) {
                return abort(401);
            }
            $adwords = Adword::onlyTrashed()->get();
        } else {
            $adwords = Adword::all();
        }

        return view('admin.adwords.index', compact('adwords'));
    }

    /**
     * Show the form for creating new Adword.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = \App\ContactCompany::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $websites = \App\Website::get()->pluck('website', 'id')->prepend(trans('global.app_please_select'), '');
        $clinics = \App\Clinic::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');

        return view('admin.adwords.create', compact('companies', 'websites', 'clinics'));
    }

    /**
     * Store a newly created Adword in storage.
     *
     * @param \App\Http\Requests\StoreAdwordsRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdwordsRequest $request)
    {
        $adword = Adword::create($request->all());

        return redirect()->route('admin.adwords.index');
    }

    /**
     * Show the form for editing Adword.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companies = \App\ContactCompany::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $websites = \App\Website::get()->pluck('website', 'id')->prepend(trans('global.app_please_select'), '');
        $clinics = \App\Clinic::get()->pluck('nickname', 'id')->prepend(trans('global.app_please_select'), '');

        $adword = Adword::findOrFail($id);

        return view('admin.adwords.edit', compact('adword', 'companies', 'websites', 'clinics'));
    }

    /**
     * Update Adword in storage.
     *
     * @param \App\Http\Requests\UpdateAdwordsRequest $request
     * @param int                                     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdwordsRequest $request, $id)
    {
        $adword = Adword::findOrFail($id);
        $adword->update($request->all());

        return redirect()->route('admin.adwords.index');
    }

    /**
     * Display Adword.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $adword = Adword::findOrFail($id);

        return view('admin.adwords.show', compact('adword'));
    }

    /**
     * Remove Adword from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adword = Adword::findOrFail($id);
        $adword->delete();

        return redirect()->route('admin.adwords.index');
    }

    /**
     * Delete all selected Adword at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Adword::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    /**
     * Restore Adword from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $adword = Adword::onlyTrashed()->findOrFail($id);
        $adword->restore();

        return redirect()->route('admin.adwords.index');
    }

    /**
     * Permanently delete Adword from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        $adword = Adword::onlyTrashed()->findOrFail($id);
        $adword->forceDelete();

        return redirect()->route('admin.adwords.index');
    }
}

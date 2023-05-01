<?php

namespace App\Http\Controllers\Api\V1;

use App\ContactCompany;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreContactCompaniesRequest;
use App\Http\Requests\Admin\UpdateContactCompaniesRequest;

class ContactCompaniesController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return ContactCompany::all();
    }

    public function show($id)
    {
        return ContactCompany::findOrFail($id);
    }

    public function update(UpdateContactCompaniesRequest $request, $id)
    {
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

        return $contact_company;
    }

    public function store(StoreContactCompaniesRequest $request)
    {
        $request = $this->saveFiles($request);
        $contact_company = ContactCompany::create($request->all());

        foreach ($request->input('websites', []) as $data) {
            $contact_company->websites()->create($data);
        }
        foreach ($request->input('clinics', []) as $data) {
            $contact_company->clinics()->create($data);
        }

        return $contact_company;
    }

    public function destroy($id)
    {
        $contact_company = ContactCompany::findOrFail($id);
        $contact_company->delete();

        return '';
    }
}

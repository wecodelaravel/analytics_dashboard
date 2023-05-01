<?php

namespace App\Http\Controllers\Api\V1;

use App\Clinic;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreClinicsRequest;
use App\Http\Requests\Admin\UpdateClinicsRequest;

class ClinicsController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Clinic::all();
    }

    public function show($id)
    {
        return Clinic::findOrFail($id);
    }

    public function update(UpdateClinicsRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $clinic = Clinic::findOrFail($id);
        $clinic->update($request->all());

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

        return $clinic;
    }

    public function store(StoreClinicsRequest $request)
    {
        $request = $this->saveFiles($request);
        $clinic = Clinic::create($request->all());

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

        return $clinic;
    }

    public function destroy($id)
    {
        $clinic = Clinic::findOrFail($id);
        $clinic->delete();

        return '';
    }
}

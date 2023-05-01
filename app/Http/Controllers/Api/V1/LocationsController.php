<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\Admin\StoreLocationsRequest;
use App\Http\Requests\Admin\UpdateLocationsRequest;
use App\Location;

class LocationsController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Location::all();
    }

    public function show($id)
    {
        return Location::findOrFail($id);
    }

    public function update(UpdateLocationsRequest $request, $id)
    {
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

        return $location;
    }

    public function store(StoreLocationsRequest $request)
    {
        $request = $this->saveFiles($request);
        $location = Location::create($request->all());

        foreach ($request->input('zipcodes', []) as $data) {
            $location->zipcodes()->create($data);
        }

        return $location;
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return '';
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreZipcodesRequest;
use App\Http\Requests\Admin\UpdateZipcodesRequest;
use App\Zipcode;

class ZipcodesController extends Controller
{
    public function index()
    {
        return Zipcode::all();
    }

    public function show($id)
    {
        return Zipcode::findOrFail($id);
    }

    public function update(UpdateZipcodesRequest $request, $id)
    {
        $zipcode = Zipcode::findOrFail($id);
        $zipcode->update($request->all());

        return $zipcode;
    }

    public function store(StoreZipcodesRequest $request)
    {
        $zipcode = Zipcode::create($request->all());

        return $zipcode;
    }

    public function destroy($id)
    {
        $zipcode = Zipcode::findOrFail($id);
        $zipcode->delete();

        return '';
    }
}

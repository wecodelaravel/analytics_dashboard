<?php

namespace App\Http\Controllers\Api\V1;

use App\Analytic;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAnalyticsRequest;
use App\Http\Requests\Admin\UpdateAnalyticsRequest;

class AnalyticsController extends Controller
{
    public function index()
    {
        return Analytic::all();
    }

    public function show($id)
    {
        return Analytic::findOrFail($id);
    }

    public function update(UpdateAnalyticsRequest $request, $id)
    {
        $analytic = Analytic::findOrFail($id);
        $analytic->update($request->all());

        return $analytic;
    }

    public function store(StoreAnalyticsRequest $request)
    {
        $analytic = Analytic::create($request->all());

        return $analytic;
    }

    public function destroy($id)
    {
        $analytic = Analytic::findOrFail($id);
        $analytic->delete();

        return '';
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\ApiTest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreApiTestsRequest;
use App\Http\Requests\Admin\UpdateApiTestsRequest;

class ApiTestsController extends Controller
{
    public function index()
    {
        return ApiTest::all();
    }

    public function show($id)
    {
        return ApiTest::findOrFail($id);
    }

    public function update(UpdateApiTestsRequest $request, $id)
    {
        $api_test = ApiTest::findOrFail($id);
        $api_test->update($request->all());

        return $api_test;
    }

    public function store(StoreApiTestsRequest $request)
    {
        $api_test = ApiTest::create($request->all());

        return $api_test;
    }

    public function destroy($id)
    {
        $api_test = ApiTest::findOrFail($id);
        $api_test->delete();

        return '';
    }
}

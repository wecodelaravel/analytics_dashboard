<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
    Route::resource('contact_companies', 'ContactCompaniesController', ['except' => ['create', 'edit']]);

    Route::resource('clinics', 'ClinicsController', ['except' => ['create', 'edit']]);

    Route::resource('contacts', 'ContactsController', ['except' => ['create', 'edit']]);

    Route::resource('locations', 'LocationsController', ['except' => ['create', 'edit']]);

    Route::resource('bookings', 'BookingsController', ['except' => ['create', 'edit']]);

    Route::resource('websites', 'WebsitesController', ['except' => ['create', 'edit']]);

    Route::resource('analytics', 'AnalyticsController', ['except' => ['create', 'edit']]);

    Route::resource('zipcodes', 'ZipcodesController', ['except' => ['create', 'edit']]);

    Route::resource('api_tests', 'ApiTestsController', ['except' => ['create', 'edit']]);

    Route::resource('tracking_numbers', 'TrackingNumbersController', ['except' => ['create', 'edit']]);
});

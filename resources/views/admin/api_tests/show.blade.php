@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.api-test.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.api-test.fields.submitted')</th>
                            <td field-key='submitted'>{{ $api_test->submitted }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.api-test.fields.name')</th>
                            <td field-key='name'>{{ $api_test->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.api-test.fields.email')</th>
                            <td field-key='email'>{{ $api_test->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.api-test.fields.subject')</th>
                            <td field-key='subject'>{{ $api_test->subject }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.api-test.fields.message')</th>
                            <td field-key='message'>{{ $api_test->message }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.api-test.fields.submitted-user-city')</th>
                            <td field-key='submitted_user_city'>{{ $api_test->submitted_user_city }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.api-test.fields.submitted-user-state')</th>
                            <td field-key='submitted_user_state'>{{ $api_test->submitted_user_state }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.api-test.fields.searched-for')</th>
                            <td field-key='searched_for'>{{ $api_test->searched_for }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.api-test.fields.country')</th>
                            <td field-key='country'>{{ $api_test->country }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.api-test.fields.latitude')</th>
                            <td field-key='latitude'>{{ $api_test->latitude }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.api-test.fields.longitude')</th>
                            <td field-key='longitude'>{{ $api_test->longitude }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.api_tests.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop

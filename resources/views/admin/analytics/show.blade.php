@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.analytics.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.analytics.fields.view-name')</th>
                            <td field-key='view_name'>{{ $analytic->view_name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.analytics.fields.view-id')</th>
                            <td field-key='view_id'>{{ $analytic->view_id }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.analytics.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop

@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.tracking-numbers.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.tracking-numbers.fields.metrics-id')</th>
                            <td field-key='metrics_id'>{{ $tracking_number->metrics_id }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.tracking-numbers.fields.number')</th>
                            <td field-key='number'>{{ $tracking_number->number }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.tracking-numbers.fields.location')</th>
                            <td field-key='location'>{{ $tracking_number->location->nickname or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.tracking-numbers.fields.company')</th>
                            <td field-key='company'>{{ $tracking_number->company->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.tracking-numbers.fields.callmetric-filter-id')</th>
                            <td field-key='callmetric_filter_id'>{{ $tracking_number->callmetric_filter_id }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.tracking_numbers.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop

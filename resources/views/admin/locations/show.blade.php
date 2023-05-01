@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.locations.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.locations.fields.clinic-website-link')</th>
                            <td field-key='clinic_website_link'>{{ $location->clinic_website_link }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.locations.fields.clinic-location-id')</th>
                            <td field-key='clinic_location_id'>{{ $location->clinic_location_id }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.locations.fields.nickname')</th>
                            <td field-key='nickname'>{{ $location->nickname }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.locations.fields.contact-person')</th>
                            <td field-key='contact_person'>{{ $location->contact_person->first_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.last-name')</th>
                            <td field-key='last_name'>{{ isset($location->contact_person) ? $location->contact_person->last_name : '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.locations.fields.address')</th>
                            <td field-key='address'>{{ $location->address }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.locations.fields.address-2')</th>
                            <td field-key='address_2'>{{ $location->address_2 }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.locations.fields.city')</th>
                            <td field-key='city'>{{ $location->city }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.locations.fields.state')</th>
                            <td field-key='state'>{{ $location->state }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.locations.fields.location-email')</th>
                            <td field-key='location_email'>{{ $location->location_email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.locations.fields.phone')</th>
                            <td field-key='phone'>{{ $location->phone }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.locations.fields.phone2')</th>
                            <td field-key='phone2'>{{ $location->phone2 }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.locations.fields.storefront')</th>
                            <td field-key='storefront'>@if($location->storefront)<a href="{{ asset(env('UPLOAD_PATH').'/' . $location->storefront) }}" target="_blank"><img src="{{ asset(env('UPLOAD_PATH').'/thumb/' . $location->storefront) }}"/></a>@endif</td>
                        </tr>
                        <tr>
                            <th>@lang('global.locations.fields.google-map-link')</th>
                            <td field-key='google_map_link'>{{ $location->google_map_link }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.locations.fields.created-by')</th>
                            <td field-key='created_by'>{{ $location->created_by->name or '' }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#zipcodes" aria-controls="zipcodes" role="tab" data-toggle="tab">Zipcodes</a></li>
<li role="presentation" class=""><a href="#tracking_numbers" aria-controls="tracking_numbers" role="tab" data-toggle="tab">Tracking numbers</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="zipcodes">
<table class="table table-bordered table-striped {{ count($zipcodes) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.zipcodes.fields.zipcode')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($zipcodes) > 0)
            @foreach ($zipcodes as $zipcode)
                <tr data-entry-id="{{ $zipcode->id }}">
                    <td field-key='zipcode'>{{ $zipcode->zipcode }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.zipcodes.restore', $zipcode->id])) !!}
                                    {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.zipcodes.perma_del', $zipcode->id])) !!}
                                    {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                                                </td>
                                @else
                                <td>
                                    @can('zipcode_view')
                                    <a href="{{ route('admin.zipcodes.show',[$zipcode->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('zipcode_edit')
                                    <a href="{{ route('admin.zipcodes.edit',[$zipcode->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                    @can('zipcode_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.zipcodes.destroy', $zipcode->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8">@lang('global.app_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
<div role="tabpanel" class="tab-pane " id="tracking_numbers">
<table class="table table-bordered table-striped {{ count($tracking_numbers) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.tracking-numbers.fields.metrics-id')</th>
                        <th>@lang('global.tracking-numbers.fields.number')</th>
                        <th>@lang('global.tracking-numbers.fields.location')</th>
                        <th>@lang('global.tracking-numbers.fields.company')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($tracking_numbers) > 0)
            @foreach ($tracking_numbers as $tracking_number)
                <tr data-entry-id="{{ $tracking_number->id }}">
                    <td field-key='metrics_id'>{{ $tracking_number->metrics_id }}</td>
                                <td field-key='number'>{{ $tracking_number->number }}</td>
                                <td field-key='location'>{{ $tracking_number->location->nickname or '' }}</td>
                                <td field-key='company'>{{ $tracking_number->company->name or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.tracking_numbers.restore', $tracking_number->id])) !!}
                                    {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.tracking_numbers.perma_del', $tracking_number->id])) !!}
                                    {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                                                </td>
                                @else
                                <td>
                                    @can('tracking_number_view')
                                    <a href="{{ route('admin.tracking_numbers.show',[$tracking_number->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('tracking_number_edit')
                                    <a href="{{ route('admin.tracking_numbers.edit',[$tracking_number->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                    @can('tracking_number_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.tracking_numbers.destroy', $tracking_number->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="9">@lang('global.app_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.locations.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop

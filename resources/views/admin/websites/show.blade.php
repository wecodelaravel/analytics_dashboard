@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.website.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.website.fields.website')</th>
                            <td field-key='website'>{{ $website->website }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#locations" aria-controls="locations" role="tab" data-toggle="tab">Locations</a></li>
<li role="presentation" class=""><a href="#adwords" aria-controls="adwords" role="tab" data-toggle="tab">Adwords</a></li>
<li role="presentation" class=""><a href="#analytics" aria-controls="analytics" role="tab" data-toggle="tab">Analytics</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="locations">
<table class="table table-bordered table-striped {{ count($locations) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.locations.fields.clinic-location-id')</th>
                        <th>@lang('global.locations.fields.nickname')</th>
                        <th>@lang('global.locations.fields.contact-person')</th>
                        <th>@lang('global.locations.fields.city')</th>
                        <th>@lang('global.locations.fields.state')</th>
                        <th>@lang('global.locations.fields.phone')</th>
                        <th>@lang('global.locations.fields.created-by')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($locations) > 0)
            @foreach ($locations as $location)
                <tr data-entry-id="{{ $location->id }}">
                    <td field-key='clinic_location_id'>{{ $location->clinic_location_id }}</td>
                                <td field-key='nickname'>{{ $location->nickname }}</td>
                                <td field-key='contact_person'>{{ $location->contact_person->first_name or '' }}</td>
                                <td field-key='city'>{{ $location->city }}</td>
                                <td field-key='state'>{{ $location->state }}</td>
                                <td field-key='phone'>{{ $location->phone }}</td>
                                <td field-key='created_by'>{{ $location->created_by->name or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['locations.restore', $location->id])) !!}
                                    {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['locations.perma_del', $location->id])) !!}
                                    {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                                                </td>
                                @else
                                <td>
                                    @can('view')
                                    <a href="{{ route('locations.show',[$location->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('edit')
                                    <a href="{{ route('locations.edit',[$location->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                    @can('delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['locations.destroy', $location->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="21">@lang('global.app_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
<div role="tabpanel" class="tab-pane " id="adwords">
<table class="table table-bordered table-striped {{ count($adwords) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.adwords.fields.company')</th>
                        <th>@lang('global.adwords.fields.client-customer-id')</th>
                        <th>@lang('global.adwords.fields.clinic')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($adwords) > 0)
            @foreach ($adwords as $adword)
                <tr data-entry-id="{{ $adword->id }}">
                    <td field-key='company'>{{ $adword->company->name or '' }}</td>
                                <td field-key='client_customer_id'>{{ $adword->client_customer_id }}</td>
                                <td field-key='clinic'>{{ $adword->clinic->nickname or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['adwords.restore', $adword->id])) !!}
                                    {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['adwords.perma_del', $adword->id])) !!}
                                    {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                                                </td>
                                @else
                                <td>
                                    @can('view')
                                    <a href="{{ route('adwords.show',[$adword->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('edit')
                                    <a href="{{ route('adwords.edit',[$adword->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                    @can('delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['adwords.destroy', $adword->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="17">@lang('global.app_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
<div role="tabpanel" class="tab-pane " id="analytics">
<table class="table table-bordered table-striped {{ count($analytics) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.analytics.fields.view-name')</th>
                        <th>@lang('global.analytics.fields.view-id')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($analytics) > 0)
            @foreach ($analytics as $analytic)
                <tr data-entry-id="{{ $analytic->id }}">
                    <td field-key='view_name'>{{ $analytic->view_name }}</td>
                                <td field-key='view_id'>{{ $analytic->view_id }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['analytics.restore', $analytic->id])) !!}
                                    {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['analytics.perma_del', $analytic->id])) !!}
                                    {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                                                </td>
                                @else
                                <td>
                                    @can('view')
                                    <a href="{{ route('analytics.show',[$analytic->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('edit')
                                    <a href="{{ route('analytics.edit',[$analytic->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                    @can('delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['analytics.destroy', $analytic->id])) !!}
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
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.websites.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop

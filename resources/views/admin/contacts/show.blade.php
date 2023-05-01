@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.contacts.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.contacts.fields.company')</th>
                            <td field-key='company'>{{ $contact->company->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.first-name')</th>
                            <td field-key='first_name'>{{ $contact->first_name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.last-name')</th>
                            <td field-key='last_name'>{{ $contact->last_name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.phone1')</th>
                            <td field-key='phone1'>{{ $contact->phone1 }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.phone2')</th>
                            <td field-key='phone2'>{{ $contact->phone2 }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.email')</th>
                            <td field-key='email'>{{ $contact->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.skype')</th>
                            <td field-key='skype'>{{ $contact->skype }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.notes')</th>
                            <td field-key='notes'>{!! $contact->notes !!}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#locations" aria-controls="locations" role="tab" data-toggle="tab">Locations</a></li>
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
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.contacts.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop

@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
	<h3 class="page-title">@lang('global.bookings.title')</h3>
	@can('booking_create')
	<p>
		<a href="{{ route('admin.bookings.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>

	</p>
	@endcan

	<p>
		<ul class="list-inline">
			<li><a href="{{ route('admin.bookings.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('global.app_all')</a></li> |
			<li><a href="{{ route('admin.bookings.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('global.app_trash')</a></li>
		</ul>
	</p>


	<div class="panel panel-default">
		<div class="panel-heading">
			@lang('global.app_list')
		</div>

		<div class="panel-body table-responsive">
			<table class="table table-bordered table-striped ajaxTable @can('booking_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
				<thead>
					<tr>
						@can('booking_delete')
							@if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
						@endcan

						<th>@lang('global.bookings.fields.id')</th>
						<th>@lang('global.bookings.fields.submitted')</th>
						<th>@lang('global.bookings.fields.customername')</th>
						<th>@lang('global.bookings.fields.email')</th>
						<th>@lang('global.bookings.fields.phone')</th>
						<th>@lang('global.bookings.fields.family-number')</th>
						<th>@lang('global.bookings.fields.requested-date')</th>
						<th>@lang('global.bookings.fields.requested-clinic')</th>
						<th>@lang('global.bookings.fields.clinic-id')</th>
						<th>@lang('global.bookings.fields.clinic-phone')</th>
						@if( request('show_deleted') == 1 )
						<th>Action</th>
						@else
						<th>Action</th>
						@endif
					</tr>
				</thead>
			</table>
		</div>
	</div>
@stop

@section('javascript')
	<script>
		@can('booking_delete')
			@if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.bookings.mass_destroy') }}'; @endif
		@endcan
		$(document).ready(function () {
			window.dtDefaultOptions.ajax = '{!! route('admin.bookings.index') !!}?show_deleted={{ request('show_deleted') }}';
			window.dtDefaultOptions.order = [[1, "desc"]];
			window.dtDefaultOptions.columns = [
			@can('booking_delete')
				@if ( request('show_deleted') != 1 )
					{data: 'massDelete', name: 'id', searchable: false, sortable: false},
				@endif
			@endcan
				{data: 'id', name: 'id', visible: false, searchable: false},
				{data: 'submitted', name: 'submitted'},
				{data: 'customername', name: 'customername'},
				{data: 'email', name: 'email'},
				{data: 'phone', name: 'phone'},
				{data: 'family_number', name: 'family_number'},
				{data: 'requested_date', name: 'requested_date'},
				{data: 'requested_clinic', name: 'requested_clinic'},
				{data: 'clinic_id', name: 'clinic_id'},
				{data: 'clinic_phone', name: 'clinic_phone'},

				{data: 'actions', name: 'actions', searchable: false, sortable: false}
			];
			processAjaxTables();
		});
	</script>
@endsection
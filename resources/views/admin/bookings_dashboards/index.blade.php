@extends('layouts.app')

@section('topcss')
<style type="text/css">
	.mini-stats{border-left: none !important; }
	.mini-stats .values strong{font-size: 36px !important; }
	.mini-stats .values{font-size: 18px !important; }
	.mini-stats li{border-right: none !important; }
	.table-13 th,.table-13 td{font-size: 13px !important; }
	.todo li a strong{padding-right: 5px; }
	.message-actions:focus,.todo li .message-actions:hover{text-decoration:none;background-color:#F4F6F9!important }
	.todo li .message-actions i{color:#C7CBD5;font-size:18px;margin:0 5px 0 0;position:absolute;left:10px }
</style>
@endsection

@section('topscripts')


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script type="text/javascript" src="{!! asset('/DataTables/datatables.min.js') !!}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


@endsection

@section('content')
<div class="row">
	<div class="col-md-3">
		<h3 class="page-title">@lang('global.bookings-dashboard.title')</h3>
		<p>   </p>
	</div>
</div>

{!! Form::open(['method' => 'get','id' => 'filter_form']) !!}
<div class="row">
    <div class="form-group col-md-4">
        <label>Date Range</label>
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" name="date-range" class="form-control pull-right" value="{!!@$search_params['date-range']!!}">
        </div>
    </div>
    <div class="form-group col-md-4">
        <label for="inputWebsite">Clinic</label>
        {!! Form::select('clinic', @$clinics,@$search_params['clinic'], array('placeholder' => 'Select Clinic', 'class'=>'form-control', 'id' => 'clinic', 'value'=>@$search_params['clinic'])) !!}
    </div>
    <div class="form-group col-md-4">
        <label for="inputWebsite">Location</label>
        {!! Form::select('location_id', @$locations,@$search_params['location_id'], array('placeholder' => 'All', 'class'=>'form-control', 'id' => 'location_id', 'value'=>@$search_params['location_id'])) !!}
    </div>
</div>
{!! Form::close() !!}
<hr style="clear:both" />

@if($clinic_id > 0)
@include('admin.bookings_dashboards.partials.topwidgets')
<hr style="clear:both" />
 
<div class="row">    
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
</div>
@else
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">Select above filters to view bookings dashboard</div>
    </div>
</div>
@endif
@stop

@section('bottomscripts')
<script>
	$(function () {
		$('input[name="date-range"]').daterangepicker({
			opens: 'left',
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			}
		}, function (start, end, label) {
			console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
			$('input[name="date-range"]').val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'))
			$('#filter_form').submit();
		});

		var start = moment().subtract(29, 'days');
		var end = moment();

		function cb(start, end) {
			$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		}

		$('#reportrange').daterangepicker({
			startDate: start,
			endDate: end,
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			}
		}, cb);

		cb(start, end);

		$('select[name="clinic"],select[name="location_id"]').on("change", function () {
                    $('#filter_form').submit();
		});
	});
        $(document).ready(function () {
			window.dtDefaultOptions.ajax = '{!! route('admin.bookings_dashboards.index') !!}?date-range={{ request('date-range') }}&clinic={{ request('clinic') }}';
			window.dtDefaultOptions.order = [[2, "desc"]];
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

@section('javascript')
	<script>

	</script>
@endsection


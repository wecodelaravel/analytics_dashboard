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
		<h3 class="page-title">@lang('global.lca-dashboard.title')</h3>
		<p>  {{ trans('global.app_custom_controller_index') }}   </p>
	</div>
</div>

{!! Form::open(['method' => 'get','id' => 'filter_form']) !!}
 <div class="row">
{{--	<label for="inputWebsite">Clinic</label>
	<input type="text" class="form-control">
	{!! Form::select('clinic', @$clinics, @$search_params['clinic'], array('placeholder' => 'Select Clinic', 'class'=>'form-control', 'id' => 'clinic', 'value'=>@$search_params['clinic'])) !!}
</div> --}}

	<div class="form-group col-md-4">
		<label>Date Range</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
			</div>
			<input type="text" name="date-range" class="form-control pull-right" value="{!!@$search_params['date-range']!!}">
		</div>
	</div>


</div>
{!! Form::close() !!}

<hr style="clear:both" />





<div class="row">
	{{-- dd($anadata) --}}
</div>

<div class="row">
	@include('admin.lca_dashboards.partials.center')
	@include('admin.lca_dashboards.partials.topwidgets')
</div>

<hr style="clear:both" />

{{-- @include('admin.bookings_dashboards.partials.analytics_section') --}}



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

		$('select[name="clinic"]').on("change", function () {
			if($(this).attr('id') == 'clinic'){
				$('#clinic').val('');
			}
			$('#filter_form').submit();
		});
	});
</script>
@endsection

@section('javascript')
	<script>

	</script>
@endsection


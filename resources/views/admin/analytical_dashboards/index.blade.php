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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script type="text/javascript" src="{!! asset('/DataTables/datatables.min.js') !!}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="{!! asset('/public/javascript/embed-api/components/view-selector2.js') !!}"></script>
<script src="{!! asset('/public/javascript/embed-api/components/date-range-selector.js') !!}"></script>
<script src="{!! asset('/public/javascript/embed-api/components/active-users.js') !!}"></script>
<link rel="stylesheet" href="{!! asset('/public/css/chartjs-visualizations.css') !!}">

<script type="text/javascript">
    @if($view_id > 0)
    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawChartVisitors);
    google.charts.setOnLoadCallback(drawChartPageviews);
    google.charts.setOnLoadCallback(drawChartPage);

    function drawChartVisitors() {

        var data = new google.visualization.DataTable();
        data.addColumn('{{$column_type}}', '{{$column_name}}');
        data.addColumn('number', 'Visitors');
<?php
$json = json_encode($visitors_chart);
$json = preg_replace("/(('|\")%%|%%(\"|'))/", '', $json);
?>
        data.addRows(<?=$json?>);

        var options = {
            hAxis: {
                title: '{{$column_name}}',
                format: '{{$column_format}}'
            },
            vAxis: {
                title: 'Visitors',
                format: '#',
            },
            chartArea: {right: 0, width: '90%', height: '80%'}
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_visitors'));

        chart.draw(data, options);
    }

    function drawChartPageviews() {

        var data = new google.visualization.DataTable();
        data.addColumn('{{$column_type}}', '{{$column_name}}');
        data.addColumn('number', 'Pageviews');
<?php
$json = json_encode($pageviews_chart);
$json = preg_replace("/(('|\")%%|%%(\"|'))/", '', $json);
?>
        data.addRows(<?=$json?>);

        var options = {
            hAxis: {
                title: '{{$column_name}}',
                format: '{{$column_format}}'
            },
            vAxis: {
                title: 'Pageviews',
                format: '#',
            },
            chartArea: {right: 0, width: '90%', height: '80%'}
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_pageviews'));

        chart.draw(data, options);
    }

    function drawChartPage() {
        var data = google.visualization.arrayToDataTable(<?=json_encode($page_chart)?>);

        var options = {
            is3D: true,
            chartArea: {left: 0, top: 0, width: '100%', height: '100%'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d_page'));
        chart.draw(data, options);
    }

    @endif


</script>

@endsection

@section('content')
<div class="row">
    <div class="col-md-3">
        <h3 class="page-title">@lang('global.analytical-dashboard.title')</h3>
        <p> {{-- trans('global.app_custom_controller_index') --}} </p>
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
        <label for="inputWebsite">Website</label>
        {!! Form::select('website', @$websites,@$search_params['website'], array('placeholder' => 'Select Website', 'class'=>'form-control', 'id' => 'website', 'value'=>@$search_params['website'])) !!}
    </div>
    <div class="form-group col-md-4">
        <label for="view">View</label>
        {!! Form::select('view', @$views,@$search_params['view'], array('placeholder' => 'Select View', 'class'=>'form-control', 'id' => 'view', 'value'=>@$search_params['view'])) !!}
    </div>
</div>
{!! Form::close() !!}
<hr style="clear:both" />

@if($view_id > 0)
@include('admin.analytical_dashboards.partials.topwidgets')
@endif

<hr style="clear:both" />

<div class="row">
  {{-- @include('admin.analytical_dashboards.partials.additional') --}}
</div>

@if($view_id > 0)
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="clip-stats"></i>
                Visitors
            </div>
            <div class="panel-body">
                <div id="chart_div_visitors" style="height: 305px;"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="clip-stats"></i>
                Pageviews
            </div>
            <div class="panel-body">
                <div id="chart_div_pageviews" style="height: 305px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="clip-stats"></i>Top Pages
            </div>
            <div class="panel-body">
                <div id="piechart_3d_page" style="height: 305px;"></div>
            </div>
        </div>
    </div>
</div>


@else
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">Select above filters to view analytics dashboard</div>
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

        $('select[name="website"],select[name="view"]').on("change", function () {
            if($(this).attr('id') == 'website'){
                $('#view').val('');
            }
            $('#filter_form').submit();
        });
    });
</script>
@endsection


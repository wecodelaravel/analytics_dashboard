
<div class="row">
    <div class="col-md-12">
      <h1>PULL SAME DATA THAT IS ON ANALYTICAL DASHBOARD FOR HERE BUT MAYBE CACHE THE QUERY FOR THIS DATA FROM LAST VIEW OF ANALYTICS SO REDUCE THE AMOUNT OF QUERIES BEING MADE. DELETE THIS LINE WHEN DONE WITH THIS PART</h1>
</div>
</div>
{{-- @if($view_id > 0) --}}
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
{{-- <div class="row">
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
</div> --}}
{{-- @else
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">Select above filters to view analytics dashboard</div>
    </div>
</div>
@endif --}}
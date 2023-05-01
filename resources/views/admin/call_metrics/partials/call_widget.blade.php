<div class="ctm-dash"
				 data-dates='<?php echo json_encode($dates); ?>'
				 data-today="<?php echo date('Y-m-d') ?>"
				 data-start="<?php echo date('Y-m-d', strtotime('-30 days')); ?>"
				 data-stats='<?php echo json_encode($stats)?>'>
		</div>
		<script id="ctm-dash-template" type="text/x-mustache">
			<div style="height:250px" class="stats"></div>
			<h3 class="ctm-stat total_calls">Total Calls: {{total_calls}}</h3>
			<h3 class="ctm-stat total_unique_calls">Total Callers: {{total_unique_calls}}</h3>
			<h3 class="ctm-stat average_call_length">Average Call Time: {{average_call_length}}</h3>
			<h3 class="ctm-stat top_call_source">Top Call Source: {{top_call_source}}</h3>
		</script>
		<script>
			if(!Array.prototype.indexOf){Array.prototype.indexOf=function(e){"use strict";if(this==null){throw new TypeError}var t=Object(this);var n=t.length>>>0;if(n===0){return-1}var r=0;if(arguments.length>1){r=Number(arguments[1]);if(r!=r){r=0}else if(r!=0&&r!=Infinity&&r!=-Infinity){r=(r>0||-1)*Math.floor(Math.abs(r))}}if(r>=n){return-1}var i=r>=0?r:Math.max(n-Math.abs(r),0);for(;i<n;i++){if(i in t&&t[i]===e){return i}}return-1}}
			jQuery(function($) {
				var dashTemplate = Mustache.compile($("#ctm-dash-template").html());
				var stats = $.parseJSON($("#ctm_dash .ctm-dash").attr("data-stats"));
				var startDate = $("#ctm_dash .ctm-dash").attr("data-start");
				var endDate = $("#ctm_dash .ctm-dash").attr("data-today");
				var categories = $.parseJSON($("#ctm_dash .ctm-dash").attr("data-dates")).reverse();

				$("#ctm_dash .ctm-dash").html(dashTemplate(stats));
				var data = [], calls = (stats && stats.stats) ? stats.stats.calls : [];
				for (var i = 0, len = categories.length; i < len; ++i) {
					data.push(0); // zero fill
				}
				for (var c in calls) {
					data[categories.indexOf(c)] = calls[c][0];
				}
				var series = [{
												name: 'Calls', data: data,
												pointInterval: 24 * 3600 * 1000,
												pointStart: Date.parse(categories[0])
											}];
				var chart = new Highcharts.Chart({
					credits: { enabled: false },
					chart: { type: 'column', renderTo: $("#ctm_dash .stats").get(0), plotBackgroundColor:null, backgroundColor: 'transparent' },
					yAxis: { min: 0, title: { text: "Calls" } },
					title: { text: 'Last 30 Days' },
					legend: { enabled: false },
					//tooltip: { formatter: function() { return '<b>'+ this.x +'</b><br/> '+ this.y; } },
					xAxis: {
						type: 'datetime',
						minRange: 30 * 24 * 3600000 // last 30 days
					},
					series: series
				});
			});
		</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div class="small-12 columns radius" id="chart-wrapper">
	
	<div id="chart_div"></div>

	<div class="columns">
		<h3 class="small-5 columns">February 2016</h3>
		<div class="chart-legend small-6 columns">
			<label class="small-6 columns"><i class="fa fa-square" style="color: #014694;"></i><span>This Month</span></label>
			<label class="small-6 columns"><i class="fa fa-square" style="color: #627E93;"></i><span>Last Month</span></label>
		</div>
	</div>
	
	<script>
		  google.charts.load('current', {'packages':['bar']});
	      google.charts.setOnLoadCallback(drawChart);

	      function drawChart() {
	        var data = google.visualization.arrayToDataTable([
	          ['', 'This Month', 'Last Month'],
	          ['2014', 1000, 400],
	          ['2015', 1170, 460],
	          ['2016', 660, 1120],
	          ['2017', 1030, 540]
	        ]);

	        var options = {
	       	  legend : { position:"none"},
	          chart: {
	            title: '',
	            subtitle: '',
	          },
	          bars: 'vertical',
	          vAxis: {format: 'decimal'},
	          height: 400,
	          colors: ['#014694', '#627E93'],
	        };


	        var chart = new google.charts.Bar(document.getElementById('chart_div'));

	        chart.draw(data, google.charts.Bar.convertOptions(options));


	        
	      }

	</script>
</div>
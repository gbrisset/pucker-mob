
<div class="small-12 columns radius" id="chart-wrapper">
<input type="hidden" id="height_chart" value="<?php if($detect->isMobile()) echo 250; else echo 400; ?>" />
	<div id="chart_div"></div>
	<div class="columns">
		<h3 id="month-year-title" class="small-12 large-4 columns no-padding"><?php echo date('F').' '.date('Y')?></h3>
		<div class="chart-legend small-12 large-7 xxlarge-5 columns no-padding-right">
			<label class="small-6 columns  no-padding-left"><i class="fa fa-square" style="color: #014694;"></i><span>This Month</span></label>
			<label class="small-6 columns  no-padding-right"><i class="fa fa-square" style="color: #627E93;"></i><span>Last Month</span></label>
		</div>
	</div>
</div>
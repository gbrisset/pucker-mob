<?php 
	$incentives = new Incentives();

	$selected_month =  date('n');
	$limit = 50;

	if(count($_POST) > 0){
		$selected_month = $_POST['month'];
	}
	$incentives_month = $incentives->where(' month = '.$selected_month.' AND year = '.date('Y').' ' );
	$rank_list = $ManageDashboard->getTopShareWritesRank( $selected_month, $limit);

	if( isset($rank_list) && count($rank_list) > 0 ){
		$index = 1;
?>

<div class = "small-12 columns no-padding">

	<form id="social-media-shares-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

		<div class="small-12 columns no-padding"> 
	  	<select class="small-12 large-3 columns right" name='month' id="month-option" required style="background-position: 90% 60%">
	  		<option value='0'>Month</option>
		  	<?php 
		  	$j = 6;
		  	for($m = $j; $m <= 12; $m++){
		  		$dateObj   = DateTime::createFromFormat('!m', $m);
		  		$monthName = $dateObj->format('F');
		  		if($selected_month == $m) $selected  = 'selected'; else $selected = '';
		  		echo '<option value="'.$m.'" '.$selected.' >'.$monthName.'</option>';
			} ?>
		</select>
		</div>
	</form>
	
	<table  class="small-12 large-12 columns">
		<thead>
			<td class="bold">RANK</td>
			<td class="bold">NAME</td>
			<td class="bold align-center">U.S. VIEWS</td>
			<td class="bold align-center">BONUS</td>
		</thead>
		<tbody>
			<?php
			foreach( $incentives_month as $inc ) {
				for( $j = $inc->start; $j < $inc->end; $j++ ){ 
					$bonus = $inc->bonus;
				?>
				<tr id="contributor_id_<?php echo $rank_list[$j]['contributor_id']; ?>">
					<td style="padding-left: 20px; "><?php echo $index; ?></td>
					<td><?php echo $rank_list[$j]['contributor_name']; ?></td>
					<td class="align-center"><?php echo number_format($rank_list[$j]['total_us_pageviews']); ?></td>
					<td class="align-center" style="    color: green; font-size: 1rem;"><?php echo $bonus; ?></td>
				</tr>
			<?php 
				$index++;
				} 
			}?>
		</tbody>
	</table>
</div>
<?php } ?>
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
	<div class="small-12 no-padding margin-bottom" style="height: 40rem; overflow: scroll;">
	<table  class="small-12 large-12 columns" >
		<thead>
			<td class="bold">RANK</td>
			<td class="bold">NAME</td>
			<td class="bold align-center">VIEWS</td>
			<td class="bold align-center">BONUS</td>
		</thead>
		<tbody>
			<?php
			$pro = $basic = array();
			foreach( $incentives_month as $inc ) {
				for( $j = $inc->start; $j < $inc->end; $j++ ){ 
					$bonus = $inc->bonus;
					if( $rank_list[$j]['user_type'] == 8 || $rank_list[$j]['user_type'] == 9  ){
						$pro[] = [ 
							'index' => $index, 
							'contributor_id' =>$rank_list[$j]['contributor_id'], 
							'contributor_name' =>$rank_list[$j]['contributor_name'], 
							'total_us_pageviews' =>$rank_list[$j]['total_us_pageviews'], 
							'bonus' =>$bonus,
							'user_type' => $rank_list[$j]['user_type']
						];
					}else{
						$basic[] = [
							'index' => $index, 
							'contributor_id' =>$rank_list[$j]['contributor_id'], 
							'contributor_name' =>$rank_list[$j]['contributor_name'], 
							'total_us_pageviews' =>$rank_list[$j]['total_us_pageviews'], 
							'bonus' =>$bonus,
							'user_type' => $rank_list[$j]['user_type']
						];
					}
				?>
				<tr id="contributor_id_<?php echo $rank_list[$j]['contributor_id']; ?>" data-type="<?php echo $rank_list[$j]['user_type']; ?> ">
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
</div>

<div class="small-6 columns no-padding-left margin-top"  style="height: 40rem; overflow: scroll;">
	<table  class="small-12 large-12 columns">
		<thead>
			<td class="bold">RANK</td>
			<td class="bold">NAME</td>
			<td class="bold align-center">VIEWS</td>
			<td class="bold align-center">BONUS</td>
		</thead>
		<tbody>
			<?php 
			foreach( $pro as $blogger ) { ?>
				
				<tr id="contributor_id_<?php echo $blogger['contributor_id']; ?>" data-type="<?php echo $blogger['user_type']; ?> ">
					<td style="padding-left: 20px; "><?php echo $blogger['index']; ?></td>
					<td><?php echo $blogger['contributor_name']; ?></td>
					<td class="align-center"><?php echo number_format($blogger['total_us_pageviews']); ?></td>
					<td class="align-center" style="    color: green; font-size: 1rem;"><?php echo $blogger['bonus']; ?></td>
				</tr>
			<?php }?>
		</tbody>
	</table>
</div>
<div class="small-6 columns no-padding-right margin-top" style="height: 40rem; overflow: scroll;" >
	<table  class="small-12 large-12 columns" >
		<thead>
			<td class="bold">RANK</td>
			<td class="bold">NAME</td>
			<td class="bold align-center">VIEWS</td>
			<td class="bold align-center">BONUS</td>
		</thead>
		<tbody>
			<?php foreach( $basic as $blogger ) { ?>
				
				<tr id="contributor_id_<?php echo $blogger['contributor_id']; ?>" data-type="<?php echo $blogger['user_type']; ?> ">
					<td style="padding-left: 20px; "><?php echo $blogger['index']; ?></td>
					<td><?php echo $blogger['contributor_name']; ?></td>
					<td class="align-center"><?php echo number_format($blogger['total_us_pageviews']); ?></td>
					<td class="align-center" style="    color: green; font-size: 1rem;"><?php echo $blogger['bonus']; ?></td>
				</tr>
			<?php }?>
		</tbody>
	</table>
</div>
<?php } ?>
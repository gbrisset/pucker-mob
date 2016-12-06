<?php 
	$incentives = new Incentives();
	$selected_month =  date('n');
	$year = date('Y');
	$limit = 50;
	if(count($_POST) > 0) $selected_month = $_POST['month'];
	
	//Incentives Infor Current Month
	$incentives_month = $incentives->where(' month = '.$selected_month.' AND year = '.date('Y').' ' );
	
	//GET RANK LIST INFORMATION
	$rank_list = $ManageDashboard->getTopShareWritesRank( $selected_month, $limit);
	$rank_list_basic = $ManageDashboard->getTopShareWritesRank( $selected_month, $limit , '3');
	$rank_list_pro = $ManageDashboard->getTopShareWritesRank( $selected_month, $limit , '8');

	if( isset($rank_list) && count($rank_list) > 0 ){
		$index = 1;
		$old = false; 
		if( $selected_month < 11 && $year == 2016 ) $old = true;
?>

<div class = "small-12 columns">

	<form id="social-media-shares-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

		<div class="small-12 columns no-padding"> 
	  	<select class="small-12 large-3 columns right" name='month' id="month-option" required style="background-position: 90% 60%">
	  		<option value='0'>Month</option>
		  	<?php 
		  	$j = 1;
		  	for($m = $j; $m <= 12; $m++){
		  		$dateObj   = DateTime::createFromFormat('!m', $m);
		  		$monthName = $dateObj->format('F');
		  		if($selected_month == $m) $selected  = 'selected'; else $selected = '';
		  		echo '<option value="'.$m.'" '.$selected.' >'.$monthName.'</option>';
			} ?>
		</select>
		</div>
	</form>
	<h2 style=" color: green; font-family: OsloBold; font-size: 22px;">OVERALL RANKING</h2>

	<div class="small-12  margin-bottom" style="height: 40rem; overflow: scroll;">
	<table  class="small-12 large-12 columns" >
		<thead>
			<td class="bold">RANK</td>
			<td class="bold">NAME</td>
			<td class="bold align-center">VIEWS</td>
			<?php if($old){?>
				<td class="bold align-center">BONUS</td>
			<?php }else{?>
				<td class="bold align-center">TYPE</td>
			<?php }?>
		</thead>
		<tbody>
			<?php if($old){

				foreach( $incentives_month as $inc ) {
				$bonus_user = $inc->user_type;
				$user_type = explode(", ", $inc->user_type);
				$bonus = $inc->bonus;

				for( $j = $inc->start; $j <= $inc->end -1; $j++ ){ 

				?>
				<tr id="contributor_id_<?php echo $rank_list[$j]['contributor_id']; ?>" data-type="<?php echo $rank_list[$j]['user_type']; ?> ">
					<td style="padding-left: 20px; "><?php echo $index; ?></td>
					<td><a href="http://www.puckermob.com/admin/profile/user/<?php echo $rank_list[$j]['contributor_seo_name']; ?>"><?php echo $rank_list[$j]['contributor_name']; ?></a></td>
					<td class="align-center"><?php echo number_format($rank_list[$j]['total_us_pageviews']); ?></td>
					<td class="align-center" style="color: green; font-size: 1rem;"><?php echo $bonus; ?></td>
				</tr>
			<?php 
			 $index++;
				}	
			}

			}else{
			
				foreach( $incentives_month as $inc ) {
					$bonus_user = $inc->user_type;
					$user_type = explode(", ", $inc->user_type);
					
					for( $j = $inc->start; $j <= $inc->end -1; $j++ ){ 
					
						$label_type = 'C';
						if( $rank_list[$j]['user_type'] == 8) $label_type = 'P';
					?>
					<tr id="contributor_id_<?php echo $rank_list[$j]['contributor_id']; ?>" data-type="<?php echo $rank_list[$j]['user_type']; ?> ">
						<td style="padding-left: 20px; "><?php echo $index; ?></td>
						<td><a style="color:#222;" href="http://www.puckermob.com/admin/profile/user/<?php echo $rank_list[$j]['contributor_seo_name']; ?>"><?php echo $rank_list[$j]['contributor_name']; ?></a></td>
						<td class="align-center"><?php echo number_format($rank_list[$j]['total_us_pageviews']); ?></td>
						<td class="align-center" style="color: green; font-size: 1rem;"><?php echo $label_type; ?></td>
					</tr>
				<?php 
				 $index++;
					}	
				}
			} ?>
		</tbody>
	</table>
	</div>
</div>

<div class="small-12 xlarge-6 columns  margin-top">
	<h2 style=" color: green; font-family: OsloBold; font-size: 22px;">PRO BLOGGERS</h2>

	<div style="height: 40rem; overflow: scroll;" >
	<table  class="small-12 large-12 columns">
		<thead>
			<td class="bold">RANK</td>
			<td class="bold">NAME</td>
			<td class="bold align-center">VIEWS</td>
			<?php if( !$old){?>
			<td class="bold">BONUS</td>
			<?php }?>

		</thead>
		<tbody>
			<?php 
			foreach( $incentives_month as $inc ) {
				$bonus_user = $inc->user_type;
				$user_type = explode(", ", $inc->user_type);
				$bonuses = explode(", ", $inc->bonus);
				$bonus = $bonuses[1];
				$total = 0;
				
				$index = 1;
				for( $j = $inc->start; $j < $inc->end; $j++ ){ 
					if($inc->month == 12 && $year == 2016) {
						$total = floor($rank_list_pro[$j]['total_us_pageviews'] / 100000 );
						$bonus = $total * 25;
					}
				if( $j > count($rank_list_pro)) break;
			 ?>
				<tr id="contributor_id_<?php echo $rank_list_pro[$j]['contributor_id']; ?>" data-type="<?php echo $rank_list_pro[$j]['user_type']; ?> ">
					<td style="padding-left: 20px; "><?php echo $index; ?></td>
					<td><a style="color:#222;" href="http://www.puckermob.com/admin/profile/user/<?php echo $rank_list_pro[$j]['contributor_seo_name']; ?>"><?php echo $rank_list_pro[$j]['contributor_name']; ?></a></td>
					<td class="align-center"><?php echo number_format($rank_list_pro[$j]['total_us_pageviews']); ?></td>
					<?php if( !$old){?><td><?php echo $bonus; ?></td><?php }?>
				</tr>
			<?php $index++; }
		}?>
		</tbody>
	</table>
	</div>
</div>

<div class="small-12 xlarge-6 columns  margin-top margin-bottom" >
	<h2 style=" color: green; font-family: OsloBold; font-size: 22px;">COMMUNITY BLOGGERS</h2>
	<div style="height: 40rem; overflow: scroll;" >
	<table  class="small-12 large-12 columns" >
		<thead>
			<td class="bold">RANK</td>
			<td class="bold">NAME</td>
			<td class="bold align-center">VIEWS</td>
			<?php if( !$old){?><td class="bold">BONUS</td><?php }?>
		</thead>
		<tbody>
			<?php 
			foreach( $incentives_month as $inc ) {
				$bonus_user = $inc->user_type;
				$user_type = explode(", ", $inc->user_type);
				$bonuses = explode(", ", $inc->bonus);

				$bonus = $bonuses[0];

			$index = 1;
			for( $j = $inc->start; $j < $inc->end ; $j++ ){ 
				if($inc->month == 12 && $year == 2016) {
						$total = floor($rank_list_basic[$j]['total_us_pageviews'] / 100000 );
						$bonus = $total * 25;
					}
				?>
				<tr id="contributor_id_<?php echo $rank_list_pro[$j]['contributor_id']; ?>" data-type="<?php echo $rank_list_basic[$j]['user_type']; ?> ">
					<td style="padding-left: 20px; "><?php echo $index; ?></td>
					<td><a style="color:#222;" href="http://www.puckermob.com/admin/profile/user/<?php echo $rank_list_basic[$j]['contributor_seo_name']; ?>"><?php echo $rank_list_basic[$j]['contributor_name']; ?></a></td>
					<td class="align-center"><?php echo number_format($rank_list_basic[$j]['total_us_pageviews']); ?></td>
					<?php if( !$old){?><td><?php echo $bonus; ?></td><?php }?>
				</tr>
			<?php $index++; }

		}?>
		</tbody>
	</table>
	</div>
</div>
<?php } ?>
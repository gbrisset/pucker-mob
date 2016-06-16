<?php 
	if( isset($rank_list) && count($rank_list) > 0 ){
		$index = 1;

?>
<div class="show-for-large-up left" style="width: 4rem;">
				<img style="height:100%;" src="http://www.puckermob.com/admin/assets/img/misc/bonus-100.jpg" />
				<img style="height:100%;" src="http://www.puckermob.com/admin/assets/img/misc/bonus-25.jpg" />

			</div>
<div class = " small-12 large-10 xxlarge-11 columns no-padding">
	<table  class="small-12 large-6 columns">
		<thead>
			<td class="bold">RANK</td>
			<td class="bold">NAME</td>
			<td class="bold align-center">U.S. VIEWS</td>
		</thead>
		<tbody>
			<?php 
				for( $j = 0; $j < 20; $j ++ ){ 
						$background = '';
						if($j == 11 || $j == 13) $background = 'background: #afb5eb;';
				?>

					<tr id="contributor_id_<?php echo $rank_list[$j]['contributor_id']; ?>" style="<?php echo $background; ?>" class="<?php if( $j > 9 ) echo " gray-out "; ?>">
						<td style="padding-left: 20px; "><?php echo $index; ?></td>
						<td><?php echo $rank_list[$j]['contributor_name']; ?></td>
						<td class="align-center"><?php echo number_format($rank_list[$j]['total_us_pageviews']); ?></td>
					</tr>
			<?php 
				$index++;
			} ?>
		</tbody>
	</table>

	<table  class="small-12 large-6 columns incentive-second-table">
		<thead>
			<td class="bold">RANK</td>
			<td class="bold">NAME</td>
			<td class="bold align-center">U.S. VIEWS</td>
		</thead>
		<tbody>
			<?php 
				for( $j = 20; $j < 40; $j++ ){ ?>
					<tr id="contributor_id_<?php echo $rank_list[$j]['contributor_id']; ?>">
						<td style="padding-left: 20px; "><?php echo $index; ?></td>
						<td><?php echo $rank_list[$j]['contributor_name']; ?></td>
						<td class="align-center"><?php echo number_format($rank_list[$j]['total_us_pageviews']); ?></td>
					</tr>
			<?php 
				$index++;
			} ?>
		</tbody>
	</table>
</div>
<?php } ?>
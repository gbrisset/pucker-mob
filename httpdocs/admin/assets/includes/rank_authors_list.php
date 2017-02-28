	<?php 
		$incentives = new Incentives();
	
		if(count($_POST) > 0) {
			$selected_date = explode("XX",$_POST['date_pick']);
			$selected_month = $selected_date[0];
			$selected_year = $selected_date[1];	
		}else{
			$selected_month = date('n');
			$selected_year = date('Y');		
		}//end if

		$current_month = date("F Y", mktime(0, 0, 0, $selected_month, 1, $selected_year));
		$current_month_disclaimer = ($selected_month == date('n') &&	$selected_year == date('Y'))? "<i>(TEMPORARY)</i>" :  "";			
		

	?>

	<div class = "small-12 columns">

		<form id="social-media-shares-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" />

			<!-- <div class="small-6 columns no-padding"><?php   ?></div> -->
		  	<div class="small-12 columns no-padding">
		  	<select class="small-12 large-3 columns right" name='date_pick' id="month-option" required style="background-position: 90% 60%">
		  		<option value='0'>Month</option>
			  	<?php
			  	$monthNum = date('n');
			  	$yearNum = date('Y');
			  	for($xx = 0; $xx <=24; $xx++){
					if($monthNum <1) {$monthNum = $monthNum + 12;$yearNum = $yearNum -1; }
					$dateOption = mktime(0, 0, 0, $monthNum, 1, $yearNum);
					$monthName =  date("F", $dateOption); 
					$yearName =  date("Y", $dateOption); 
					if($selected_month == $monthNum && $selected_year == $yearNum) $selected  = 'selected'; else $selected = '';
					if($dateOption >= strtotime("6/1/2016") ) echo '<option value="'.$monthNum.'XX'.$yearNum.'" '.$selected.' >'.$yearName.' - '.$monthName.'</option>'; //there is no Data prior June 2016  -- GB 2017-01-17
					$monthNum--;
				}//end for
			  	?>
			</select>
			</div>
		</form>
		
<?php


		//Incentives Infor Current Month
		$incentives_of_the_month = $incentives->getIncentives(' month = '.$selected_month.' AND year = '.$selected_year );
		var_dump($incentives_of_the_month);

?>

		<h2 style=" color: green; font-family: OsloBold; font-size: 22px;">OVERALL RANKING <?php echo $current_month_disclaimer ?></h2>
<!-- ************************************************************************************************************** -->
		<div class="small-12  margin-bottom" style="height: 40rem; overflow: scroll;">
		<table  class="small-12 large-12 columns" >
			<thead>
				<td class="bold">RANK</td>
				<td class="bold">NAME</td>
				<td class="bold">LEVEL</td>
				<td class="bold align-center">VIEWS</td>
				<td class="bold align-center">BONUS</td>
			</thead>
			<tbody>
			<?php

				$rank = 1;
				$x_pro = 1;
				$x_com = 1;
				foreach( $incentives_of_the_month as $inc ) {
					$bonus_txt =  $inc->bonus_txt;
					$bonus_threshold =  $inc->bonus_threshold;
					$bonus_slice =  $inc->bonus_slice;
					$bonus_tier =  $inc->bonus_tier;
					$bonus_sum = ($bonus_threshold + $bonus_slice + $bonus_tier);
					if($bonus_sum>0){
						$threshold = $inc->threshold; 
						//threshold applies to incentives like "Get $50 if you get more than 250,000 views"
						$slice = $inc->slice; 
						//slice applies to incentives like "Get $25 per 100,000 views"
						$tier = $inc->tier; 
						//tier is structured as  LIMIT x,y in SQL
						//and  applies to incentives like "top 5  get $100 (LIMIT 0, 5), next 10  get $100 (LIMIT 5, 10), etc. "
						$user_type = $inc->user_type;

						$inc_options = "AND ( " ;
						if($threshold >0) $inc_options .= "  c.total_us_pageviews > $threshold ";
						if($slice >0 && $threshold >0) $inc_options .= " OR ";
						if($slice >0 ) $inc_options .= " c.total_us_pageviews > $slice ";
						$inc_options .= " ) ";
						if($slice ==0 && $threshold==0) $inc_options = "";
						
						$rank_list = $ManageDashboard->getIncentivesRank( $selected_year, $selected_month, $tier, $user_type, $inc_options);

						if ($rank_list){

						foreach($rank_list as $list_item ) {
							$contributor_id = $list_item['contributor_id'];
							$user_type = $list_item['user_type'];
							$contributor_seo_name = $list_item['contributor_seo_name'];
							$contributor_name = $list_item['contributor_name'];
							$label = $list_item['label'];
							$pageviews = $list_item['total_us_pageviews'];

							$contributor_bonus = 0;
							if ($slice>0) $contributor_bonus = $contributor_bonus + ($bonus_slice * floor($pageviews/$slice));
							if ($threshold>0 && $pageviews>$threshold) $contributor_bonus = $contributor_bonus + $bonus_threshold;
							if ($tier!='') $contributor_bonus = $contributor_bonus + $bonus_tier;
							//building the Subsets  - PRO
							
							if ($user_type==8){
								$rank_list_pro[$x_pro]['contributor_id'] = $contributor_id;
								$rank_list_pro[$x_pro]['user_type'] = $user_type;
								$rank_list_pro[$x_pro]['contributor_seo_name'] = $contributor_seo_name;
								$rank_list_pro[$x_pro]['contributor_name'] = $contributor_name;
								$rank_list_pro[$x_pro]['label'] = $label;
								$rank_list_pro[$x_pro]['pageviews'] = $pageviews;
								$rank_list_pro[$x_pro]['contributor_bonus'] = $contributor_bonus;
								$x_pro++;
							}//if ($user_type==8)

							//building the Subsets  - COMMUNITY
							if ($user_type==3){
								$rank_list_com[$x_com]['contributor_id'] = $contributor_id;
								$rank_list_com[$x_com]['user_type'] = $user_type;
								$rank_list_com[$x_com]['contributor_seo_name'] = $contributor_seo_name;
								$rank_list_com[$x_com]['contributor_name'] = $contributor_name;
								$rank_list_com[$x_com]['label'] = $label;
								$rank_list_com[$x_com]['pageviews'] = $pageviews;
								$rank_list_com[$x_com]['contributor_bonus'] = $contributor_bonus;
								$x_com++;
							}//if ($user_type==8)


							?>
							<tr id="contributor_id_<?php echo $contributor_id; ?>" data-type="<?php echo $user_type; ?> ">
								<td style="padding-left: 20px; "><?php echo $rank; ?></td>
								<td><a href="http://www.puckermob.com/admin/profile/user/<?php echo $contributor_seo_name; ?>"><?php echo $contributor_name; ?></a></td>
								<td><?php echo $label; ?></td>
								<td class="align-center"><?php echo number_format($pageviews); ?></td>
								<td class="align-center" style="color: green; font-size: 1rem;"><?php echo "$".$contributor_bonus; ?></td>
							</tr>
							<?php
							$rank++;
						}// end foreach...
						}else{
							?>
							<tr>
								<td  class="align-center" colspan="5">There is currently no winners for the <?php echo $current_month; ?> plan (<?php echo $bonus_txt; ?>)</td>
								
							</tr>
							<?php
						}//end if ($rank_list)
					}else{
							?>
							<tr>
								<td  class="align-center" colspan="5">Sorry, there is no incentive plan for <?php echo $current_month; ?></td>
								
							</tr>
							<?php
					} //end if($bonus_sum>0)
				}//end foreach( $incentives_of_the_month ...


			?>
			</tbody>
		</table>
		</div>
	</div>
<!-- ************************************************************************************************************** -->

	<div class="small-12 xlarge-6 columns  margin-top">
		<h2 style=" color: green; font-family: OsloBold; font-size: 22px;">PRO <?php echo $current_month_disclaimer ?></h2>

		<div style="height: 40rem; overflow: scroll;" >
		<!-- PRO LIST  -->
		<table  class="small-12 large-12 columns" >
			<thead>
				<td class="bold">RANK</td>
				<td class="bold">NAME</td>
				<td class="bold align-center">VIEWS</td>
				<td class="bold align-center">BONUS</td>
			</thead>
			<tbody>
			<?php

				if (isset($rank_list_pro) && count($rank_list_pro)>0){
					foreach($rank_list_pro as $rank =>$list_item ) {
						$contributor_id = $list_item['contributor_id'];
						$user_type = $list_item['user_type'];
						$contributor_seo_name = $list_item['contributor_seo_name'];
						$contributor_name = $list_item['contributor_name'];
						$label = $list_item['label'];
						$pageviews = $list_item['pageviews'];
						$contributor_bonus = $list_item['contributor_bonus'];
						 
						?>
						<tr id="contributor_id_<?php echo $contributor_id; ?>" data-type="<?php echo $user_type; ?> ">
							<td style="padding-left: 20px; "><?php echo $rank; ?></td>
							<td><a href="http://www.puckermob.com/admin/profile/user/<?php echo $contributor_seo_name; ?>"><?php echo $contributor_name; ?></a></td>
							<td class="align-center"><?php echo number_format($pageviews); ?></td>
							<td class="align-center" style="color: green; font-size: 1rem;"><?php echo "$".$contributor_bonus; ?></td>
						</tr>
						<?php
					}// end foreach...
				}else{
					?>
					<tr>
						<td  class="align-center" colspan="5">There is currently no Pro winners for the <?php echo $current_month; ?> plan</td>
						
					</tr>
					<?php
				}//end if (count($rank_list_pro)>0)

			?>
			</tbody>
		</table>
		</div>
	</div>

	<div class="small-12 xlarge-6 columns  margin-top margin-bottom" >
		<h2 style=" color: green; font-family: OsloBold; font-size: 22px;">COMMUNITY <?php echo $current_month_disclaimer ?> </h2>
		<div style="height: 40rem; overflow: scroll;" >
		<!-- COMMUNITY LIST  -->
		<table  class="small-12 large-12 columns" >
			<thead>
				<td class="bold">RANK</td>
				<td class="bold">NAME</td>
				<td class="bold align-center">VIEWS</td>
				<td class="bold align-center">BONUS</td>
			</thead>
			<tbody>
			<?php

				if (isset($rank_list_com) && count($rank_list_com)>0){
					foreach($rank_list_com as $rank =>$list_item ) {
						$contributor_id = $list_item['contributor_id'];
						$user_type = $list_item['user_type'];
						$contributor_seo_name = $list_item['contributor_seo_name'];
						$contributor_name = $list_item['contributor_name'];
						$label = $list_item['label'];
						$pageviews = $list_item['pageviews'];
						$contributor_bonus = $list_item['contributor_bonus'];
						 
						?>
						<tr id="contributor_id_<?php echo $contributor_id; ?>" data-type="<?php echo $user_type; ?> ">
							<td style="padding-left: 20px; "><?php echo $rank; ?></td>
							<td><a href="http://www.puckermob.com/admin/profile/user/<?php echo $contributor_seo_name; ?>"><?php echo $contributor_name; ?></a></td>
							<td class="align-center"><?php echo number_format($pageviews); ?></td>
							<td class="align-center" style="color: green; font-size: 1rem;"><?php echo "$".$contributor_bonus; ?></td>
						</tr>
						<?php
					}// end foreach...
				}else{
					?>
					<tr>
						<td  class="align-center" colspan="5">There is currently no Community winners for the <?php echo $current_month; ?> plan</td>
						
					</tr>
					<?php
				}//end if (count($rank_list_com)>0)

			?>
			</tbody>
		</table>


		</div>
	</div>
	
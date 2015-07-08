<?php 
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	//Verify if is a content provider user
	$content_provider = false;
	$staff = false;

	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 3 || $adminController->user->data['user_type'] == 4){
		$content_provider = true;
	}

	if(!$adminController->user->checkPermission('user_permission_show_view_articles')) $adminController->redirectTo('noaccess/');

	$current_month = date('n');
	$current_year = date('Y');
	$selected_month = isset($_POST['month']) ? $_POST['month'] : $current_month;
	$selected_year = isset($_POST['year']) ? $_POST['year'] : $current_year;
	$selected_contributor = isset($_POST['contributor']) ? $_POST['contributor'] : 0;
	$new_cal = false;
	if($selected_month > 2 && $selected_year >= 2015) $new_cal = true;
	
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!

			if($selected_month > 2 && $selected_year >= 2015){
				$results = $dashboard->getPageViewsUSReport($_POST);
			}
			else{
				$results = $dashboard->socialMediaSharesReport($_POST);
			}
		}else $adminController->redirectTo('logout/');
	}

	var_dump($dashboard->getPageViewsUSReportNew($_POST));

?>

<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body id="reports">
<?php include_once($config['include_path_admin'].'header.php');?>

	<div class="sub-menu row">
		<label class="small-3" id="sub-menu-button">MENU <i class="fa fa-caret-left"></i></label>
		<h1 class="left">View Articles</h1>
	</div>
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up  hide">
			<h1 class="left">View Articles</h1>
			
	</section>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">

			<p>Get the Social Media Shares report for this month.</p>
				<section id="articles'">
						<form id="social-media-shares-form" method="post">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

						<div class="center small-12 left">
							
						<label class="small-7 inline left" style="text-align:left;"> 
						<div class="inline" style="">Date:
					  	<select class="small-6" name='month' id="month-option" required style="background-position: 90% 60%">
					  		<option value='0'>Month</option>
						  	<?php 
						  	$index = 1;
						  	for($m = $index; $m <= 12; $m++){
						  		$dateObj   = DateTime::createFromFormat('!m', $m);
						  		$monthName = $dateObj->format('F');
						  		if($selected_month == $m) $selected  = 'selected'; else $selected = '';
						  		echo '<option value="'.$m.'" '.$selected.' >'.$monthName.'</option>';
							} ?>
						</select>
						</div>
						<div class="inline">
						<select class="small-3" name='year' id="year-option" required style="background-position: 90% 60%">
					  		<option value='0'>Year</option>
						  	<?php 
						  	$index = 2014;
						  	for($y = $index; $y <= $current_year; $y++){
						  		if($selected_year == $y) $selected  = 'selected'; else $selected = '';
						  		echo '<option value="'.$y.'" '.$selected.' >'.$y.'</option>';
							} ?>
						</select>
						</div>
					</label>
						
					<label class="small-5 inline left" style="text-align:left;">Contributor:
						<div class="inline">
						<select class="small-8" name='contributor' id="contributor-option" onchange = "">
					  		<option value='0'>All</option>
						  	<?php  
						  	if(!$content_provider){
								$allContributors = $adminController->getSiteObjectAll(array('queryString' => 'SELECT * FROM article_contributors ORDER BY contributor_name ASC'));
								if($allContributors && count($allContributors)){
							
									foreach($allContributors as $contributorInfo){
										if($selected_contributor == $contributorInfo['contributor_id']) $selected  = 'selected'; else $selected = '';
										$option = '<option value="'.$contributorInfo['contributor_id'].'" '.$selected.' >';
										$option .= $contributorInfo['contributor_name'];
										$option .= '</option>';
										echo $option;
									}
								}
							}
							?>
						</select>
							</div>
					</label>
			
				</div>
				<div class="center small-12 left">
					    <div class="columns">
							<div class="btn-wrapper" style="text-align: center;">
								<button type="submit" id="submit" name="submit" class="" style="padding: 0.5rem 1rem;text-transform: uppercase; margin-right: 1rem;">Search</button>
								<a href="" id="export" name="export" style="text-transform: uppercase;">Download File<i class="fa fa-download"></i></a>
							</div>
						</div>
				</div>
			</form>
			</section>
			<section id="dashboard" class=" clear">
				<?php  if(isset($results) && $results ){
					if(!$new_cal){?>
					<table>
					  <thead>
					    <tr>
					      <th class="align-left" >Name</th>
					      <th>Article Rate</th>
					      <th>Shares</th>
					      <th>U.S. Viewers</th>
					      <th>Rate By Share</th>
					      <th>Share Rev</th>
					      
					      <th class="bold align-right">Total To Pay</th>
					    </tr>
					  </thead>
					  <tbody>
						  	<?php 

						  		$total = 0;
						  		$total_rate = 0;
						  		$total_shares = 0;
						  		$total_rev = 0;

						  		foreach( $results as $contributor){ 
						  	
						  		//if( $contributor['user_type'] != '6' || $contributor['user_type'] != '1' ){
						  		if( $contributor['total_to_pay'] == 0) continue;

						  	
						  		$contributor_type = isset($contributor['user_type']) ? $contributor['user_type'] : '4';
						  		if($contributor_type != 4 ){
							  		 $contributor['total_to_pay'] = $contributor['total_to_pay'] - $contributor['total_rate'];
							  		 $contributor['total_rate'] = 0;
						  		}

						  		$total = $total + $contributor['total_to_pay'];
						  		$us_viewers = $contributor['US_Traffic'];
						  		$total_us_viewers = $total_us_viewers  + $us_viewers;
						  		$total_rate = $total_rate + $contributor['total_rate'];
						  		$total_shares = $total_shares + $contributor['total_shares'];
						  		$total_rev = $total_rev + $contributor['share_revenue'];
						  	
						  	?>
						  	<tr>
							  	<td  class="align-left" id="contributor-id-<?php echo $contributor['contributor_id']; ?>">
							  		<a href="http://www.puckermob.com/admin/dashboard/contributor/<?php echo $contributor['contributor_seo_name'].'?month='.$selected_month.'&year='.$selected_year; ?>" target="blank">
							  			<?php echo $contributor['contributor_name']; ?>
							  		</a>
							  		<label>
							  		<?php echo $contributor['paypal_email'];?>
							  		<?php if(isset($contributor['w9_live']) && $contributor['w9_live'] === '1') echo "<br><strong style='color:green;' >W9 Form Sent!</strong>"?>
							  		</label>
							  		
							  	</td>
							  	<td><?php echo '$'.number_format($contributor['total_rate'], 0, '.', ','); ?></td>
							  	<td><?php echo number_format($contributor['total_shares'], 0, '.', ','); ?></td>
							  	<td><?php echo number_format($us_viewers, 2, '.', ','); ?></td>
							  	<td><?php echo '$'.$contributor['share_rate']; ?></td>
							  	<td><?php echo '$'.number_format($contributor['share_revenue'], 2, '.', ','); ?></td>
							  	
							  	<td class="bold align-right"><?php echo '$'.number_format($contributor['total_to_pay'], 2, '.', ','); ?></td>
							</tr>
							<?php 
							//}
							}?>
						
					  </tbody>
					  <tfoot>
					  	<tr>
					  		<td class="bold">TOTAL:</td>
					  		<td ><?php echo '$'.number_format($total_rate, 2, '.', ','); ?></td>
					  		<td><?php echo number_format($total_shares, 0, '.', ','); ?></td>
					  		<td><?php echo number_format($total_us_viewers, 2, '.', ','); ?></td>
					  		<td></td>
					  		<td><?php echo '$'.number_format($total_rev, 2, '.', ','); ?></td>
					  	
					  		<td><?php echo '$'.number_format($total, 2, '.', ','); ?></td>
					  	</tr>
					  </tfoot>
					</table>
					<?php }else{ ?>
					<table>
					  <thead>
					    <tr>
					      <th class="align-left" >Name</th>
					      <th class="bold">U.S. Views | 1K</th>
					      <th class="bold">Rate</th>
					      <th class="bold">Total-Month</th>
					      <th class="bold">Total To Pay</th>
  				       	  <th class="bold">Paid</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 

					  		$total = 0;
					  		$total_rate = 0;
					  		$total_us_viewers = 0;
					  		$total_us_viewers_by_thousands = 0;
					  		$all_us_viewers = 0;
					  		$all_us_viwers_by_thousand = 0;
					  		$all_total = 0;
					  		$all_total_to_pay = 0;

					  		foreach( $results as $contributor){
					  			$total_rate = $contributor['share_rate'];
					  			$total_us_viewers = $contributor["total_us_pageviews"];
					  			$total_us_viewers_by_thousands = $total_us_viewers / 1000;
					  			
								$no_cover_in_house = false;

					  			if( $contributor['user_type'] == '6' || $contributor['user_type'] == '1' || $contributor['user_type'] == '7' ){
							  		if( $selected_month > 2 && $selected_year >= 2015 ){
							  			 $total_rev = 0;
							  			 $total_to_pay  = 0;
  										 $no_cover_in_house = true;
							  		}else{
							  			$total_rev = $contributor['total_earnings'];
							  			$total_to_pay = $contributor['to_be_pay'];
							  		}
						  		}else{
						  			$total_rev = $contributor['total_earnings'];
						  			$total_to_pay = $contributor['to_be_pay'];
						  		}
						  		$paid = $contributor['paid'];
						  		$paid_cb = '';
						  		if($paid == 1){
						  			$paid_cb = 'checked=true';
						  		}

					  			$all_us_viewers += $total_us_viewers;
					  			$all_us_viwers_by_thousand += $total_us_viewers_by_thousands;
					  			$all_total += $total_rev; 
					  			$all_rate = $total_rate;
					  			$all_total_to_pay += $total_to_pay;

					  			$style = "background-color: #fff;";
					  			if( $contributor['user_type'] == 8){
					  				$style = "background-color: #E6FAFF";
					  			}elseif($month > 6 && $year >= 2015 ) { if($total_to_pay > 25 ) $style = "background-color: #FFFFCC;";}
					  			elseif($total_to_pay > 25 ) $style = "background-color: #FFFFCC;";
					  			

					  		?>	
					  		<?php if(!$no_cover_in_house ){?>
							<tr style="<?php echo $style; ?>">
							  	<td  class="align-left" id="contributor-id-<?php echo $contributor['contributor_id']; ?>">
							  		<a href="http://www.puckermob.com/admin/dashboard/contributor/<?php echo $contributor['contributor_seo_name'].'?month='.$selected_month.'&year='.$selected_year; ?>" target="blank">
							  			<?php echo $contributor['contributor_name']; ?><?php if($contributor['w9_live'] === '1') echo "<strong style='color:green;  margin-left: 5px;' >(W9 <i class='fa fa-check' style='margin-left:0; margin-right: 0;'></i>)</strong>"?>
							  		</a>
							  		<label>
							  		<?php echo $contributor['paypal_email'];?>
							  		
							  	</label>
							  	</td>
							  	<td><?php echo number_format($total_us_viewers_by_thousands, 2, '.', ','); ?></td>
							  	<td><?php echo '$'.$total_rate; ?></td>
							  	<td ><?php echo '$'.number_format($total_rev, 2, '.', ','); ?></td>
							  	<td class="bold"><?php echo '$'.number_format($total_to_pay, 2, '.', ','); ?></td>
							  	<td><input type="checkbox" id="input-<?php echo $contributor['contributor_id']; ?>" month-info="<?php echo $contributor['month']; ?>" year-info="<?php echo $contributor['year']; ?>" contributor-info="<?php echo $contributor['contributor_id']; ?>" <?php echo $paid_cb; ?> class="paid-checkbox" /></td>
							</tr>
					  	<?php  }  }?>
					  	
					  </tbody>
					  <tfoot>
					  	<tr>
					  		<td class="align-left bold">TOTAL:</td>
					  		<td><?php echo number_format($all_us_viwers_by_thousand, 2, '.', ','); ?></td>
					  		<td><?php echo '$'.$total_rate; ?></td>
					  		<td class=""><?php echo '$'.number_format($all_total, 2, '.', ','); ?></td>
					  		<td class="bold"><?php echo '$'.number_format($all_total_to_pay, 2, '.', ','); ?></td>
					  		<td></td>
					  		
					  	</tr>
					  </tfoot>
					</table>
					<?php }?>
				
				<?php }else{
					echo "<p>No records found!</p>";
				} ?>
			</section>
		</div>
	</main>
	<?php include_once($config['include_path_admin'].'footer.php');?>

	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
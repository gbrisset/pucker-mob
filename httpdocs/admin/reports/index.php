<?php 
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	//Verify if is a content provider user
	$content_provider = false;


	$userData = $adminController->user->data = $adminController->user->getUserInfo();

	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 3 || $adminController->user->data['user_type'] == 4){
		$content_provider = true;
	}

	if(!$adminController->user->checkPermission('user_permission_show_view_articles')) $adminController->redirectTo('noaccess/');

	$current_month = date('n');
	$current_year = date('Y');
	$selected_month = isset($_POST['month']) ? $_POST['month'] : $current_month;
	$selected_contributor = isset($_POST['contributor']) ? $_POST['contributor'] : 0;

	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			$results = $dashboard->socialMediaSharesReport($_POST);
			
		}else $adminController->redirectTo('logout/');
	}



?>

<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
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
						  	//if($current_year == 2014) $index = 10; 
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
						  		//if($current_year == $y) $selected  = 'selected'; else $selected = '';
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
										//var_dump($selected_contributor,  $contributorInfo['contributor_id']);
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
				<?php  if(isset($results) && $results ){?>
					
				<table>
				  <thead>
				    <tr>
				      <th>Contributor Name</th>
				      <th>Total Article Rate</th>
				      <th>Total Shares</th>
				      <th>Rate By Share</th>
				      <th>Share Rev</th>
				      <th class="bold">Total To Pay</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?php 
				  		$total = 0;
				  		$total_rate = 0;
				  		$total_shares = 0;
				  		$total_rev = 0;
				  		foreach( $results as $contributor){ 
				  		if( $contributor['total_to_pay'] == 0) continue;

				  		$contributor_type = isset($contributor['user_type']) ? $contributor['user_type'] : '4';
				  		
				  		if($contributor_type == 2 ){
				  		 $contributor['total_to_pay'] = $contributor['total_to_pay'] - $contributor['total_rate'];
				  		 $contributor['total_rate'] = 0;
				  		}

				  		$total = $total + $contributor['total_to_pay'];

				  		
				  						  		
				  		$total_rate = $total_rate + $contributor['total_rate'];
				  		$total_shares = $total_shares + $contributor['total_shares'];
				  		$total_rev = $total_rev + $contributor['share_revenue'];
				  	?>
				  	<tr>
					  	<td>
					  		<a href="http://www.puckermob.com/admin/dashboard/contributor/<?php echo $contributor['contributor_seo_name']; ?>" target="blank">
					  			<?php echo $contributor['contributor_name']; ?>
					  		</a>
					  	</td>
					  	<td><?php echo '$'.$contributor['total_rate']; ?></td>
					  	<td><?php echo $contributor['total_shares']; ?></td>
					  	<td><?php echo '$'.$contributor['share_rate']; ?></td>
					  	<td><?php echo '$'.$contributor['share_revenue']; ?></td>
					  	<td class="bold"><?php echo '$'.$contributor['total_to_pay']; ?></td>
					</tr>
					<?php }?>
					
				  </tbody>
				   <tfoot>
				  	<tr>
				  		<td class="bold">TOTAL:</td>
				  		<td><?php echo money_format('%(#10n', $total_rate);?></td>
				  		<td><?php echo $total_shares;?></td>
				  		<td></td>
				  		<td><?php echo money_format('%(#10n', $total_rev);?></td>
				  		
				  		<td><?php echo money_format('%(#10n', $total);?></td>
				  	</tr>
				  </tfoot>
				</table>
				
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
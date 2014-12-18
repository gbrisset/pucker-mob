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

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">

			<fieldset>
				<legend><h2>Social Media Shares </h2></legend>
				<section>
						<form id="social-media-shares-form" method="post">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

						<div class="center small-10 left">
							
						<label class="small-7 inline left"> 
						<div class="small-styled-select">Date:
					  	<select class="small-6" name='month' id="month-option" required>
					  		<option value='0'>Month</option>
						  	<?php 
						  	$index = 1;
						  	//if($current_year == 2014) $index = 10; 
						  	for($m = $index; $m <= $current_month; $m++){
						  		$dateObj   = DateTime::createFromFormat('!m', $m);
						  		$monthName = $dateObj->format('F');
						  		if($selected_month == $m) $selected  = 'selected'; else $selected = '';
						  		echo '<option value="'.$m.'" '.$selected.' >'.$monthName.'</option>';
							} ?>
						</select>
						</div>
						<div class="small-styled-select">
						<select class="small-3" name='year' id="year-option" required>
					  		<option value='0'>Year</option>
						  	<?php 
						  	$index = 2014;

						  	for($y = $index; $y <= $current_year; $y++){
						  		if($current_year == $y) $selected  = 'selected'; else $selected = '';
						  		echo '<option value="'.$y.'" '.$selected.' >'.$current_year.'</option>';
							} ?>
						</select>
						</div>
					</label>
						
					<label class="small-5 inline left">Contributor:
						<div class="small-styled-select">
						<select class="small-6" name='contributor' id="contributor-option" onchange = "">
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
				<div class="small-2 left">
					    <div class="columns">
						<div class="btn-wrapper">
							<button type="submit" id="submit" name="submit" class="radius">Search</button>
							
						</div>

					</div>
				</div>
				<div class="small-2 left">
					<a href="" id="export" name="export">Download File<i class="fa fa-download"></i></a>
				</div>
				
			</form>
			
			
				</section>
			</fieldset>

			<section id="dashboard" class="row">
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
				  		<td><?php echo '$'.$total_rate;?></td>
				  		<td><?php echo $total_shares;?></td>
				  		<td></td>
				  		<td><?php echo '$'.$total_rev;?></td>
				  		<td><?php echo '$'.$total;?></td>
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
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
				<legend>Social Media Shares</legend>
				<section>
						<form id="social-media-shares-form" method="post">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

						<div class="row">
						<label class="small-7 inline">Date: 
						
					  	<select name='month' id="month-option" required>
					  		<option value='0'>Month</option>
						  	<?php 
						  	$index = 1;
						  	//if($current_year == 2014) $index = 10; 
						  	for($m = $index; $m <= $current_month; $m++){
						  		$dateObj   = DateTime::createFromFormat('!m', $m);
						  		$monthName = $dateObj->format('F');
						  		if($current_month == $m) $selected  = 'selected'; else $selected = '';
						  		echo '<option value="'.$m.'" '.$selected.' >'.$monthName.'</option>';
							} ?>
						</select>
						<select name='year' id="year-option" required>
					  		<option value='0'>Year</option>
						  	<?php 
						  	$index = 2014;

						  	for($y = $index; $y <= $current_year; $y++){
						  		if($current_year == $y) $selected  = 'selected'; else $selected = '';
						  		echo '<option value="'.$y.'" '.$selected.' >'.$current_year.'</option>';
							} ?>
						</select>

					</label>
					<label class="small-5 inline">Contributor:
						<select name='contributor' id="contributor-option" onchange = "">
					  		<option value='0'>All</option>
						  	<?php 
						  	if(!$content_provider){
								$allContributors = $adminController->getSiteObjectAll(array('queryString' => 'SELECT * FROM article_contributors ORDER BY contributor_name ASC'));
								if($allContributors && count($allContributors)){
							
									foreach($allContributors as $contributorInfo){
										$option = '<option value="'.$contributorInfo['contributor_id'].'">';
										$option .= $contributorInfo['contributor_name'];
										$option .= '</option>';
										echo $option;
									}
								}
							}
							?>
						</select>
					</label>
				</div>
				<div class="row">
					    <div class="columns">
						<div class="btn-wrapper">
							<button type="submit" id="submit" name="submit" class="radius">Search</button>
						</div>
					</div>
				</div>
			</form>
			
				</section>
			</fieldset>

			<section id="dashboard" class="row">
				<?php var_dump($results);  if(isset($results) && $results ){
					foreach( $results as $contributor){ ?>
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
				  	<tr>
					  	<!--<td> <a>Cynthia Dite Sirni</a></td>
					  	<td>$10</td>
					  	<td>1698</td>
					  	<td>$0.04</td>
					  	<td>$67.92</td>
					  	<td class="bold">$77.92</td>-->
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

				  </tbody>
				</table>

					<?php }
				}?>
			</section>
		</div>
	</main>
	<?php include_once($config['include_path_admin'].'footer.php');?>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
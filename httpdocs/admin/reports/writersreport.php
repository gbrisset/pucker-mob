<?php 
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	if(isset($pro_admin) && !$pro_admin) $mpShared->get404();
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	$current_month = date('m'); 
	$current_year = date('Y');
	$start_date = $current_year.'-'.$current_month.'-01';
	$end_date = $current_year.'-'.$current_month.'-31';

	$dataInfo = ['start_date' => $start_date, 'end_date' => $end_date];
	$results = $adminController->user->getContributorEarningsData( $dataInfo );

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
		<h1 class="left">View writers report</h1>
	</div>
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up  hide">
		<h1 class="left">View writers report</h1>	
	</section>
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<!-- LEFT SIDE MENU -->
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11 margin-top">
			<section>
				<h2 class="small-7">Get Report for In-House writers.</h2>
				<div class="small-5 right">
						<div id="reportrange" class="pull-right">
						    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
						    <input type="text" name="daterange" value="" />
						</div>
					</div>
			</section>
			<section id="dashboard">
				<header style="margin-top:0.2rem;">Earnings per writer
					<div class="right" style="text-align: right;">
				</header>
			</section>
				
			<section id="dashboard" class="clear">
				<?php  if(isset($results) && $results ){ ?>
					<table>
					  <thead>
					    <tr>
					      <th class="bold align-left" >Name</th>
					      <th class="bold">New Articles</th>
					      <th class="bold">Rate</th>
					      <th class="bold">U.S. Traffic | 1k</th>
					      <th class="bold">U.S. Traffic Rev.</th>
					      <th class="bold align-right">Total</th>
					    </tr>
					  </thead>
					  <tbody id="writers-tbody">
					  		<?php 
					  			$total_articles = 0; $total_per_article = 0; $total_cpm = 0; $total_pageviews = 0; $total_rev = 0;
					  			foreach($results as $contributor ){
						  			$total_article_rev = $contributor['article_rate'];
						  			$total_CPM_earned = 0;

						  			$user_type = $contributor['user_type'];
						  			$rate = $dashboard->get_current_rate( $current_month , $user_type, $year = 0 );

						  			if($rate) $rate = $rate['rate']; else $rate = 0.45;

						  			$pageviews = $contributor['pageviews']['us_pageviews'];
						  			if($pageviews > 0){
						  				$pageviews = $pageviews / 1000;
						  				$total_CPM_earned = ($pageviews ) * $rate;
						  			}
						  			$total =  ($total_CPM_earned);
						  			$total_articles += $contributor['total_articles'];
						  			$total_per_article += $total_article_rev;
						  			$total_pageviews += $pageviews;
						  			$total_cpm  += $total_CPM_earned;
						  			$total_rev += $total;
						  			

						  			$styling = '';
									if($total < 0 ) $styling = 'style="color: red;"'
					  		?>
					  		<tr id="contributor-id-<?php echo $contributor['contributor_id']; ?>">
						  		<td class=" align-left" ><?php echo $contributor['contributor_name']; ?></td>
						  		<td><?php echo $contributor['total_articles']; ?></td>
						  		<td><?php echo '$'.number_format($rate, 2, '.', ','); ?></td>
						  		<td><?php echo number_format($pageviews, 0, '.', ','); ?></td>
						  		<td><?php echo '$'.number_format($total_CPM_earned, 2, '.', ','); ?></td>
						  		<td class="align-right" <?php echo $styling; ?>><?php echo '$'.number_format($total, 2, '.', ','); ?></td>
					  		</tr>
					  		<?php } ?>
					
					  	<tr style="background-color: #E6FAFF">
					  		<td class="bold align-left">TOTAL:</td>
					  		<td><?php echo $total_articles; ?></td>
					  		<td>----</td>
					  		<td><?php echo number_format($total_pageviews, 0, '.', ','); ?></td>
					  		<td><?php echo '$'.number_format($total_cpm, 2, '.', ','); ?></td>
					  		<td class="align-right"><?php echo '$'.number_format($total_rev, 2, '.', ','); ?></td>
					  		
					  	</tr>
					   </tbody>
					</table>
									
				<?php }else{
					echo "<p>No records found!</p>";
				} ?>
			</section>
		</div>
	</main>
	<?php //include_once($config['include_path_admin'].'footer.php');?>

	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
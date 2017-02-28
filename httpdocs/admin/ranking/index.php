<?php 
	$admin = true; 
	require_once('../../assets/php/config.php');
	
	$ManageDashboard = new ManageAdminDashboard( $config );
	
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	 $current_month = date('n');
	 $current_year = date('Y');

	 $contributor_id = $userData['contributor_id'];
 	
 	$rank = '9999';
	$rank_data= $ManageDashboard->getTopShareWritesRankHeader( $current_month, $current_year);
	 if(isset($rank_data) && $rank_data ){
		 foreach($rank_data as $rank_pw){
		 	if($contributor_id === $rank_pw['contributor_id']){
		 		$rank = $rank_pw['rownum'];
		 	}
		 }
	 }

// TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST 
echo "<br/>userData";
echo "<pre>";
print_r($rank_data);
echo "</pre>";
// TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST 

	//GET RANK POSITION FOR CURRENT USER.
	$limit = 40;
	if($detect->isMobile()){
		$limit = 30;
	}
	 $rank_list = $ManageDashboard->getTopShareWritesRank( date('Y'), date('n'), $limit, "30, 3 , 8");
	
// TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST 
// echo "<br/>rank_list";
// echo "<pre>";
// print_r($rank_list);
// echo "</pre>";
// TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST TEST


 ?>

<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body id="ranking">
	<input type="hidden" value="<?php echo $contributor_id; ?>" id="contributor_id"/>
	
	<?php include_once($config['include_path_admin'].'header.php');?>
	
	<main id="main-cont" class="row panel sidebar-on-right" role="main">

		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<div class="small-12 columns padding-bottom ">
				<h1>Ranking &amp; Incentives</h1>
			</div>

			<input type="hidden" value="<?php //echo $rate['rate']; ?>" id="current-user-rate" />

			<?php include_once($config['include_path_admin'].'view_ranking.php');?>

			
			<div class="small-12 large-10 xxlarge-8 columns no-padding-right">
				<p class="small-12 columns no-padding hide-for-large-up">
					View your rank compared to other bloggers in our community, and check to see our latest incentive plan.
				</p>
				<div class="small-12 columns no-padding hide-for-large-up radius mobile-ranking-div margin-bottom" >
					<h2 class="bold">TOP BLOGGERS (THIS MONTH)</h2>
				</div>
				<?php include_once($config['include_path_admin'].'rank_authors_list.php'); ?>

			</div>
			<!-- Right Side -->
			<div class="small-12 xxlarge-4 right padding rightside-padding  show-for-large-up" >
				<?php include_once($config['include_path_admin'].'incentives.php'); ?>
			</div>

		</div>

	</main>

	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>

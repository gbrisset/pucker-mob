<?php 
	$admin = true; 
	require_once('../../../assets/php/config.php');

	$userData = $adminController->user->data = $adminController->user->getUserInfo();
	$email = isset($userData['contributor_email_address']) ? $userData['contributor_email_address'] : 'none';
	$contributor_id = $userData['contributor_id'];
	$user_id = $userData['user_id'];
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

	$ManageDashboard = new ManageAdminDashboard( $config );
	$contributorObj = new Contributor( );
	$adMatching = new AdMatching(); //AD Matching Object
	$OrderObj = new OrderAds(); //ORDER OBJECT

	//GET ALL FOR CURRENT MONTH
	$month = date('n');
	$year = date('Y');

	//GET ORDERS
	$orders = $OrderObj->all();
?>

<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body id="cpanel-admatching">
	
	<!-- HEADER -->	
	<?php include_once($config['include_path_admin'].'header.php');?>
	
	<!-- MAIN CONTENT -->
	<main id="main-cont" class="row panel sidebar-on-right" role="main">

		<!-- MENU -->
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<div class="small-12 columns padding-bottom ">
				<h1>AD Matching</h1>
			</div>

			<!-- ARTICLES RESUME INFO --> 
			<?php include_once($config['include_path_admin'].'view_dashboard_resume.php'); ?>

			
			<div class="small-12 xxlarge-8 columns no-padding-right padding-top">
				<?php if(isset($orders) && $orders ){?>
				<table>
					<thead>
						<tr>
							<td>DATE</td>
							<td>NAME</td>
							<td>EMAIL</td>
							<td>PKG</td>
							<td>TOTAL</td>
							<td>RECEIPT</td>
							<td>SPENT</td>
							<td>DATE</td>
							<td>BALANCE</td>
						</tr>
					</thead>
					<tbody>
						<?php foreach($orders as $order){
							$contributorInfo = $contributorObj->getContributorById($order->contributor_id);
							$date = date("n/d/Y", strtotime($order->date));
							$pkg = $order->bonus_pct;
							$total = $order->total_commit;
						?>
						<tr>
							<td><?php echo $date; ?></td>
							<td><?php echo $contributorInfo->contributor_name; ?></td>
							<td><?php echo $contributorInfo->contributor_email_address; ?></td>
							<td><?php echo $pkg.'%'; ?></td>
							<td><?php echo '$'.number_format( $total, 2); ?></td>
							<td><a href="">Articles</a></td>
							<td>RECEIPT</td>
							<td>SPENT</td>
							<td>DATE</td>
							<td>BALANCE</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php }else{
					echo "<p>NO ORDERS AVAILABLE.</p>";
				}?>
			</div>

			<!-- Right Side -->
			<div class="small-12 xxlarge-4 right padding rightside-padding" >
			
			</div>

		</div>

	</main>

	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>




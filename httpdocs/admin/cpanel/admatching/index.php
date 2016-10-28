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
	$AdMatchingTransactions = new AdMatchingTransactions();


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

			
			<div class="small-12 columns padding-top">
				<?php if(isset($orders) && $orders ){?>
				<table class="small-12 columns">
					<thead>
						<tr>
							<td>DATE</td>
							<td>NAME</td>
							<td>EMAIL</td>
							<td>PKG</td>
							<td>COMMIT</td>
							<td>SPENT</td>
							<td>BALANCE</td>
							<td></td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<?php foreach($orders as $order){
							$contributorInfo = $contributorObj->getContributorById($order->contributor_id);
							$transactions = $AdMatchingTransactions->where(' contributor_id = '.$order->contributor_id.' ORDER BY id DESC LIMIT 1');

							$spent = ( $transactions && isset($transactions[0]) ) ? $transactions[0]->balance : 0;
							$date = date("n/d/Y", strtotime($order->date));
							$pkg = $order->bonus_pct;
							$total = $order->total_commit;
 
							if($spent > 0 ){
								$spent = $total - $spent;
							}
							$balance = $total - $spent;
							$link = 'http://www.puckermob.com/admin/profile/user/'.$contributorInfo->contributor_seo_name;
						?>
						<tr>
							<td><?php echo $date; ?></td>
							<td><?php echo $contributorInfo->contributor_name; ?></td>
							<td><?php echo $contributorInfo->contributor_email_address; ?></td>
							<td><?php echo $pkg.'%'; ?></td>
							<td><?php echo '$'.number_format( $total, 2); ?></td>
							<td><?php echo '$'.number_format( $spent, 2); ?></td>
							<td><?php echo '$'.number_format( $balance, 2); ?></td>
							<td><a href="<?php echo $link; ?>" style="text-transform: uppercase; color: #777;">Articles</a></td>
							<td><a href="#" style="text-transform: uppercase; color: #777;" id="history-link" data-info-id = "<?php echo $order->contributor_id; ?> " data-info-total-balance = "<?php echo $total; ?>" data-reveal-id="history-modal">History</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php }else{
					echo "<p>NO ORDERS AVAILABLE.</p>";
				}?>
			</div>

			<!-- Right Side 
			<div class="small-12 xxlarge-4 right padding rightside-padding" >
			
			</div>-->

		</div>

	</main>
	<?php include_once($config['include_path_admin'].'history.php');?>

	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
							
</body>
</html>




<?php 

//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
		// error_reporting(E_ALL); 	ini_set('display_errors', '1');

//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------


	$admin = true; 
	require_once('../../assets/php/config.php');
	$ManageDashboard = new ManageAdminDashboard( $config );

	
	$userData = $adminController->user->data = $adminController->user->getUserInfo();

	$contributorInfo = $mpArticle->getContributorInfo( $uri[1] );
		 // $ddd = new debug($userData,1); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	
		 // $ddd = new debug($contributorInfo,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

	//If the contributor exists and has an id, check to see if this user has permissions to edit this contributor...
	if (isset($contributorInfo['contributor_id'])){
		if ( !($adminController->user->checkUserCanEditOthers('contributor', $userData['contributor_email_address'])) && $contributorInfo['contributor_email_address'] !== $userData['contributor_email_address']  ) $adminController->redirectTo('noaccess/');
	} else $mpShared->get404();

	if(empty($contributorInfo)) $mpShared->get404();
	
	// 2. records per page ($per_page)
	$per_page = 30;
	$limit=30;
	$post_date = 'all';
	$articleStatus = '1, 2, 3';
	$order = '';
	$filterLabel = 'Most Recent';
	$userArticlesFilter = $userData['user_email'];
		
	if (isset($_GET['post_date']) AND $_GET['post_date'] != "all" ) {$post_date = $_GET['post_date'];}				  
	if (isset($_GET['visible'])) {$visible = intval($_GET['visible']);}

// 3. total record count ($total_count)	
	$total_count = ($mpArticle->countFiltered($order, $articleStatus, $userArticlesFilter));
	$pagination = new Pagination(1, $per_page, $total_count);
	$offset = $pagination->offset();
	$current_month = date('m');
	$current_year = date('Y');
	
	$month = isset($_POST['month']) ? $_POST['month'] : $current_month;
	$year = isset($_POST['year']) ? $_POST['year'] : $current_year;

	$contributor_name = $contributorInfo["contributor_name"];
	$contributor_id = $contributorInfo["contributor_id"];
	$contributor_email = $contributorInfo["contributor_email_address"]; 
	$contributor_type = $mpArticle->getContributorUserType($contributor_email);

	
	//if(isset($_GET['show']) && $_GET['show'] == true){
			$user_info = new User($contributor_email);
			$contributor = $user_info->contributor;
			$contributor_earnings = new ContributorEarnings( $contributor );
		//	$rate = $contributor_earnings->getRate( 6, 2016, $user_type )
			// var_dump($contributor_earnings); die;

	//}

	$newCalc = true;
	if( $year < 2015 || ( $year == 2015 && $month <= 2)){
		$articles = $dashboard->get_dashboardArticles($limit, $order, $articleStatus, $userArticlesFilter, $offset, $month, $year);
		$dateupdated = $dashboard->get_dateUpdated($limit, $order, $articleStatus, $userArticlesFilter, $offset, $month, $year);
		$newCalc = false;
	}else{
		if( $year == 2015 && $month <= 6){
			$articles = $dashboard->get_articlesbypageviews_new($contributor_id, $month, $year);
		}else{
			$start_date = date_format(date_create($year.'-'.$month.'-01'), 'Y-m-d');
			$end_date =   date_format(date_create($year.'-'.$month.'-31'), 'Y-m-d');
			$data = ['contributor_id' => $contributor_id, 'start_date' => $start_date, 'end_date' => $end_date];
			$articles = $adminController->user->getContributorEarningChartArticleData($data);
			$dateupdated = $dashboard->get_dateUpdated($limit, $order, $articleStatus, $userArticlesFilter, $offset, $month, $year);

		}
	}

	$user_type = $userData['user_type'];
	$user_rate = $dashboard->smf_get_user_rate($user_type, $current_month, $current_year );
	if($user_rate) $current_user_rate = $user_rate['user_rate'];
	 // $ddd = new debug($user_rate,0); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	
	$total = 0;

	$last_month = $current_month-1;
	$last_year = $current_year;
	if($current_month == 1){ $last_month = 12; $last_year = $current_year - 1;}//end if
	
	$show_art_rate = false;
	//if($year == 2014 || $year == 2015 && $month < 2) $show_art_rate = true;

	$user_type = $contributor_type; 
	$earnings = $ManageDashboard->smf_getContributorEarningsInfo(  $contributor_id );
	$current_earnings = isset($earnings['total_earnings']) ? $earnings['total_earnings'] : 0;
	$best_article = $ManageDashboard->get_bestArticle($contributor_id,  date('n'), date('Y'));

	if(isset($_GET['show']) && $_GET['show'] == true){ var_dump($contributor_earnings, $user_type, $earnings, $current_earnings); }
?>
<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body id="earnings">
	<input type="hidden" value="<?php echo $contributor_id; ?>" id="contributor_id"/>
	<input type="hidden" value="<?php echo $user_type; ?>" id="user_type" />
	<?php include_once($config['include_path_admin'].'header.php');?>
	
	<main id="main-cont" class="row panel sidebar-on-right" role="main">

		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<div class="small-12 columns padding-bottom ">
				<h1>Earnings &amp; Analytics</h1>
			</div>
			
			<input type="hidden" value="<?php echo $current_user_rate; ?>" id="current-user-rate" />
			<input type="hidden" value="<?php echo $user_type; ?>" id="current-user-type" />


			<!-- ARTICLES RESUME INFO --> 
			<?php include_once($config['include_path_admin'].'view_dashboard_resume.php'); ?>

			<!-- Calendar -->
			<?php // include_once($config['include_path_admin'].'calendar.php'); ?>

			
			<!-- CHARTS --> 
			<div class="small-12 xxlarge-9 columns chart_wrapper_div">
				<?php  include_once($config['include_path_admin'].'charts.php'); ?>

				<div id="earnings-list" class="small-12 columns no-padding margin-top">
				
	
<?php 
				$pre_results = $dashboard->smf_getBloggersEarningsReport($contributor_id);


if (is_array($pre_results[0])) {$results = $pre_results;} else {$results[0] = $pre_results ;}//end if

				if(isset($results) && $results ){ 

					echo "
					<table class=\"small-12 columns no-padding\" id=\"daily-earnings\">
						<thead>
							<tr>
								<td style=\" color: #333;\" class=\"align-left\">Month</td>
								<td style=\" color: #333;\" class=\"align-left\">Year</td>
								<td style=\" color: #333;\" class=\"align-center\">Paid</td>
								<td style=\" color: #333;\" class=\"align-right\">US. PageViews</td>
								<td style=\" color: #333;\" class=\"align-right\">CPM Rate</td>
								<td style=\" color: #333;\" class=\"align-right\">Earnings</td>
							</tr>
						</thead>
						<tbody>

					";


					foreach( $results as $monthly_earnings){


							$monthname = $monthly_earnings['monthname'];
							$year = $monthly_earnings['year'];
							$total_us_pageviews = number_format($monthly_earnings['total_us_pageviews'] );
							$share_rate = "$". number_format( $monthly_earnings['share_rate'], 2);
							$total_earnings = "$". number_format( $monthly_earnings['total_earnings'], 2);

							if($monthly_earnings['payday_date']==0){
								$payday_date = "No";
							}else{
								$payday_date = date("M j, Y", strtotime($monthly_earnings['payday_date']));
							}//end if

							echo"
								<tr>
									<td class=\"align-left\">$monthname</td>
									<td class=\"align-left\">$year</td>
									<td class=\"align-center\">$payday_date</td>
									<td class=\"align-right\">$total_us_pageviews</td>
									<td class=\"align-right\">$share_rate</td>
									<td class=\"align-right\">$total_earnings</td>
								</tr>
							";
								  		
					}//end foreach

						echo"<tr><td colspan=\"6\" >&nbsp;</td></tr> ";


				// max, average, min of pageviews, cpm, earnings
				// ---------------------------------------------------------------------------------------------------			
				$results = $dashboard->smf_getBloggersEarningsReportSummary_1($contributor_id);


							$sum_pgv = number_format($results['sum_pgv'] );
							$max_pgv = number_format($results['max_pgv'] );
							$avg_pgv = number_format($results['avg_pgv'] );
							$min_pgv = number_format($results['min_pgv'] );

							$max_cpm = "$". number_format($results['max_cpm'], 2);
							$avg_cpm = "$". number_format($results['avg_cpm'], 2);
							$min_cpm = "$". number_format($results['min_cpm'], 2);

							$sum_earnings = "$". number_format($results['sum_earnings'], 2);
							$max_earnings = "$". number_format($results['max_earnings'], 2);
							$avg_earnings = "$". number_format($results['avg_earnings'], 2);
							$min_earnings = "$". number_format($results['min_earnings'], 2);

							echo "	
							<tr>
								<td style=\" color: #333;\" class=\"align-left\">&nbsp;</td>
								<td style=\" color: #333;\" class=\"align-left\">&nbsp;</td>
								<td style=\" color: #333;\" class=\"align-center\">&nbsp;</td>
								<td style=\" color: #333;\" class=\"align-right\">US. PageViews</td>
								<td style=\" color: #333;\" class=\"align-right\">CPM Rate</td>
								<td style=\" color: #333;\" class=\"align-right\">Earnings</td>
							</tr>
							";						
							echo"
								<tr>
									<td style=\" color: #333;\"  class=\"align-left\">All Times</td>
									<td class=\"align-left\">&nbsp;</td>
									<td class=\"align-center\">&nbsp;</td>
									<td class=\"align-right\">$sum_pgv</td>
									<td class=\"align-right\">N/A</td>
									<td class=\"align-right\">$sum_earnings</td>
								</tr>
							";
							echo"
								<tr>
									<td style=\" color: #333;\"  class=\"align-left\">Max</td>
									<td class=\"align-left\">&nbsp;</td>
									<td class=\"align-center\">&nbsp;</td>
									<td class=\"align-right\">$max_pgv</td>
									<td class=\"align-right\">$max_cpm</td>
									<td class=\"align-right\">$max_earnings</td>
								</tr>
							";
							echo"
								<tr>
									<td style=\" color: #333;\"  class=\"align-left\">Avg</td>
									<td class=\"align-left\">&nbsp;</td>
									<td class=\"align-center\">&nbsp;</td>
									<td class=\"align-right\">$avg_pgv</td>
									<td class=\"align-right\">$avg_cpm</td>
									<td class=\"align-right\">$avg_earnings</td>
								</tr>
							";
							// echo"
							// 	<tr>
							// 		<td style=\" color: #333;\"  class=\"align-left\">Min</td>
							// 		<td class=\"align-left\">&nbsp;</td>
							// 		<td class=\"align-center\">&nbsp;</td>
							// 		<td class=\"align-right\">$min_pgv</td>
							// 		<td class=\"align-right\">$min_cpm</td>
							// 		<td class=\"align-right\">$min_earnings</td>
							// 	</tr>
							// ";


							echo"<tr><td colspan=\"6\" >&nbsp;</td></tr> ";

				// Header for the next two sections
				// ---------------------------------------------------------------------------------------------------			


							echo "	
							<tr>
								<td style=\" color: #333;\" class=\"align-left\">&nbsp;</td>
								<td style=\" color: #333;\" class=\"align-left\">&nbsp;</td>
								<td style=\" color: #333;\" class=\"align-center\">Date</td>
								<td style=\" color: #333;\" class=\"align-right\">&nbsp;</td>
								<td style=\" color: #333;\" class=\"align-right\">&nbsp;</td>
								<td style=\" color: #333;\" class=\"align-right\">Earnings</td>
							</tr>
							";

				// list past payments and amount paid
				// ---------------------------------------------------------------------------------------------------			

				$payments = $dashboard->smf_getBloggersEarningsReportSummary_2($contributor_id);
					if ($payments){

						foreach( $payments as $payment){
								$earnings_tally = "$". number_format( $payment['earnings_tally'], 2);
								if($payment['payday_date']==0){
									$earning_owed_todate = $earnings_tally;//will be used in next section
								}else{
									$paid = "Paid";
									$payday_date = date("M j, Y", strtotime($payment['payday_date']));

								// Pay history is temporarily on hold - 2017-04-07 - GB
								// echo"
								// 	<tr>
								// 		<td colspan=\"2\" style=\" color: #333;\"  class=\"align-left\">Past payment</td>

								// 		<td class=\"align-center\">$payday_date</td>
								// 		<td colspan=\"2\" class=\"align-center\">(Ad Matching &amp; Incentives Not included)</td>

								// 		<td class=\"align-right\">$earnings_tally</td>
								// 	</tr>
								// ";
								 }//end if
								  		
						}//end foreach

					}//end if  ($payments)

				// next payment
				// ---------------------------------------------------------------------------------------------------			
				$next_payday = $dashboard->smf_getBloggersEarningsReportSummary_3($contributor_id);
					if ($next_payday){
							$earnings_tally = "$". number_format( $next_payday['earnings_tally'], 2);
							$current_date = date("M j, Y");
							$next_paydate = date("M j, Y", strtotime($next_payday['next_paydate']));
							echo"
								<tr>
									<td colspan=\"2\" style=\" color: #333;\"  class=\"align-left\">Next Pay date</td>
									
									<td class=\"align-center\">$next_paydate</td>
									<td colspan=\"2\" class=\"align-center\">(Tentative Date - Estimated Amount)</td>

									<td class=\"align-right\">$earnings_tally</td>
								</tr>
							";
							if($next_payday['earnings_tally']<50){
								$earnings_msg = "Please remember - earnings below \$25 will be rolled over to the next pay cycle";
							}else{
								$earnings_msg = "Please remember - You must submit a W9 form and Paypal information to be part of this pay cycle";
							} //end if($next_payday['earnings_tally']<25)
							$earnings_msg .= "<br/><br/>Earnings currently DO NOT reflect Incentive Rewards or AdMatching Commitments ";
								echo"
									<tr>
										<td colspan=\"6\" style=\" color: #c43333;\"  class=\"align-center\">$earnings_msg</td>
									</tr>
								";

							// echo"
							// 	<tr>
							// 		<td colspan=\"2\" style=\" color: #333;\"  class=\"align-left\">Earnings as of</td>
									
							// 		<td class=\"align-center\">$current_date</td>
							// 		<td colspan=\"2\" class=\"align-center\">(Today - Estimated Amount)</td>

							// 		<td class=\"align-right\">$earning_owed_todate</td>
							// 	</tr>
							// ";
						
					}//end if ($next_payday)


				// closing body and table
				// ---------------------------------------------------------------------------------------------------			
							echo "
									</tbody>
									</table>
							";				
				}else{
					echo "
					<table class=\"small-12 columns no-padding\" id=\"daily-earnings\">
						<thead>
							<tr>
								<td style=\" color: #333;\" class=\"align-center\">No earnings to show as of yet.</td>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>

					";


				}//end if(isset($results) && $results )
				?>


				</div>

			</div>

		

			<!-- Right Side -->
			<div class="small-12 xxlarge-3 right padding rightside-padding" >
				<?php include_once($config['include_path_admin'].'earnings_info.php'); ?>
			</div>
			<div class="small-12 xxlarge-3 right padding rightside-padding" >
				<?php include_once($config['include_path_admin'].'payment_options.php'); ?>
			</div>

		</div>

	</main>

	<!-- INFO BADGE -->
	<div id="info-badge" class="footer-position bg-black hide-for-print show-for-small-only">
		<?php include($config['include_path_admin'].'info-badge.php');?>
	</div>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>

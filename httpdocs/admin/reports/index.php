<?php 



	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');


//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
		// error_reporting(E_ALL); 	ini_set('display_errors', '1');

//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------

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
	

	 
	 // $ddd = new debug($_POST,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	

	//$new_cal = false;
	//if( $selected_year == 2015 && $selected_month  > 2 ) $new_cal = true;
	//if( $selected_year > 2015) $new_cal = true;

	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!

			//TRAFFIC & EARNINGS INFO
			// $results = $dashboard->getPageViewsUSReport($_POST); // Legacy code //OBSOLETE -- DELETE AFTER MAY 31 2017
			$results = $dashboard->smf_getPageViewsUSReport($_POST);
			// $results_tobepay = $dashboard->smf_getPageViewsUSReport_tobepay($_POST); NO LONGER NEEDED - GB 2017-04-24 //OBSOLETE -- DELETE AFTER MAY 31 2017


/*

			// ***************************************************************
			// ***************************************************************
			// ***************************************************************
			// ***************************************************************

			// ad matching  - ranking - incentives will be re instated later in time - GB 2017-04-25			

			LEGACY CODE - UNUSED AS OF 2017-04-14			
			//AD MATCH INFO
			$OrderObj = new OrderAds(); //ORDER OBJECT
			$adMatchInfo = $OrderObj->where(" month_relation = $selected_month AND year_relation = $selected_year ");

			//INDCENTIVES
			$incentives = new Incentives();
			$incentives_month = $incentives->where(" month = $selected_month AND year = $selected_year  AND bonus != '$0' " );
			//$incentives_month = $incentives->where(' month = 9 AND year = 2016 AND bonus != "$0" ' );

			//GET RANK LIST INFORMATION
			$ManageDashboard = new ManageAdminDashboard( $config );
			$rank_list = $ManageDashboard->getTopShareWritesRankWithIncentives( $selected_month, $incentives_month);

			// ***************************************************************
			// ***************************************************************
			// ***************************************************************
			// ***************************************************************
*/
		}else $adminController->redirectTo('logout/');
	}
?>

<!DOCTYPE html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>

<body id="reports">
	<!-- HEADER -->	
	<?php include_once($config['include_path_admin'].'header.php');?>
	
	<!-- MAIN CONTENT -->
	<main id="main-cont" class="row panel sidebar-on-right" role="main">

		<!-- MENU -->
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			
			<div class="small-12 columns padding-bottom ">
				<h1>BLOGGER EARNINGS REPORT</h1>
			</div>

			<div class="columns small-12 margin-top">
				<form id="social-media-shares-form" method="post">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

					<div class="row">
					    <div class="small-6 columns">
					      <div class="row">
					        <div class="small-2 columns">
					          <label for="right-label" class="half-padding-top">Date:</label>
					        </div>
					        <div class="small-5 columns">
					         	<select  name='month' id="month-option" required style="background-position: 90% 60%">
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
					        <div class="small-4 columns">
					         	<select  name='year' id="year-option" required style="background-position: 90% 60%">
							  		<option value='0'>Year</option>
								  	<?php 
								  	$index = 2015;
								  	for($y = $index; $y <= $current_year; $y++){
								  		if($selected_year == $y) $selected  = 'selected'; else $selected = '';
								  		echo '<option value="'.$y.'" '.$selected.' >'.$y.'</option>';
									} ?>
								</select>
					         </div>
					      </div>
					    </div>
				 
					    <div class="small-6 columns">
					      <div class="row">
					        <div class="small-3 columns">
					          <label for="right-label" class="align-right half-padding-top">Contributors:</label>
					        </div>
					        <div class="small-9 columns">
					         	<div class="small-7 columns">
						       		<select class="small-12 columns" name='contributor' id="contributor-option" onchange = "">
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
						       	<div class="small-5 columns">
						       		<button type="submit" id="submit" name="submit" style="padding: 0.5rem 1rem;text-transform: uppercase; margin-right: 1rem;">Search</button>
						       	</div>
					        </div>
					      </div>
					    </div>
				    </div>

					
				</form>
			</div>
			
			<div id="reports-div" class="columns small-12">
				<?php  if(isset($results) && $results ){ 

					$report_month = date("M", mktime(0,0,0, $_POST['month'], 1, $_POST['year'])) . " " . $_POST['year']; 
				

				echo "
					<table class=\"small-12 columns no-padding\" id=\"daily-earnings\">
						<thead>
							<tr>
								<td style=\" color: #333;\" class=\"align-left\">Name<br/>PP Email</td>
								<td style=\" color: #333;\" class=\"align-center\">W9</td>
								<td style=\" color: #333;\" class=\"align-right\">U.S Views</td>
								<td style=\" color: #333;\" class=\"align-right\">Rate</td>

								<td style=\" color: #333;\" class=\"align-right\">$report_month<br/>Earnings</td>
								<td style=\" color: #333;\" class=\"align-right\">Incentives</td>
								<td style=\" color: #333;\" class=\"align-right\">Ad Match</td>
								<td style=\" color: #333;\" class=\"align-right\">Adjusted<br/>Earnings</td>
								
								<td style=\" color: #333;\" class=\"align-right\">Rollover</td>
								<td style=\" color: #333;\" class=\"align-right\">To Pay</td>
								<td style=\" color: #333;\" class=\"align-center\">Paid</td>
							</tr>
						</thead>
						<tbody>

					";

				$tally_pviews_all = 0; 
				$tally_earnings_all = 0; 
				$tally_rollover_all = 0; 
				$tally_tbp_all = 0; 

				$tally_pviews_pro = 0; 
				$tally_earnings_pro = 0; 
				$tally_rollover_pro = 0; 
				$tally_tbp_pro = 0; 

				$tally_pviews_community = 0; 
				$tally_earnings_community = 0; 
				$tally_rollover_community = 0; 
				$tally_tbp_community = 0; 

				$tally_pviews_starter = 0; 
				$tally_earnings_starter = 0; 
				$tally_rollover_starter = 0; 
				$tally_tbp_starter = 0; 

			  	 foreach( $results as $contributor){

			  		// // Fix the to_be _pay field //OBSOLETE -- DELETE AFTER MAY 31 2017
				  	// 	foreach( $results_tobepay as $to_be_pay_set){
				  	// 		if ($to_be_pay_set['contributor_id'] == $contributor['contributor_id']){
				  	// 			$contributor['to_be_pay'] = $to_be_pay_set['to_be_pay_fixed'];
				  	// 			break;
				  	// 		}//end if
				  	// 	}//end foreach( $results_tobepay ...//OBSOLETE -- DELETE AFTER MAY 31 2017


				 // $ddd = new debug($contributor,3); $ddd->show();// 0- green; 1-red; 2-grey; 3-yellow	



		  				

						// ***************************************************************
						// ***************************************************************
						// ***************************************************************
						// ***************************************************************
						// ad matching  - ranking - incentives will be re instated later in time - GB 2017-04-25			

						// LEGACY CODE - UNUSED AS OF 2017-04-14
						//AD MATCHING
						// if($adMatchInfo){
						// 	foreach($adMatchInfo as $match){
						// 		if($match->contributor_id == $contributor['contributor_id']){
						// 			$adMatchBalance = $match->amount_commit;
						// 			break;
						// 		}
						// 	}
						// }
						// //RANKLIST
						// if($rank_list){ 
						// 	foreach($rank_list as $key => $val ){
						// 		if($key == $contributor['contributor_id']){
						// 			if (strpos($val, '$') !== false) {
						// 				$incentives = substr($val, 1);
						// 				break;
						// 			}
						// 		}
						// 	}
						// }// end if($rank_list)


						// ***************************************************************
						// ***************************************************************
						// ***************************************************************
						// ***************************************************************



			  			if($contributor['to_be_pay_fixed']  < 25) continue;
			  			$blg_user_type = $contributor['user_type'];
						
						$blogger = false;
						switch ($blg_user_type) {
							case '8':
							case '3':
							case '30':
								$blogger = true;
								break;
							
							default:
							// Do nothing
						}//end switch ($blg_user_type)




						if($blogger){
							//----------------------------------
							$blg_id = $contributor['contributor_id'];
							$blg_ppemail = ($contributor['paypal_email']=="")? "No PP email" : $contributor['paypal_email'];
							$blg_name = "<a href=\"http://www.puckermob.com/admin/earnings/" . $contributor['contributor_seo_name'] . "\" target=\"blank\">" . $contributor['contributor_name'] . "</a><br/>$blg_ppemail" ;

							$blg_w9 = ($contributor['w9_live'] >0 )? "<i class='fa fa-check' style='margin-left:0; margin-right: 0; color:green;'></i>" :  "&mdash;" ;
							$blg_pviews = number_format($contributor["total_us_pageviews"], 0, '.', ',');
							$blg_rate = '$'. number_format($contributor['share_rate'], 2, '.', ',');

							//----------------------------------
							$blg_earnings_thismonth = $contributor['total_earnings'];
							$blg_incentives = 0;// actual values are not fetch as of now - GB 2017-04-25
							$blg_admatch = 0;// actual values are not fetch as of now - GB 2017-04-25
							$blg_earnings_thismonth_adj = $blg_earnings_thismonth - $blg_admatch + $blg_incentives;

							$blg_traffic = '$'.number_format($blg_earnings_thismonth, 2, '.', ',');
							$blg_incentives = '$'.number_format(0, 2, '.', ','); 
							$blg_admatch = '-$'.number_format(0, 2, '.', ',');
							$blg_total = '$'.number_format($blg_earnings_thismonth_adj, 2, '.', ','); 

							//----------------------------------
							$blg_earnings_owed = $contributor['to_be_pay_fixed'] ;
							$blg_earnings_rollover = $blg_earnings_owed - $blg_earnings_thismonth_adj;
							$blg_rollover = '$'.number_format($blg_earnings_rollover, 2, '.', ',');
							$blg_topay = '$'.number_format($blg_earnings_owed, 2, '.', ','); 

							$paid_cb = ($contributor['paid'] == 1)? 'checked=true' : '';
							$blg_paid = "<input type=\"checkbox\" id=\"input-" . $contributor['contributor_id'] . "\" month-info=\"" . $contributor['month']. "\" year-info=\"" . $contributor['year'] . "\" contributor-info=\"" . $contributor['contributor_id'] . "\" $paid_cb class=\"paid-checkbox\" />";
								
								echo "
										<tr>
											<td style=\" color: #333;\" class=\"align-left\" id=\"contributor-id-$blg_id\">$blg_name</td>
											<td style=\" color: #333;\" class=\"align-center\">$blg_w9</td>
											<td style=\" color: #333;\" class=\"align-right\">$blg_pviews</td>
											<td style=\" color: #333;\" class=\"align-right\">$blg_rate</td>

											<td style=\" color: #333;\" class=\"align-right\">$blg_traffic</td>
											<td style=\" color: #333;\" class=\"align-right\">$blg_incentives</td>
											<td style=\" color: #900;\" class=\"align-right\">$blg_admatch</td>
											<td style=\" color: #333;\" class=\"align-right\">$blg_total</td>
											
											<td style=\" color: #333;\" class=\"align-right\">$blg_rollover</td>
											<td style=\" color: #333;\" class=\"align-right\">$blg_topay</td>
											<td style=\" color: #333;\" class=\"align-center\">$blg_paid</td>
										</tr>

								";

							$tally_pviews_all +=  $contributor["total_us_pageviews"];
							// no tally rate.
							$tally_earnings_all +=  $contributor['total_earnings'];
							$tally_rollover_all +=  $blg_earnings_rollover;
							$tally_tbp_all +=  $blg_earnings_owed;

							switch ($blg_user_type) {
								case '8':
									$tally_pviews_pro +=  $contributor["total_us_pageviews"];
									$tally_earnings_pro +=  $contributor['total_earnings'];
									$tally_rollover_pro +=  $blg_earnings_rollover;
									$tally_tbp_pro +=  $blg_earnings_owed;
									break;
								case '3':
									$tally_pviews_community +=  $contributor["total_us_pageviews"];
									$tally_earnings_community +=  $contributor['total_earnings'];
									$tally_rollover_community +=  $blg_earnings_rollover;
									$tally_tbp_community +=  $blg_earnings_owed;
									break;
								case '30':
									$tally_pviews_starter +=  $contributor["total_us_pageviews"];
									$tally_earnings_starter +=  $contributor['total_earnings'];
									$tally_rollover_starter +=  $blg_earnings_rollover;
									$tally_tbp_starter +=  $blg_earnings_owed;
									break;
								
								default:
								// Do nothing
							}//end switch ($blg_user_type)

						}//end if($blogger)

						}//end foreach( $results ...



						// -------- User rate - CPM  --------------------------------------------------------------------------------------

							$fetched_rate = $dashboard->smf_get_user_rate(8, $selected_month, $selected_year );
							$tally_rate_pro = $fetched_rate ['user_rate'];

							$fetched_rate = $dashboard->smf_get_user_rate(3, $selected_month, $selected_year );
							$tally_rate_community = $fetched_rate ['user_rate'];

							$fetched_rate = $dashboard->smf_get_user_rate(30, $selected_month, $selected_year );
							$tally_rate_starter = $fetched_rate ['user_rate'];

							echo "
								<tr>
									<td style=\" font-weight:bold; color: #333;\" class=\"align-left\">Category</td>
									<td style=\" font-weight:bold; color: #333;\" class=\"align-center\">&nbsp;</td>
									<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">U.S Views</td>
									<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">Rate</td>

									<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">&nbsp;</td>
									<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">&nbsp;</td>
									<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">&nbsp;</td>
									<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">Adjusted<br/>Earnings</td>
									
									<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">Rollover</td>
									<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">To Pay</td>
									<td style=\" font-weight:bold; color: #333;\" class=\"align-center\">&nbsp;</td>
								</tr>
						
								";
						// -------- Tally Pro  --------------------------------------------------------------------------------------
						echo "<tr>";
							echo "<td style=\" color: #333;\" class=\"align-left\">PRO</td>";
							echo "<td style=\" color: #333;\" class=\"align-center\">&nbsp;</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">" . number_format($tally_pviews_pro, 0, '.', ',') . "</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">$" . number_format($tally_rate_pro, 2, '.', ',') . "</td>";

							echo "<td style=\" color: #333;\" class=\"align-right\">&nbsp;</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">&nbsp;</td>";
							echo "<td style=\" color: #900;\" class=\"align-right\">&nbsp;</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">$" . number_format($tally_earnings_pro, 2, '.', ',') . "</td>";

							echo "<td style=\" color: #333;\" class=\"align-right\">$" . number_format($tally_rollover_pro, 2, '.', ',') . "</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">$" . number_format($tally_tbp_pro, 2, '.', ',') . "</td>";
							echo "<td style=\" color: #333;\" class=\"align-center\">&nbsp;</td>";
						echo "	</tr> ";

						// -------- Tally Community  --------------------------------------------------------------------------------------
						echo "<tr>";
							echo "<td style=\" color: #333;\" class=\"align-left\">COMMUNITY</td>";
							echo "<td style=\" color: #333;\" class=\"align-center\">&nbsp;</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">" . number_format($tally_pviews_community, 0, '.', ',') . "</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">$" . number_format($tally_rate_community, 2, '.', ',') . "</td>";

							echo "<td style=\" color: #333;\" class=\"align-right\">&nbsp;</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">&nbsp;</td>";
							echo "<td style=\" color: #900;\" class=\"align-right\">&nbsp;</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">$" . number_format($tally_earnings_community, 2, '.', ',') . "</td>";

							echo "<td style=\" color: #333;\" class=\"align-right\">$" . number_format($tally_rollover_community, 2, '.', ',') . "</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">$" . number_format($tally_tbp_community, 2, '.', ',') . "</td>";
							echo "<td style=\" color: #333;\" class=\"align-center\">&nbsp;</td>";
						echo "	</tr> ";

						// -------- Tally Starter  --------------------------------------------------------------------------------------
						echo "<tr>";
							echo "<td style=\" color: #333;\" class=\"align-left\">STARTER</td>";
							echo "<td style=\" color: #333;\" class=\"align-center\">&nbsp;</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">" . number_format($tally_pviews_starter, 0, '.', ',') . "</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">$" . number_format($tally_rate_starter, 2, '.', ',') . "</td>";

							echo "<td style=\" color: #333;\" class=\"align-right\">&nbsp;</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">&nbsp;</td>";
							echo "<td style=\" color: #900;\" class=\"align-right\">&nbsp;</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">$" . number_format($tally_earnings_starter, 2, '.', ',') . "</td>";

							echo "<td style=\" color: #333;\" class=\"align-right\">$" . number_format($tally_rollover_starter, 2, '.', ',') . "</td>";
							echo "<td style=\" color: #333;\" class=\"align-right\">$" . number_format($tally_tbp_starter, 2, '.', ',') . "</td>";
							echo "<td style=\" color: #333;\" class=\"align-center\">&nbsp;</td>";
						echo "	</tr> ";

						// -------- Tally All  --------------------------------------------------------------------------------------
						echo "<tr>";
							echo "<td style=\" font-weight:bold; color: #333;\" class=\"align-left\">ALL</td>";
							echo "<td style=\" font-weight:bold; color: #333;\" class=\"align-center\">&nbsp;</td>";
							echo "<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">" . number_format($tally_pviews_all, 0, '.', ',') . "</td>";
							echo "<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">&nbsp;</td>";

							echo "<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">&nbsp;</td>";
							echo "<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">&nbsp;</td>";
							echo "<td style=\" font-weight:bold; color: #900;\" class=\"align-right\">&nbsp;</td>";
							echo "<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">$" . number_format($tally_earnings_all, 2, '.', ',') . "</td>";

							echo "<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">$" . number_format($tally_rollover_all, 2, '.', ',') . "</td>";
							echo "<td style=\" font-weight:bold; color: #333;\" class=\"align-right\">$" . number_format($tally_tbp_all, 2, '.', ',') . "</td>";
							echo "<td style=\" font-weight:bold; color: #333;\" class=\"align-center\">&nbsp;</td>";
						echo "	</tr> ";

				echo "
						</tbody>
						</table>
				";	

?>

				</div><!-- end of report table -->

				
				<?php }else{
					echo "<p>No records found!</p>";
				} ?>
			</div>
		</div>
	</main>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
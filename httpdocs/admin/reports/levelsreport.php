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

	$current_day = date('j');
	$current_month = date('n');
	// $current_day = 15;
	// $current_month = 6;

	$current_year = date('Y');

		$data['month'] = $current_month;
		$data['year'] = $current_year;
		$data['contributor'] = 0;
		$data['order_by'] = "total_us_pageviews DESC";

		$results = $dashboard->smf_getPageViewsUSReport($data);

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

		<?php
					$report_month = date("M", mktime(0,0,0, $current_month, 1, $current_year)) . " " . $current_year; 			
		?>

			<div class="small-12 columns padding-bottom " style="text-transform: uppercase;">
				<h1>BLOGGERS LEVEL REPORT&nbsp;&ndash;&nbsp;<?php echo $report_month;?></h1>
			</div>

			
			<div id="reports-div" class="columns small-12">
				<?php  if(isset($results) && $results ){ 

				

				echo "
					<table class=\"small-12 columns no-padding\" id=\"daily-earnings\">
						<thead>
							<tr>
								<td colspan=\"2\" style=\" background-color:#e5e5e5; color: #333;\" class=\"align-center\">BLOGGER</td>
								<td colspan=\"4\" style=\" background-color:#CCE0CC; color: #333;\" class=\"align-center\">TO DATE - $current_day Days</td>
								<td colspan=\"5\" style=\" background-color:#8DB88D; color: #333;\" class=\"align-center\">NEXT LEVEL EFFORT</td>
								
								
							</tr>
							<tr>
								<td style=\" color: #333;\" class=\"align-left\">Name</td>
								<td style=\" color: #333;\" class=\"align-left\">Email</td>

								<td style=\"border-left: 1px solid #CCE0CC; color: #333;\" class=\"align-center\">Traffic</td>
								<td style=\" color: #900;\" class=\"align-center\">Level</td>
								<td style=\" color: #333;\" class=\"align-center\">Min Views</td>
								<td style=\" color: #333;\" class=\"align-center\">Earnings</td>

								<td style=\"border-left: 1px solid #8DB88D; color: #333;\" class=\"align-center\">Traffic Needed</td>
								<td style=\" color: #333;\" class=\"align-center\">T.N.&#37;</td>
								<td style=\" color: #900;\" class=\"align-center\">Level</td>
								<td style=\" color: #333;\" class=\"align-center\">Min Views</td>
								<td style=\" color: #333;\" class=\"align-center\">Earnings</td>



								
							</tr>
						</thead>
						<tbody>

					";




			  	 foreach( $results as $contributor){

					$month_fraction = $current_day/30.4; 
					$report_minimum_earning = 25 * $month_fraction;



			  			if($contributor['to_be_pay_fixed']  < $report_minimum_earning) continue;
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
							$blg_email = $contributor['contributor_email_address'];
							$blg_name = "<a href=\"http://www.puckermob.com/admin/earnings/" . $contributor['contributor_seo_name'] . "\" target=\"blank\">" . $contributor['contributor_name'] . "</a>" ;

							$blg_pageviews = $contributor["total_us_pageviews"];
							
							//----------------------------------
							$blg_current_level = $dashboard->smf_get_merit_rate($blg_pageviews, $current_month, $current_year );
								$blg_current_level_level = $blg_current_level['level'];
								$blg_current_level_threshold = $blg_current_level['threshold'];
								$blg_current_level_flat_rate_threshold = $blg_current_level['flat_rate_threshold'];

							//----------------------------------
							$blg_effort_level = $dashboard->smf_get_merit_rate_next_level($blg_pageviews, $current_month, $current_year );
								$blg_effort_level_level = $blg_effort_level['level'];
								$blg_effort_level_threshold = $blg_effort_level['threshold'];
								$blg_effort_level_flat_rate_threshold = $blg_effort_level['flat_rate_threshold'];


							//----------------------------------
							$blg_pageviews_needed_to_effort_level = $blg_effort_level_threshold - $blg_pageviews;
							$blg_effort_ratio = 100*($blg_pageviews_needed_to_effort_level/$blg_pageviews);
							$blg_flag_level = 10;//percent
							$blg_flag_bg = ($blg_effort_ratio>0 && $blg_effort_ratio<=$blg_flag_level)? "background-color:#F9EFDE;" : ""; 
							$blg_flag_display = ($blg_effort_ratio>0 && $blg_effort_ratio<=(2*$blg_flag_level))? number_format($blg_effort_ratio, 2, '.', ',') . "%" : "&mdash;"; 

							

					// $ddd = new debug($blg_current_level,3); $ddd->show(); exit();// 0- green; 1-red; 2-grey; 3-yellow	
					// $ddd = new debug($contributor,3); $ddd->show(); exit();// 0- green; 1-red; 2-grey; 3-yellow	
								
								echo "
										<tr>
											<td style=\" $blg_flag_bg color: #333;\" class=\"align-left\" id=\"contributor-id-$blg_id\">$blg_name</td>
											<td style=\" $blg_flag_bg color: #333;\" class=\"align-left\" id=\"contributor-id-$blg_id\">$blg_email</td>
																				
											<td style=\" $blg_flag_bg border-left: 1px solid #CCE0CC; color: #333;\" class=\"align-right\">" . number_format($blg_pageviews, 0, '.', ',') . "</td>
											<td style=\" $blg_flag_bg color: #900;\" class=\"align-center\">" . number_format($blg_current_level_level, 0, '.', ',') . "</td>
											<td style=\" $blg_flag_bg color: #333;\" class=\"align-right\">" . number_format($blg_current_level_threshold, 0, '.', ',') . "</td>
											<td style=\" $blg_flag_bg color: #333;\" class=\"align-right\">$" . number_format($blg_current_level_flat_rate_threshold, 0, '.', ',') . "</td>

											<td style=\" $blg_flag_bg border-left: 1px solid #8DB88D; color: #333;\" class=\"align-right\">" . number_format($blg_pageviews_needed_to_effort_level, 0, '.', ',') . "</td>
											<td style=\" $blg_flag_bg color: #333;\" class=\"align-center\">$blg_flag_display</td>
											<td style=\" $blg_flag_bg color: #900;\" class=\"align-center\">" . number_format($blg_effort_level_level, 0, '.', ',') . "</td>
											<td style=\" $blg_flag_bg color: #333;\" class=\"align-right\">" . number_format($blg_effort_level_threshold, 0, '.', ',') . "</td>
											<td style=\" $blg_flag_bg color: #333;\" class=\"align-right\">$" . number_format($blg_effort_level_flat_rate_threshold, 0, '.', ',') . "</td>

								
										</tr>

								";




						}//end if($blogger)

						}//end foreach( $results ...




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
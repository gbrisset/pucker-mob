<?php 
	$admin = true;
	require_once('../../assets/php/config.php');
	if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');

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
	//$new_cal = false;
	//if( $selected_year == 2015 && $selected_month  > 2 ) $new_cal = true;
	//if( $selected_year > 2015) $new_cal = true;

	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!

			//TRAFFIC & EARNINGS INFO
			$results = $dashboard->getPageViewsUSReport($_POST);

				 $ddd = new debug($_POST,3); $ddd->show();exit;// 0- green; 1-red; 2-grey; 3-yellow	

			
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
				<?php  if(isset($results) && $results ){ ?>
				<div class="small-12 columns">
					<div class="row ">
						<div class="small-4 columns">
							<div class="row">
							  <div class="columns small-5">Name</div>
							  <div class="columns small-2"><label>W9</label></div>
							  <div class="columns small-3"><label>U.S Views</label></div>
							  <div class="columns small-2"><label>Rate</label></div>
							</div>
						</div>
						<div class="small-5 columns">
							<div class="row">
							  <div class="columns small-3"><label>Traffic</label></div>
							  <div class="columns small-3"><label>Incentives</label></div>
							  <div class="columns small-3"><label>AD Match</label></div>
							  <div class="columns small-3"><label>Total</label></div>
							</div>
						</div>
						<div class="small-3 columns">
							<div class="row">
							  <div class="columns small-5"><label>Unpaid</label></div>
							  <div class="columns small-5"><label>Pay</label></div>
							  <div class="columns small-2"><label>Paid</label></div>
							</div>
						</div>
					</div>
				</div>
				<?php
			  		$total = 0;
			  		$total_rate =  $total_rate_started = $total_rate_pro = $total_rate_basic = 0;
			  		$total_us_viewers = 0;
			  		$total_us_viewers_by_thousands = 0;
			  		$all_us_viewers = 0;
			  		$all_us_viwers_by_thousand = $all_us_viwers_by_thousand_started = 0;
			  		$all_total = 0;
			  		$all_total_to_pay = 0;
			  		$all_basic_total = $all_started_total = 0;
			  		$all_pro_total = $all_unpaid_total = 0;
			  		$all_us_viwers_by_thousand_pro = $all_us_viwers_by_thousand_basic = $all_total_to_pay_over_25 = $all_unpaid_total_over_25 = 0;
			  		$new = $total_over_25 = 0;
			  		$all_adMatch_rev = $total_incentives = $total_rev = $total_pro_incentives = $total_basic_incentives = $total_started_incentives = 0;
			  		$all_unpaid_total_pro = $all_unpaid_total_basic = $all_unpaid_total_started= 0;
			  		

			  		foreach( $results as $contributor){
			  			$total_rate = $contributor['share_rate'];
			  			$total_us_viewers = $contributor["total_us_pageviews"];
			  			$total_us_viewers_by_thousands = $total_us_viewers / 1000;
			  			$user_type = $contributor['user_type'];
		  				$unpaid = $adMatchBalance = 0;
		  				$incentives = 0;
		  				
		  				//AD MATCHING
		  				if($adMatchInfo){
			  				foreach($adMatchInfo as $match){
			  					if($match->contributor_id == $contributor['contributor_id']){
			  						$adMatchBalance = $match->amount_commit;
			  						break;
			  					}
			  				}
		  				}
		  				//RANKLIST
			  			if($rank_list){ 
			  				foreach($rank_list as $key => $val ){
			  					if($key == $contributor['contributor_id']){
			  						if (strpos($val, '$') !== false) {
			  							$incentives = substr($val, 1);
			  							break;
			  						}
			  					}
			  				}
			  			}

			  			$no_cover_in_house = false;
						$blogger = $problogger = $basicblogger = false;
						if($user_type == '3' || $user_type == '30' ||  $user_type == '8' || $user_type == '9' ) $blogger = true;
						if( $user_type == '8' || $user_type == '9') $problogger = true;
						if( $user_type == '3' ) $basicblogger = true;

						//IS A BLOGGER
			  			if( !$blogger ){
				  			$total_traffic_rev = 0;
				  			$total_to_pay  = 0;
							$no_cover_in_house = true;
				  		}else{
				  			$total_traffic_rev = $contributor['total_earnings'];
				  			$total_to_pay = ( $contributor['to_be_pay'] + $incentives ) - $adMatchBalance;
				  			$unpaid = $contributor['to_be_pay']  - $total_traffic_rev;
				  		}

				  		//IF PAID
				  		$paid = $contributor['paid'];
				  		$paid_cb = '';
				  		if($paid == 1) $paid_cb = 'checked=true';
				  		
				  		$total_rev = ( $total_traffic_rev + $incentives ) - $adMatchBalance;
				  						  		
				  		if( $blogger ){
				  			if($user_type == '30'){ //STARTED
				  				$all_started_total += $total_traffic_rev;
						  		$all_us_viwers_by_thousand_started += $total_us_viewers_by_thousands ;
						  		$total_rate_started = $total_rate;
						  		$total_started_incentives += $incentives;
						  		$all_unpaid_total_started += $unpaid;
				  			}else{
						  		if( $problogger ){
						  			$all_pro_total += $total_traffic_rev;
						  			$all_us_viwers_by_thousand_pro += $total_us_viewers_by_thousands ;
						  			$total_rate_pro = $total_rate;
						  			$total_pro_incentives += $incentives;
						  			$all_unpaid_total_pro += $unpaid;
						  		}else{ 
						  			$all_basic_total += $total_traffic_rev;
						  			$all_us_viwers_by_thousand_basic += $total_us_viewers_by_thousands;
						  			$total_rate_basic = $total_rate;
						  			$total_basic_incentives += $incentives;
						  			$all_unpaid_total_basic += $unpaid;
						  		}
						  	}

						  	//TOTALS
				  			if( ( $total_rev  + $unpaid ) < 25) continue;
				  			//{
					  		/*	$all_total_to_pay_over_25 += $total_to_pay;
					  			$all_unpaid_total_over_25 += $unpaid;
				  			}*/

						  	$all_unpaid_total += $unpaid;
				  			$all_us_viewers += $total_us_viewers;
				  			$total_incentives += $incentives;
				  			$all_us_viwers_by_thousand += $total_us_viewers_by_thousands;
				  			$all_total += $total_traffic_rev; 
				  			$all_rate = $total_rate;
				  			$all_total_to_pay += $total_to_pay;
					  	}

					  	//TOTALS
				  		if($total_to_pay < 1) continue;
			  			
					  			
						?>	
						<?php if(!$no_cover_in_house ){  ?>
						
							<div class="small-12 columns">
							<div class="row reports-sub-tables">
								<!-- ANALYTICS & RATE INFO -->
								<div class="small-4 columns subdivition">
								  	<div class="row">
									  	<!-- NAME -->
									  	<div class="columns small-5" id="contributor-id-<?php echo $contributor['contributor_id']; ?>">
									  		<a href="http://www.puckermob.com/admin/earnings/<?php echo $contributor['contributor_seo_name']; ?>" target="blank">
										  		<?php echo $contributor['contributor_name']; ?>
										  	</a>
										  	<label style="font-size: 11px !important; "><?php echo $contributor['paypal_email'];?></label>
									  	</div>
									  	<!-- w9 -->
									  	<div class="columns small-2">
									  		<?php if($contributor['w9_live'] === '1'){ ?>
										  		<i class='fa fa-check' style='margin-left:0; margin-right: 0; color:green;'></i>
										  	<?php }else echo "--" ?>
									  	</div>
									  	<!-- TOTAL US PAGEVIEWS -->
									  	<div class="columns small-3"><label><?php echo number_format($total_us_viewers_by_thousands, 2, '.', ','); ?></label></div>
									  	<!-- RATE -->
									  	<div class="columns small-2"><label><?php echo '$'.number_format($total_rate, 2, '.', ','); ?></label></div>
								  	</div>
								</div>
								<!-- EARNINGS TOTALS INFO -->
								<div class="small-5 columns subdivition">
								  <div class="row">
								  	<div class="columns small-3"><label><?php echo '$'.number_format($total_traffic_rev, 2, '.', ','); ?></label></div>
								  	<div class="columns small-3"><label><?php echo '$'.number_format($incentives, 2, '.', ','); ?></label></div>
								  	<div class="columns small-3"><label style="color: red;"><?php echo '-$'.number_format($adMatchBalance, 2, '.', ','); ?></label></div>
								  	<div class="columns small-3"><label><?php echo '$'.number_format($total_rev, 2, '.', ','); ?></label></div>
								  </div>
								</div>
								<!-- TOTALS -->
								<div class="small-3 columns subdivition">
								  <div class="row">
								  	  	<div class="columns small-5"><label><?php echo '$'.number_format($unpaid, 2, '.', ','); ?></label></div>
									  	<div class="columns small-5"><label><?php echo '$'.number_format($total_to_pay, 2, '.', ','); ?></label></div>
									  	<div class="columns small-2">
									  		<input type="checkbox" id="input-<?php echo $contributor['contributor_id']; ?>" month-info="<?php echo $contributor['month']; ?>" year-info="<?php echo $contributor['year']; ?>" contributor-info="<?php echo $contributor['contributor_id']; ?>" <?php echo $paid_cb; ?> class="paid-checkbox" />
									  	</div>
								  </div>
								</div>
							</div>
							</div>

						<?php } ?>  
				 <?php  }  ?>	
						
				<!-- TOTALS -->
				<div class="small-12 columns show-totals">
					<!-- PRO TOTALS -->
					<div class="row reports-sub-tables">
						<div class="small-4 columns subdivition">
							<div class="row">
							  <div class="columns small-7 uppercase bold">PRO</div>
							  <div class="columns small-3"><label><?php echo $all_us_viwers_by_thousand_pro; ?></label></div>
							  <div class="columns small-2"><label><?php echo '$'.number_format($total_rate_pro, 2, '.', ','); ?></label></div>
							</div>
						</div>
						<div class="small-5 columns subdivition">
							<div class="row">
							  <div class="columns small-3"><label><?php //echo '$'.number_format($all_pro_total, 2, '.', ','); ?></label></div>
							  <div class="columns small-3"></label><?php //echo '$'.number_format($total_pro_incentives, 2, '.', ','); ?></div>
							  <div class="columns small-3"></label></div>
							  <div class="columns small-3"><label><?php echo '$'.number_format(($all_pro_total + $total_pro_incentives ), 2, '.', ','); ?></label></div>
							</div>
						</div>
						<div class="small-3 columns subdivition">
							<div class="row">
							  <div class="columns small-5"><label><?php echo '$'.number_format($all_unpaid_total_pro, 2, '.', ','); ?></label></div>
							  <div class="columns small-5"><label><?php echo '$'.number_format( ( $all_pro_total + $total_pro_incentives  + $all_unpaid_total_pro), 2, '.', ','); ?></label></div>
							  <div class="columns small-2"><label></label></div>
							</div>
						</div>
					</div>
					<!-- COMMUNITY TOTALS -->
					<div class="row reports-sub-tables">
						<div class="small-4 columns subdivition">
							<div class="row">
							  <div class="columns small-7 uppercase bold">COMMUNITY</div>
							  <div class="columns small-3"><label><?php echo $all_us_viwers_by_thousand_basic; ?></label></div>
							  <div class="columns small-2"><label><?php echo '$'.number_format($total_rate_basic, 2, '.', ','); ?></label></div>
							</div>
						</div>
						<div class="small-5 columns subdivition">
							<div class="row">
							  <div class="columns small-3"><label><?php //echo '$'.number_format($all_basic_total, 2, '.', ','); ?></label></div>
							  <div class="columns small-3"></label><?php //echo '$'.number_format($total_basic_incentives, 2, '.', ','); ?></div>
							  <div class="columns small-3"></label></div>
							  <div class="columns small-3"><label><?php echo '$'.number_format(($all_basic_total + $total_basic_incentives ), 2, '.', ','); ?></label></div>
							</div>
						</div>
						<div class="small-3 columns subdivition">
							<div class="row">
							  <div class="columns small-5"><label><?php echo '$'.number_format($all_unpaid_total_basic, 2, '.', ','); ?></label></div>
							  <div class="columns small-5"><label><?php echo '$'.number_format(( $all_basic_total + $total_basic_incentives  + $all_unpaid_total_basic), 2, '.', ','); ?></label></div>
							  <div class="columns small-2"><label></label></div>
							</div>
						</div>
					</div>
					<!-- STARTED TOTALS -->
					<div class="row reports-sub-tables">
						<div class="small-4 columns subdivition">
							<div class="row">
							  <div class="columns small-7 uppercase bold">STARTED</div>
							  <div class="columns small-3"><label><?php  echo $all_us_viwers_by_thousand_started; ?></label></div>
							  <div class="columns small-2"><label><?php echo '$'.number_format($total_rate_started, 2, '.', ','); ?></label></div>
							</div>
						</div>
						<div class="small-5 columns subdivition">
							<div class="row">
							  <div class="columns small-3"><label><?php // echo '$'.number_format($all_started_total, 2, '.', ','); ?></label></div>
							  <div class="columns small-3"></label><?php // echo '$'.number_format($total_started_incentives, 2, '.', ','); ?></div>
							  <div class="columns small-3"></label></div>
							  <div class="columns small-3"><label><?php echo '$'.number_format(($all_started_total + $total_started_incentives ), 2, '.', ','); ?></label></div>
							</div>
						</div>
						<div class="small-3 columns subdivition">
							<div class="row">
							  <div class="columns small-5"><label><?php echo '$'.number_format($all_unpaid_total_started, 2, '.', ','); ?></label></div>
							  <div class="columns small-5"><label><?php echo '$'.number_format(( $all_started_total + $total_started_incentives  + $all_unpaid_total_started), 2, '.', ','); ?></label></div>
							  <div class="columns small-2"><label></label></div>
							</div>
						</div>
					</div>
					<!-- OVERALL TOTAL -->
					<div class="row reports-sub-tables">
						<div class="small-4 columns subdivition">
							<div class="row">
							  <div class="columns small-7 uppercase bold">Totals</div>
							  <div class="columns small-3"><label><?php echo number_format($all_us_viwers_by_thousand, 2, '.', ','); ?></label></div>
							  <div class="columns small-2"><label></label></div>
							</div>
						</div>
						<div class="small-5 columns subdivition">
							<div class="row">
							  <div class="columns small-3"><label><?php echo '$'.number_format($all_total, 2, '.', ','); ?></label></div>
							  <div class="columns small-3"></label><?php echo '$'.number_format($total_incentives, 2, '.', ','); ?></div>
							  <div class="columns small-3"></label></div>
							  <div class="columns small-3"><label><?php echo '$'.number_format(($all_total + $total_incentives ), 2, '.', ','); ?></label></div>
							</div>
						</div>
						<div class="small-3 columns subdivition">
							<div class="row">
							  <div class="columns small-5"><label><?php echo '$'.number_format($all_unpaid_total, 2, '.', ','); ?></label></div>
							  <div class="columns small-5"><label><?php echo '$'.number_format($all_total_to_pay, 2, '.', ','); ?></label></div>
							  <div class="columns small-2"><label></label></div>
							</div>
						</div>
					</div>

				<!--  TOTAL OVER 25
					<div class="row reports-sub-tables">
						<div class="small-4 columns subdivition">
							<div class="row">
							  <div class="columns small-7 uppercase bold">Totals Over 25</div>
							  <div class="columns small-3"><label></label></div>
							  <div class="columns small-2"><label></label></div>
							</div>
						</div>
						<div class="small-5 columns subdivition">
							<div class="row">
							  <div class="columns small-3"><label><?php echo '$'.number_format($all_total_to_pay_over_25, 2, '.', ','); ?></label></div>
							  <div class="columns small-3"></label></div>
							  <div class="columns small-3"></label></div>
							  <div class="columns small-3"><label></label></div>
							</div>
						</div>
						<div class="small-3 columns subdivition">
							<div class="row">
							  <div class="columns small-5"><label><?php echo '$'.number_format($all_unpaid_total_over_25, 2, '.', ','); ?></label></div>
							  <div class="columns small-5"><label><?php echo '$'.number_format(( $all_total_to_pay_over_25 + $all_unpaid_total_over_25), 2, '.', ','); ?></label></div>
							  <div class="columns small-2"><label></label></div>
							</div>
						</div>
					</div>
				</div>
				</div>-->

				
				
				
				<?php }else{
					echo "<p>No records found!</p>";
				} ?>
			</div>
		</div>
	</main>
	<?php include_once($config['include_path_admin'].'bottomscripts.php');?>
</body>
</html>
	
	<?php 
		//User Object
		$userObj = new User();
		$current_month = date('n');
		$current_year = date('Y');
		//Get All user Bloggers
		$bloggers = count($userObj->all( ' 3, 8, 9 '));
		$bloggers_this_month = count( $userObj->where( " WHERE MONTH(user_creation_date) = '".$current_month."' and YEAR(user_creation_date) = '".$current_year."'  and user_type IN (3, 8, 9) " ));
		$probloggers = count( $userObj->all( ' 8 ') );

		//EARNINGS INFO
		$earningsObj = new ContributorEarnings();
		$pro_rate = $earningsObj->getRate( $current_month, $current_year, 8 );
		$community_rate = $earningsObj->getRate( $current_month, $current_year, 0 );
		$starter_rate = $earningsObj->getRate( $current_month, $current_year, 6 );

	?>
	<div class="small-12 radius control-panel-general-info">
		<div class="small-12 columns radius right-side-box no-margin-top half-margin-bottom">
		<div class="">
			<h3>Total Bloggers: <span><?php echo number_format($bloggers); ?></span></h3>
		</div>
		</div>
		<div class="small-12 columns radius right-side-box no-margin-top half-margin-bottom">
		<div class="">
			<h3>New Bloggers (This Month): <span><?php echo number_format($bloggers_this_month); ?></span></h3>
		</div>
		</div>
		<div class="small-12 columns radius right-side-box no-margin-top half-margin-bottom">
		<div class="">
			<h3>Pro Bloggers: <span><?php echo number_format($probloggers); ?></span></h3>
		</div>
		</div>
		<div class="small-12 columns radius right-side-box no-margin-top half-margin-bottom">
		<div class="">
			<h3>PRO CPM: <span><?php echo '$'.number_format($pro_rate[0]->rate, 2); ?></span></h3>
		</div>
		</div>
		<div class="small-12 columns radius right-side-box no-margin-top half-margin-bottom">
		<div class="">
			<h3>Community CPM: <span><?php echo '$'.number_format($community_rate[0]->rate, 2); ?></span></h3>
		</div>
		</div>
		<div class="small-12 columns radius right-side-box no-margin-top half-margin-bottom">
		<div class="">
			<h3>Starter CPM: <span><?php echo '$'.number_format($starter_rate[0]->rate, 2); ?></span></h3>
		</div>
		</div>
	</div>






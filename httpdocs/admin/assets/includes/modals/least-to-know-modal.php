<?php 
	$current_to_know = "current";
   $current_profile = $current_payment = $current_social =  $current_last = $current_intro = '';
?>
<div class="main-content-modal small-12 columns to-know-modal ">
	
	<div class="columns small-12">
		<p>PuckerMob classifies all of all our bloggers into three distinct levels, each with different benefits and pay rates:</p>
	</div>
	<div class="levels columns small-12">
		<!-- STARTER -->
		<div class="small-4 columns starter">
			<h2>STARTER</h2>
			<ul>
				<li>All newly registered bloggers start at this level (this includes you!)</li>
				<li>Your posts must be approved by a PuckerMob.com editor before appearing live on the site.</li>
				<li>You’ll earn a low CPM rate, but hey, something’s better than nothing! </li>
				<li>Take part in monthly incentive plans to earn bonus money!</li>
				<li>You’ll be automatically promoted to Basic level when you reach 5,000 lifetime U.S. visits to your articles.</li>
			</ul>
		</div>

		<!-- BASIC -->
		<div class="small-4 columns basic">
			<h2>BASIC</h2>
			<ul>
				<li>Articles don’t need to be approved - you can post them live on the site yourself.</li>
				<li>You’ll earn a slightly higher CPM rate.</li>
				<li>Take part in monthly incentive plans to earn bonus money!</li>
				<li>You’ll be automatically promoted to Pro level when you reach 25,000 U.S. visits per month for two months straight.</li>
			</ul>
		</div>

		<!-- PRO -->
		<div class="small-4 columns pro">
			<h2>PRO</h2>
			<ul>
				<li>Articles don’t need to be approved - you can post them live on the site yourself.</li>
				<li>You’ll earn a significantly higher CPM rate.</li>
				<li>Take part in monthly incentive plans to earn bonus money!</li>
				<li>You’ll be automatically demoted back to Basic level if your traffic falls below 35,000 U.S. visits per month for two months straight.</li>
			</ul>
		</div>
	</div>
	<div class="columns small-12">
		<p>We pay all of our bloggers between 50-55 days after the end of each month. You must have at least $25 in earnings before 
			getting paid. Any earnings below $25 will accumulate until the threshold is reached. </p>
	</div>
	</div>


<hr style="0.8rem 0" />

<!-- MODAL FOOTER -->
 <div class="column small-12 welcome-modal-footer">
    	<?php require('welcome-modal-footer.php'); ?>

    <p class="small-3 large-3 columns align-right no-padding-right">
    	<a href="#" data-reveal-id="profile-modal" class="secondary next-modal-step">
    		<label class="show-for-large-up"> GO TO NEXT STEP</label> 
	    	<label class="hide-for-large-up"> NEXT</label> 
	    	<i class="fa fa-chevron-right" aria-hidden="true"></i>
    	</a>
    </p>
</div>
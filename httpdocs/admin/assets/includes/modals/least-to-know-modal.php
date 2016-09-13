<?php 
	$current_to_know = "current";
   $current_profile = $current_payment = $current_social =  $current_last = $current_intro = '';
?>
<div class="main-content-modal to-know-modal columns small-12 border-radius-10x no-padding  modal-inside-wrapper">
	<div class="wait clear" style="    margin-top: -9px; border-top-right-radius: 10px; border-top-left-radius: 10px;">
		<span>LEVELS</span>
	</div>
	<div class="levels columns small-12 margin-top">
		<!-- STARTER -->
		<div class="small-12 columns starter">
			<p>PuckerMob bloggers fall into three different levels. As a newly registered writer, you’re automatically:</p>
			<h3>STARTER LEVEL</h3>
			<ul>
				<li>You’ll earn our base CPM rate (check the dashboard for details)</li>
				<li>Your articles will need approval from a PuckerMob editor before being posted live</li>
				<li>Take part in monthly incentive events to earn more</li>
				<li>You’ll automatically be promoted to our next level, Basic, after getting just 5,000 total 
					views on your articles. Once your Basic, you’ll start to earn more and get more exposure.</li>
			</ul>
		</div>
		<div class="columns small-12">
			<p>There are other levels higher than Basic, but you’ll find out more about them later.</p>
		</div>
	</div>
	
	<!-- MODAL FOOTER -->
	 <div class="column small-12 welcome-modal-footer">
	    	<?php require('welcome-modal-footer.php'); ?>

	    <p class="small-3 large-3 columns align-right no-padding-right">
	    	<a href="#" data-reveal-id="profile-modal" class="secondary next-modal-step">
	    		<label class="show-for-large-up">NEXT STEP</label> 
		    	<label class="hide-for-large-up"> NEXT</label> 
		    	<i class="fa fa-chevron-right" aria-hidden="true"></i>
	    	</a>
	    </p>
	</div>
</div>

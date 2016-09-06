<?php 
	$current_social = "current";
	$current_profile = $current_payment = $current_intro =  $current_last = $current_to_know = '';
?>
<div class="main-content-modal small-12 columns social-modal">
	 <div class="columns small-12 large-3">
	 	<h2 id="social-modal-title">STEP 3: ACCESS US ON FACEBOOK</h2>
	 	<p>PuckerMob has a number of pages on Facebook. Like them all - being part of the PuckerMob community will help you get greater exposure for your articles.  </p>
	 </div>
	 
	 <div class="columns small-12 large-9 no-padding-right">
	 	<?php include('modal-social-form.php'); ?>
	 </div>
		  
		  
</div>

<hr />

<!-- MODAL FOOTER -->
 <div class="column small-12 welcome-modal-footer">
  	<?php require('welcome-modal-footer.php'); ?>
    <p class="small-3 columns align-right no-padding-right">
    	<a href="#" data-reveal-id="last-modal" class="secondary next-modal-step">
	    	<label class="show-for-large-up"> GO TO NEXT STEP</label> 
	    	<label class="hide-for-large-up"> NEXT</label> 
	    	<i class="fa fa-chevron-right" aria-hidden="true"></i>
    	</a>
    </p>
	
  </div>
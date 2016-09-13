<?php 
	$current_profile = "current";
	 $current_intro = $current_payment = $current_social =  $current_last = $current_to_know = '';
	
?>
<div class="main-content-modal small-12 columns profile-modal border-radius-10x no-padding  modal-inside-wrapper">
	<div class="wait clear" style="    margin-top: -9px; border-top-right-radius: 10px; border-top-left-radius: 10px;">
		<span>PROFILE</span>
	</div>

	 <div class="columns small-12">
		  <p>When you complete your profile, you’ve got a much higher chance of people reading your articles. Readers want to know who you are!</p>
	 </div>
	 
	 <div class="columns small-12">
	 	<?php include('modal-profile-form.php'); ?>
	 </div>
		  

	<!-- MODAL FOOTER -->
	 <div class="column small-12 welcome-modal-footer">
	  	  	<?php require('welcome-modal-footer.php'); ?>

	    <p class="small-3 columns align-right no-padding-right">
	    	<a href="#" data-reveal-id="payment-modal" class="secondary next-modal-step">
	    		<label class="show-for-large-up"> GO TO </label> STEP 3
	    		<i class="fa fa-chevron-right" aria-hidden="true"></i>
	    	</a>
	    </p>
		
	  </div>
</div>
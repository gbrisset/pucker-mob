<?php 
	$current_profile = "current";
	 $current_intro = $current_payment = $current_social =  $current_last = '';
	
?>
<div class="main-content-modal small-12 columns profile-modal">
	 <div class="columns small-12 large-3">
	 	  <h2 id="profile-modal-title">STEP 1: CREATE YOUR PROFILE</h2>
		  <p>Did you know that writers who upload a picture and have a completed profile get an average of 3x-5x more readers than writers who don’t fill in their profile? Readers want to know who you are!</p>
		  <p>Fill out your profile now - it only takes a minute (maybe two).</p>
	 </div>
	 
	 <div class="columns small-12 large-9">
	 	<?php include('modal-profile-form.php'); ?>
	 </div>
		  
</div>

<hr />

<!-- MODAL FOOTER -->
 <div class="column small-12 welcome-modal-footer">
  	  	<?php require('welcome-modal-footer.php'); ?>

    <p class="small-3 columns align-right no-padding-right">
    	<a href="#" data-reveal-id="payment-modal" class="secondary next-modal-step">
    		<label class="show-for-large-up"> GO TO </label> STEP 2
    		<i class="fa fa-chevron-right" aria-hidden="true"></i>
    	</a>
    </p>
	
  </div>
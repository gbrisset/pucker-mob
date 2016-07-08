<?php 
	$current_payment = "current";
	 $current_profile = $current_intro = $current_social =  $current_last = '';
?>
<div class="main-content-modal small-12 columns payment-modal">
	 <div class="columns small-12 large-3">
	 	<h2 id="payment-modal-title">STEP 2: UPLOAD PAYMENT INFO</h2>
	 	<p>As a new writer, you’re automatically start at the Basic Level. </p>
		<p>Please read the “Blogger Levels” page in your dashboard to learn more. </p>
		<p>Fill out your tax and PayPal info so we can pay you for your traffic. </p>
		<p>We pay approximately 45 days after the end of each month. Please note we can’t pay you until your tax and Paypal info has been provided.  </p>
	 </div>
	 
	 <div class="columns small-12 large-9 no-padding-right">
	 	<?php include('modal-payment-form.php'); ?>
	 </div>	  
</div>

<hr />
<!-- MODAL FOOTER -->
 <div class="column small-12 welcome-modal-footer">
    <?php require('welcome-modal-footer.php'); ?>

    <p class="small-3 columns align-right no-padding-right">
    	<a href="#" data-reveal-id="social-modal" class="secondary next-modal-step">
    		<label class="show-for-large-up"> GO TO STEP 3</label> 
	    	<label class="hide-for-large-up"> STEP 3</label> 
	    	<i class="fa fa-chevron-right" aria-hidden="true"></i>
   		</a>
   	</p>
	
  </div>
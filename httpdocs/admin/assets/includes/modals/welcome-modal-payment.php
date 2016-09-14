<?php 
	$current_payment = "current";
	 $current_profile = $current_intro = $current_social =  $current_last = $current_to_know = '';
?>

<div class="main-content-modal small-12 columns payment-modal border-radius-10x no-padding  modal-inside-wrapper">
	 <div class="wait clear" style="    margin-top: -9px; border-top-right-radius: 10px; border-top-left-radius: 10px;">
		<span>MONEY</span>
	</div>
	<div class="small-12 columns center" style="margin-top: 2rem;">
		<p  class="small-12 columns" style="color: green; font-family: oslobold">You want to get paid, right? Well, we want to pay you! </p>
	</div>
	<div class="small-12 columns center">
		<p class="small-12 columns">You’ll get paid as soon as you earn a total of $25.00. Once you reach that level, we’ll need some tax and payment info from you (a W9 form and a PayPal account ID).</p>
	</div>
	<div class="small-12 columns center" style="margin-bottom: 2rem;">
		<p class="small-12 columns">But you don’t have to worry about that right now. We’ll let you know as soon as you’ve earned enough to get paid, and we’ll work with you at that point to get the info that we need.</p>
	</div>	

<!-- MODAL FOOTER -->
 <div class="column small-12 welcome-modal-footer">
    <?php require('welcome-modal-footer.php'); ?>

    <p class="small-3 columns align-right no-padding-right">
    	<a href="#" data-reveal-id="social-modal" class="secondary next-modal-step">
    		<label class="show-for-large-up"> GO TO STEP 4</label> 
	    	<label class="hide-for-large-up"> STEP 4</label> 
	    	<i class="fa fa-chevron-right" aria-hidden="true"></i>
   		</a>
   	</p>
	
  </div>

</div>
  <!-- 

MONEY






  -->
<?php 
	$current_intro = "current";
   $current_profile = $current_payment = $current_social =  $current_last = $current_to_know = '';
?>
<div class="modal-inside-wrapper columns small-12 border-radius-10x no-padding">
	<div class="main-content-modal small-12 columns intro-modal no-padding">
		<div class="columns">
			<h2 id="intro-modal-title">CONGRATULATIONS!</h2>
			<div class="intro-modal-wrapper">
				<p>
					You’re now officially a blogger for PuckerMob! We know you’re probably anxious to write your first article, but…
				</p>
			</div>
		</div>
		<div class="wait clear">
			<span>WAIT!</span>
		</div>
		<div class="columns">
			<div class="intro-modal-wrapper">
				<p>
					Take two minutes to read through this super quick intro, and we promise you’ll enjoy your experience with us a lot more (and have fewer questions!)
				</p>
			</div>
			<div class="center">
				<h3><a href="#" data-reveal-id="to-know-modal" class="secondary next-modal-step">GET STARTED</a></h3>
			</div>
		</div>
	</div>

	<!-- MODAL FOOTER -->
	<div class="column small-12 welcome-modal-footer">
    	<?php require('welcome-modal-footer.php'); ?>
		<p class="small-3 large-3 columns align-right no-padding-right"><a href="#" data-reveal-id="to-know-modal" class="secondary next-modal-step"><label class="show-for-large-up"> GO TO </label> STEP 1<i class="fa fa-chevron-right" aria-hidden="true"></i></a></p>
	</div>
</div>
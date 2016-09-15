<?php 
	$current_last = "current";
	$current_intro =  $current_profile = $current_payment = $current_social = $current_to_know = '';
?>
<div class="main-content-modal small-12 columns last-modal border-radius-10x no-padding  modal-inside-wrapper">
	<div class="wait clear" style="margin-top: -9px; border-top-right-radius: 10px; border-top-left-radius: 10px;">
		<span>START!</span>
	</div>
	<div class="intro-modal-wrapper columns" style="margin-top:1rem;">
		<h3 class="first">THAT’S IT - YOU’RE READY TO GO!</h3>

		<p>There’s a lot more to it, but you’ll figure the rest out as you go. So where do you want to start?</p>

		<div class="small-12 columns">
			<div class="small-6 columns image-box-start center">
				<a href="http://www.puckermob.com/admin/dashboard/">
					<img src ="http://www.puckermob.com/admin/assets/img/Start-Slide-Dashboard.jpg" alt="dashboard image"/>
					<label class="show-for-large-up">CHECK OUT THE DASHBOARD</label>
					<label class="hide-for-large-up">DASHBOARD</label>

				</a>
				
			</div>
			<div class="small-6 columns image-box-start center">
				<a href="http://www.puckermob.com/admin/articles/newarticle">
					<img src ="http://www.puckermob.com/admin/assets/img/Start-Slide-Add-New-Article.jpg" alt="new article page image"/>
					<label class="show-for-large-up">START WRITING AN ARTICLE</label>
					<label class="hide-for-large-up">START WRITING</label>

				</a>
				

			</div>

		</div>

		<div class="small-12 columns" style="margin-top: 15px; margin-bottom: 10px;">
			<p>Good luck! We can’t wait to read your posts!</p>
		</div>
	</div>


	<!-- MODAL FOOTER -->
	<div class="column small-12 welcome-modal-footer">
	  	  	<?php require('welcome-modal-footer.php'); ?>

	    <p class="small-3 columns align-right no-padding-right">
	    	<a href="http://www.puckermob.com/admin/articles/newarticle/" class="secondary next-modal-step">
		    	<label class="show-for-large-up"> START!</label>
		    	<label class="hide-for-large-up"> START!</label>
		    	<i class="fa fa-chevron-right" aria-hidden="true"></i>
	    	</a>
	    </p>
	  </div>
  </div>
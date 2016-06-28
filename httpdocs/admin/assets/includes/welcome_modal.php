<a href="#" data-reveal-id="intro-modal" class="reveal-link hide"  data-animation="fadeAndPop" data-animationspeed="300" data-closeonbackgroundclick="true" data-dismissmodalclass="close-reveal-modal"
>Modal in a modal</a>

<!-- Reveal Modals begin -->
<!-- Reveal Modals begin -->
<div id="intro-modal" class="reveal-modal xlarge welcome-modal" data-reveal aria-labelledby="intro-modal-title" aria-hidden="true" role="dialog">
  <?php require('modals/welcome-modal-intro.php'); ?>
</div>

<div id="profile-modal" class="reveal-modal xlarge welcome-modal" data-reveal aria-labelledby="profile-modal-title" aria-hidden="true" role="dialog">
  <?php require('modals/welcome-modal-profile.php'); ?>
</div>

<div id="payment-modal" class="reveal-modal xlarge welcome-modal" data-reveal aria-labelledby="profile-modal-title" aria-hidden="true" role="dialog">
  <?php require('modals/welcome-modal-payment.php'); ?>
</div>

  

<script>
	$(document).foundation().foundation();

	// trigger by event
	$('a.reveal-link').trigger('click');
	$('a.close-reveal-modal').trigger('click');
</script>

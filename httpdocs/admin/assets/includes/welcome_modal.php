
<?php
	$_SESSION['show_welcome_modal'] = '1';
?>
<input type="hidden" value="<?php echo $adminController->user->data['user_login_count']; ?>" id="user_login"/>
<input type="hidden" value="<?php echo $_SESSION['show_welcome_modal']; ?>" id="show_welcome_modal"/>

<!-- Reveal Modals begin -->
<div id="intro-modal" class="reveal-modal small welcome-modal border-radius-10x" data-reveal aria-labelledby="intro-modal-title" aria-hidden="true" role="dialog">
  <?php require('modals/welcome-modal-intro.php'); ?>
</div>

<div id="to-know-modal" class="reveal-modal small welcome-modal border-radius-10x" data-reveal aria-labelledby="to-know-modal-title" aria-hidden="true" role="dialog">
  <?php require('modals/least-to-know-modal.php'); ?>
</div>

<div id="profile-modal" class="reveal-modal small welcome-modal border-radius-10x" data-reveal aria-labelledby="profile-modal-title" aria-hidden="true" role="dialog">
  <?php require('modals/welcome-modal-profile.php'); ?>
</div>

<div id="payment-modal" class="reveal-modal small welcome-modal border-radius-10x" data-reveal aria-labelledby="payment-modal-title" aria-hidden="true" role="dialog">
  <?php require('modals/welcome-modal-payment.php'); ?>
</div>

<div id="social-modal" class="reveal-modal small welcome-modal border-radius-10x" data-reveal aria-labelledby="social-modal-title" aria-hidden="true" role="dialog">
  <?php require('modals/welcome-modal-social.php'); ?>
</div>

<div id="last-modal" class="reveal-modal small welcome-modal border-radius-10x" data-reveal aria-labelledby="last-modal-title" aria-hidden="true" role="dialog">
  <?php require('modals/welcome-modal-last-step.php'); ?>
</div>
  
<script>
	$(document).foundation().foundation();
	// trigger by event
  if($('#user_login').val() == 0 && $('#show_welcome_modal').val() != 1 ){
	   $('a.reveal-link').trigger('click');
  }
	$('a.close-reveal-modal').trigger('click');
</script>

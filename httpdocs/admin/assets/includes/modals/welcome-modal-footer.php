<?php 

  $current_intro = isset($current_intro) ? $current_intro : '';
  $current_profile = isset($current_profile) ? $current_profile : '';
  $current_payment = isset($current_payment) ? $current_payment : '';
  $current_social = isset($current_social) ? $current_social : '';
  $current_last = isset($current_last) ? $current_last : '';
  $current_to_know = isset($current_to_know) ? $current_to_know : '';

?>

<!--<div class="column small-12 welcome-modal-footer">-->
    <p class=" small-2 large-3 columns"><a class="close-reveal-modal" aria-label="Close">Skip <label class="show-for-large-up"> set-up</label></a></p>
    
    <div class="small-7 large-6 columns pagination-centered no-padding">
      <ul role="pagination" class="small-12 columns pagination no-padding" >
        <li class="<?php echo $current_intro; ?>"><a href="#" data-reveal-id="intro-modal"><i class="fa fa-circle" aria-hidden="true"></i></a></li>
        <li class="<?php echo $current_to_know; ?>"><a href="#" data-reveal-id="to-know-modal"><i class="fa fa-circle" aria-hidden="true"></i></a></li>
        <li class="<?php echo $current_profile; ?>"><a href="#" data-reveal-id="profile-modal"><i class="fa fa-circle" aria-hidden="true"></i></a></li>
        <li class="<?php echo $current_payment; ?>"><a href="#" data-reveal-id="payment-modal" ><i class="fa fa-circle" aria-hidden="true"></i></a></li>
        <li class="<?php echo $current_social; ?>"><a href="#" data-reveal-id="social-modal"><i class="fa fa-circle" aria-hidden="true"></i></a></li>
        <li class="<?php echo $current_last; ?>"><a href="#" data-reveal-id="last-modal"><i class="fa fa-circle" aria-hidden="true"></i></a></li>
      </ul>
    </div>
   
   <!-- <p class="small-3 large-3 columns align-right no-padding-right"><a href="#" data-reveal-id="profile-modal" class="secondary next-modal-step"><label class="show-for-large-up"> GO TO </label> STEP 1<i class="fa fa-chevron-right" aria-hidden="true"></i></a></p>
  
</div>-->
	<?php 
		$deducted_payment = $total_deducted = $your_contribution = $our_contribution = $total_contribution =  0;

		if(isset($orderExist) && $orderExist){
			$orderExist = $orderExist[0];

			$deducted_payment = $orderExist->amount_commit;
			$total_deducted = $to_be_pay - $deducted_payment;
			$your_contribution = $orderExist->amount_commit;
			$our_contribution = $orderExist->amount_match;
			$total_contribution = $orderExist->total_commit;
		}
	?>
	<div class="small-12 columns radius order-info" id="order-info-box">
		<h3 class="margin-top bold">YOUR ORDER</h3>

		<p class="font-small">Please review your order before submitting. Once submitted, your order cannot be reversed. </p>
		<form id="order-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
		<input type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
		<input type="hidden" name="user_email" value="<?php echo $email; ?>"/>
		<input type="hidden" value="<?php echo $to_be_pay; ?>" name="to_be_pay" id="to_be_pay" />
		<input type="hidden" value="<?php echo $contributor_id; ?>" name="contributor_id" id="contributor_id" />
		<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
		
		<div id="order-info-innerbox">
			<div class="small-12 margin-bottom">
				<h4>DEADLINE FOR THIS MONTH:<span class="uppercase" id="month-deadline"><?php echo date('M').'.22'?></span></h4>
				<label class="font-small uppercase">Money Committed will be spent the following month.</label>
			</div>

			<div class="small-12 margin-top margin-bottom   columns no-padding ">
				<h5 class="small-12 uppercase main-color   columns no-padding ">YOUR PAYMENTS</h5>
				<div class="small-12  columns no-padding payment-info">
					<p class="small-12 columns no-padding">NEXT SCHEDULED PAYMENT: <span id="schedule-payment" name="schedule-payment" data-bonus="<?php echo $to_be_pay; ?>"><?php echo '$'.number_format( $to_be_pay, 2); ?></span></p>
					<p class="small-12 columns no-padding">AMOUNT TO BE DEDUCTED:  <span id="deducted-payment" name="deducted-payment"><?php echo '-$'.number_format( $deducted_payment, 2); ?></span></p>
					<p class="small-12 columns no-padding bold">NEW SCHEDULED PAYMENT (YOU'LL RECEIVE): <span id="total-deducted" name="total-deducted"><?php echo '$'.number_format( $total_deducted, 2); ?></span></p>
				</div>
			</div>

			<div class="small-12 margin-top margin-bottom   columns no-padding ">
				<h5 class="small-12 uppercase main-color   columns no-padding ">PROMOTING YOUR POSTS</h5>
				<div class="small-12 payment-info   columns no-padding ">
					<p class="small-12 columns no-padding">YOUR CONTRIBUTION: <span id="your-contribution" name="your-contribution"><?php echo '$'.number_format( $your_contribution, 2); ?></span></p>
					<p class="small-12 columns no-padding">OUR CONTRIBUTION: <span id="our-contribution" name="our-contribution" class="border-bottom"><?php echo '$'.number_format( $our_contribution, 2); ?></span></p>
					<p class="small-12 columns no-padding bold">TOTAL TO BE SPENT PROMOTING YOUR POSTS: <span id="total-contribution" name="total-contribution"><?php echo '$'.number_format( $total_contribution, 2); ?></span></p>
				</div>
			</div>

			<?php if( $orderExist){ ?>
				<div class="small-12 columns margin-top margin-bottom  agree-box">
					<label class="main-color center uppercase small-12 columns order-submitted" >Your order was already summited for this month. Thanks</label>
				</div>
			<?php }else{?>
			<div class="small-12 columns margin-top margin-bottom agree-box">
				<label class="main-color center uppercase small-12 columns order-error hide" ></label>

				<input  id="agree" name="agree" type="checkbox"> 
				<label class="agree-element small-1 columns"></label>
				<label class="main-color small-11 columns" for="agree">YES I AGREE TO THE ABOVE AND REQUEST TO TAKE PART IN ADVERTISING MATCHING</label>
			</div>

			<div class="small-12 columns right">
				<input type="button" value="SUBMIT" id="submit-order" />
			</div>
			<?php } ?>
		</div>
		</form>
	</div>

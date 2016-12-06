<?php 
		
		$to_be_pay = isset( $data['total_earnings'] )? $data['total_earnings'] : 0;
		$deducted_payment = isset( $data['amount_commit'] )? $data['amount_commit'] : 0;
		$total_deducted = $to_be_pay - $deducted_payment;
		$your_contribution = isset( $data['amount_commit'] )? $data['amount_commit'] : 0;
		$our_contribution = isset( $data['amount_match'] )? $data['amount_match'] : 0;
		$total_contribution = $your_contribution + $our_contribution;
	
		$msg_email .= '<div id="order-info-innerbox">';
			$msg_email .= '<div class="small-12 margin-bottom"> ';
			$msg_email .= '<p style="font-size:18px; line-height: 1.3;">Congratulations! You’ve successfully signed up for Ad Matching. </p><p>Please review the details below:</p>';
		$msg_email .= '</div> ';

		$msg_email .= '<div> ';
			$msg_email .= '	<h3 style="color: #888; font-weight: normal;text-transform: uppercase; font-size: 17px;">YOUR PAYMENTS</h3>';
			$msg_email .= '	<div >';
			$msg_email .= '	<p style="font-size: 15px;">NEXT SCHEDULED PAYMENT: <span style="float:right;"  id="schedule-payment" name="schedule-payment" data-bonus="'.$to_be_pay.'">$'.number_format( $to_be_pay, 2).'</span></p>';
			$msg_email .= '	<p style="font-size: 15px;">AMOUNT TO BE DEDUCTED:  <span style="float:right;"  id="deducted-payment" name="deducted-payment">-$'.number_format( $deducted_payment, 2).'</span></p>';
			$msg_email .= '	<hr /><p style="font-size: 15px; font-weight: bold;">NEW SCHEDULED PAYMENT (YOU\'LL RECEIVE): <span style="float:right;"  id="total-deducted" name="total-deducted">$'.number_format( $total_deducted, 2).'</span></p>';
			$msg_email .= '	</div>';
		$msg_email .= '</div>';

		$msg_email .= '<div style="margin-top:40px;"> ';
		$msg_email .= '	<h3 style="color: #888; font-weight: normal;text-transform: uppercase; font-size: 17px;">PROMOTING YOUR POSTS</h3> ';
		$msg_email .= '	<div > ';
		$msg_email .= '		<p style="font-size: 15px;">YOUR CONTRIBUTION: <span style="float:right;"  id="your-contribution" name="your-contribution">$'.number_format( $your_contribution, 2).'</span></p>';
		$msg_email .= '		<p style="font-size: 15px;">OUR CONTRIBUTION: <span style="float:right;"  id="our-contribution" name="our-contribution" class="border-bottom">$'.number_format( $our_contribution, 2).'</span></p>';
		$msg_email .= '<hr /><p style="font-size: 15px; font-weight: bold;" >TOTAL TO BE SPENT PROMOTING YOUR POSTS: <span style="float:right;" id="total-contribution" name="total-contribution">$'.number_format( $total_contribution, 2).'</span></p>';
		$msg_email .= '	</div> ';
		$msg_email .= '</div>';
	$msg_email .= '</div>';

?>
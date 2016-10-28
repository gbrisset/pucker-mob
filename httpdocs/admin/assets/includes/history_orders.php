<?php
	$admin = true; 
	require_once('../../../assets/php/config.php');

	$current_date = date("m/d/Y");

	$AdMatchingTransactions = new AdMatchingTransactions();

	$contributor_id = isset($_POST['contributor_id']) ? $_POST['contributor_id'] : 0;
	
	$transactions = $AdMatchingTransactions->where('contributor_id = '.$contributor_id);

	?>
		<div id="order-history" class="">
		
		<table class="columns small-12">
			<thead>
				<tr>
					<td width="200">RECEIPT</td>
					<td width="200">SPENT</td>
					<td width="200">DATE</td>
					<td width="200">BALANCE</td>
					<td></td>
				</tr>
			</thead>
			<tbody>

			<?php if($transactions ){ 
					foreach($transactions as $transaction ){ ?>
					<tr>
						<?php if($transaction->receipt == 1){?>
						<td width="200">
							<div>
								<label>SENT <i class="fa fa-check main-color" aria-hidden="true" ></i></label>
								<input type="checkbox" name="receipt_sent" checked class="hidden receipt_sent"/>
							</div>
						</td>
						<?php }else{?>
							<td width="200">
								<div><label>SEND<input type="checkbox" name="receipt_sent" class="receipt_sent" style="margin: 10px; top: 5px; position: relative;"/></div>
							</td>
						<?php }?>
						<td width="200"><div><label><?php echo '$'.number_format( $transaction->spent, 2); ?></label></div></td>
						<td width="200"><div><label><?php echo date("n/d/Y", strtotime($transaction->date)); ?></label></div></td>
						<td width="200"><div><label><?php echo '$'.number_format( $transaction->balance, 2);  ?></label></div></td>
						<td></td>
					</tr>
				<?php }
				} ?>

			</tbody>
		</table>
		<label id="add-history" name="add-history" class="add-history-link clear">+ROW</label>
	</div>

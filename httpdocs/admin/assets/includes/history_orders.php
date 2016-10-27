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
					foreach($transactions as $transaction ){?>
					<tr>
						<td width="200"><div><label>SEND<input type="checkbox" name="receipt_sent" /></div></td>
						<td width="200"><?php echo $transaction->spent; ?></td>
						<td width="200"><?php echo date("m/d/Y", $transaction->date); ?></td>
						<td width="200"><?php echo $transaction->balance; ?></td>
						<td></td>
					</tr>
				<?php }
				} ?>

			</tbody>
		</table>
		<label id="add-history" name="add-history" class="add-history-link clear">+ROW</label>
	</div>

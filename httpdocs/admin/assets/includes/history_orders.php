<?php
	$admin = true; 
	require_once('../../../assets/php/config.php');

	$current_date = date("m/d/Y");

	$AdMatchingTransactions = new AdMatchingTransactions();

	$contributor_id = isset($_POST['contributor_id']) ? $_POST['contributor_id'] : 0;
	
	$transactions = $AdMatchingTransactions->where('contributor_id = '.$contributor_id);
	var_dump($transactions);

	if($transactions ){ ?>
		<div class="">
		<table class="columns small-12">
			<thead>
				<tr>
					<td>RECEIPT</td>
					<td>SPENT</td>
					<td>DATE</td>
					<td>BALANCE</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($transactions as $transaction ){?>
				<tr>
					<td><div><label>SEND<input type="checkbox" name="receipt_sent" /></div></td>
					<td><?php echo $transaction->spent; ?></td>
					<td><?php echo date("m/d/Y", $transaction->date); ?></td>
					<td><?php echo $transaction->balance; ?></td>
				</tr>
				<?php }?>
				<tr>
					<td><a href="" id="add-history" >+ROW</a></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php }else{ ?>
		<p>No Transactions.</p>
	<?php } ?>

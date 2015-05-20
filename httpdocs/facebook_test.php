<?php 
	use FacebookAds\Object\AdAccount;

$account = new AdAccount('act_10153089858892936');

$stats = $account->getReportsStats(array(),
  array(
    'data_columns' => array(
      'account_id', 'total_actions', 'spend',
    ),
    'date_preset' => 'last_7_days',
  )
);
?>
<?php 

require '../class.User.php';

$user = new User('fguzman@sequelmediagroup.com');
$contributor = new Contributor($user->getUserEmail());
$contributorEarnings = new contributorEarnings($contributor);
$contributorEarningsRate = $contributorEarnings->getRate(3, 2016, 8);

var_dump($contributorEarningsRate);
var_dump($contributorEarnings->rate, $contributorEarnings->month_label);


?>
<?php

require 'facebook.php';

$facebook = new Facebook(array(
	'appId' => '1380320725609568',
	'secret' => '1660831cfa198d28dcfc1748454e4ca7'
));

$facebook->destroySession();
header('Location: index.php');
?>
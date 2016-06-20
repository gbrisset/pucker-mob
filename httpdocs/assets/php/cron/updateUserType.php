<?php

	require '../class.User.php';

	$user = new User('fguzman@sequelmediagroup.com');


	$user_id = $user->getUserId();
	$user_name = $user->getUserName();
	$user_type = $user->getUserType();

	$pageviews = 1000;
	$post = [
		'user_id' => '960',
		'user_type' => 3
	];

	if($pageviews && $pageviews >= 1000 ){
		var_dump($user_id, $user_name, $user->getUserType());

		$user->setUserType($post);
	}

?>

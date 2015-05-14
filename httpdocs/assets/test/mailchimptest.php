<?php
require_once('../php/config.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

$userList = $mpArticle->getUserList();
$email = $lastname = $fullname = $name = '';
$nameArr = [];
foreach( $userList as $user){
	$email = $user['user_email'];
	$fullname = $user['user_first_name'].' '.$user['user_last_name'];
	$nameArr = explode(" ", $fullname);
	
	if(count($nameArr) > 1 ){
		$name = $nameArr[0];
		$lastname = $nameArr[1];
	}
//var_dump($name, $lastname); 
	$result = $MailChimp->call('lists/subscribe', array(
        		'id'                => MAIL_CHIMP_SUBS_LIST,
                'email'             => array('email'=> $email),
                'merge_vars'        => array('FNAME'=>$name, 'LNAME'=>$lastname),
                'double_optin'      => false,
                'update_existing'   => true,
                'replace_interests' => false,
                'send_welcome'      => false,
            ));
	
	print_r($result);

}
?>
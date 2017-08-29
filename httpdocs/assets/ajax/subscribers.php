<?php
require_once('../php/config.php');
$email = $_POST['email'];
$articleId = $_POST['articleId'];

if(isset($email) && !empty($email)){
	
	 try{
	 	
	 	$result = $mpArticle->insertSubscribers( $articleId, $email );
        
	 	return ['haserror' => false, 'msg'=> 'Email added Successfully.'];

	 }catch (Exception $e) {
	   // echo 'Caught exception: ',  $e->getMessage(), "\n";
	 		return ['haserror' => true, 'msg' => "ouch an error occurred."]
	}
}else{
	return ['haserror' => true, 'msg' => "Your email is empty."]
}


?>
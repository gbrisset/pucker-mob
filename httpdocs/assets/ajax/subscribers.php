<?php
require_once('../php/config.php');
$email = $_POST['email'];
$articleId = $_POST['articleId'];

if(isset($email) && !empty($email)){
	
	 try{
	 	
	 	$result = $mpArticle->insertSubscribers( $articleId, $email );
        
	 	echo $result;

	 }catch (Exception $e) {
	    echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}


?>
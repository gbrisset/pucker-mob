<?php
require_once('../php/config.php');
$fbShares = $_POST['count'];
$articleId = $_POST['articleId'];

$url = 'http://www.puckermob.com/entertainment/70-things-you-can-score-with-your-student-id';//((!empty($_SERVER['HTTPS'])) ? "https://": "http://" ) . $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$apikey = "709226bb97515fd204f07c3d4bac38f78ba009eb";
$json = file_get_contents("http://free.sharedcount.com/?url=" . rawurlencode($url) . "&apikey=" . $apikey);
$counts = json_decode($json, true);
$month = date("n");

 try{
 	//$mpArticle->updateFBShares( $fbShares, $articleId );
 	$mpArticle->updateSocialMediaShares( $counts, $articleId, $month );
 }catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
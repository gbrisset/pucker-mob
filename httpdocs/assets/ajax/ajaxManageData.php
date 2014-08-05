<?php
require_once('../php/config.php');
$fbShares = $_POST['count'];
$articleId = $_POST['articleId'];


 try{
  $mpArticle->updateFBShares( $fbShares, $articleId );
 }catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
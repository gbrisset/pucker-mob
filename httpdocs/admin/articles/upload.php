<?php

$admin = true;

require_once('../../assets/php/config.php');
/*

case isset($_FILES['article_post_tall_img']):
					$updateStatus = array_merge($mpArticleAdmin->uploadNewImage($_FILES, [
						'allowedExtensions' => 'png,jpg,jpeg,gif',
						'imgType' => 'article',
						'uploadDirectory' => $config['image_upload_dir'].'articlesites/puckermob/large/',
						'articleId' => $article['article_id'],
						'imgData' => $_POST,
						'whereClause' => 'article_id = '.$article['article_id'],
						'desWidth' => 405,
						'desHeight' => 415
					]), ['arrayId' => 'article-tall-image-upload-form']);*/
$ds          = DIRECTORY_SEPARATOR;  //1
 
$storeFolder = 'uploads';   //2


if (!empty($_FILES)) {
     $updateStatus = array_merge($mpArticleAdmin->uploadNewImage($_FILES, [
						'allowedExtensions' => 'png,jpg,jpeg,gif',
						'imgType' => 'article',
						'uploadDirectory' => $config['image_upload_dir'].'articlesites/puckermob/large/',
						'articleId' => $_POST['a_i'],
						'imgData' => $_POST,
						'whereClause' => 'article_id = '.$_POST['a_i'],
						'desWidth' => 784,
						'desHeight' => 431
					]), ['arrayId' => 'article-tall-image-upload-form']);

  

    //$tempFile = $_FILES['file']['tmp_name'];          //3             
  
   // $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
     
   // $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
   // move_uploaded_file($tempFile,$targetFile); //6
     
}
?>     
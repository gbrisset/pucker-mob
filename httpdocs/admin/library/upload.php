<?php

$admin = true;

require_once('../../assets/php/config.php');

$ds = DIRECTORY_SEPARATOR;  //1
$storeFolder = 'uploads';   //2

$user_id = 0;
if(isset($_POST['u_i'])) $user_id = $_POST['u_i'];




	
	if (!empty($_FILES)) { 
	    $updateStatus = array_merge($mpArticleAdmin->uploadLibraryImage($_FILES, [
						'allowedExtensions' => 'png,jpg,jpeg,gif',
						'imgType' => 'article',
						'uploadDirectory' => '/assets/img/articles/',
						'articleId' => $_POST['a_i'],
						'imgData' => $_POST,
						'whereClause' => '',
						'desWidth' => 784,
						'desHeight' => 431
					]), ['arrayId' => 'article-tall-image-upload-form']);
		}
	

}
?>     
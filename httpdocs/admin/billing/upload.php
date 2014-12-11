<?php

$admin = true;

require_once('../../assets/php/config.php');

$ds          = DIRECTORY_SEPARATOR;  //1
 
$storeFolder = '';   //2

if (!empty($_FILES)) {
     $updateStatus = array_merge($mpArticleAdmin->uploadW2Form($_FILES, [
						'allowedExtensions' => 'pdf, docx, doc',
						'uploadDirectory' => $config['this_url'].'assets/forms/',
						'userID' => $userID,
						'data' => $_POST,
						]), ['arrayId' => 'w2-form-upload']);

}
?>     
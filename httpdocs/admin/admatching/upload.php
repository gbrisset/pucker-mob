<?php
/*
* Upload Screen Shots images as a prove of ad matching payment. 
* This is a feature only for admins 
*/

$admin = true;
require_once('../../assets/php/config.php');

$storeFolder = $config['image_upload_dir'].'articlesites/puckermob/admatching_ss/';
$contributor_id = isset($_REQUEST['c_i']) ? $_REQUEST['c_i'] : 0;

if (!empty($_FILES)) {
    foreach($_FILES as $file){
        if(substr($file['type'], 0, 5 ) === "image"){
            $tempFile = $_FILES['file']['tmp_name'];                  
            $targetFile =  $storeFolder;
            if($contributor_id > 0 ){
                $time = round(microtime(true));
            	$targetFile .=  $contributor_id.'_'.$time.'_'.rand(1, 100000).'.jpg';
            } 
            if ( !file_exists($targetFile)) {
                move_uploaded_file($tempFile,$targetFile);
            }
        }

    }
} else {                                                           
    $result  = array();
 
    $files = scandir($storeFolder); //GET ALL FILES
    $contributor_id = isset($_REQUEST['c_i']) ? $_REQUEST['c_i'] : 0;
    if ( false!== $files ) {
        foreach ( $files as $file ) { 
            if ( '.' != $file && '..' != $file) {    
                    $obj['name'] = $file;
                    $obj['size'] = filesize($storeFolder.$ds.$file);
                    $result[] = $obj;
            }
        }
    }
     
    header('Content-type: text/json');              //3
    header('Content-type: application/json');
    echo json_encode($result);
}
?>   
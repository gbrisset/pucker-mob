<?php

$admin = true;
require_once('../../assets/php/config.php');

$ds = DIRECTORY_SEPARATOR;  
$storeFolder = 'uploads';
$contributor_id = isset($_REQUEST['c_i']) ? $_REQUEST['c_i'] : 0;
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];                  
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
    
    $targetFile =  $targetPath;
    if($contributor_id > 0 ){
    	$targetFile .=  $contributor_id.'_'.date('m_d_Y');
    } 
    move_uploaded_file($tempFile,$targetFile);
     
}// else {                                                           
  /*  $result  = array();
 
    $files = scandir($storeFolder);     

    if ( false!==$files ) {
        foreach ( $files as $file ) {
            if ( '.'!=$file && '..'!=$file) {    
                $obj['name'] = $file;
                $obj['size'] = filesize($storeFolder.$ds.$file);
                $result[] = $obj;
            }
        }
    }
     
    header('Content-type: text/json');         
    header('Content-type: application/json');
    echo json_encode($result);*/
//}
?>   
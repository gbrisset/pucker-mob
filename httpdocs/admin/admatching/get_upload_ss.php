<?php
$admin = true;
require_once('../../assets/php/config.php');

$storeFolder = $config['image_upload_dir'].'articlesites/puckermob/admatching_ss/';
$contributor_id = isset($_REQUEST['c_i']) ? $_REQUEST['c_i'] : 0;

 $result  = array();
 
    $files = scandir($storeFolder); //GET ALL FILES
    $contributor_id = isset($_REQUEST['c_i']) ? $_REQUEST['c_i'] : 0;
    
    if ( false !== $files ) {
        foreach ( $files as $file ) { 
            if ( '.' != $file && '..' != $file) {    
                $pos = strpos($file, $contributor_id);
                if($pos !== false ){
                    $obj['name'] = $file;
                    $obj['size'] = filesize($storeFolder.$ds.$file);
                    $result[] = $obj;
                }
            }
        }
    }
     
    header('Content-type: text/json');             
    header('Content-type: application/json');
    echo json_encode($result);

?>
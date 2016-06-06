<?php

$admin = true;
require_once('../../assets/php/config.php');

$category = isset($_POST['library_category'] ) ? $_POST['library_category']  : false;
	
if( !$category )  echo json_encode(array( 'error' => true, 'message' => 'Please Select A Category' )) ;  	
else{

	$target_dir = $config['image_path_admin']."articles/";
	$target_file = $target_dir . basename( $_FILES["image-to-library"]["name"] );
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image


    $check = getimagesize($_FILES["image-to-library"]["tmp_name"]);
    if($check === false) {
        echo json_encode( array( 'error' => true, 'message' => 'This File is not an Image') );	
        $uploadOk = 0;
    }

    // Check if file already exists
	if (file_exists($target_file)) {
	    echo json_encode( array( 'error' => true, 'message' => 'Sorry, file already exists.' ) );
	    $uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	     echo json_encode( array( 'error' => true, 'message' => 'Sorry, your file was not uploaded.'));
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["image-to-library"]["tmp_name"], $target_file)) {
	    	$data = array(
	    		'category' => $category,
	    		'img_name' => $_FILES["image-to-library"]["name"] 
	    	);
	    	$inserting = $mpArticleAdmin->insertImagesPerCategory($data);
	        echo json_encode(array( 'error' => false, 'message' => 'The file '. basename( $_FILES["image-to-library"]["name"]). ' has been uploaded.' ));
	    } else {
	         echo json_encode(array( 'error' => true, 'message' => 'Sorry, there was an error uploading your file.'));
	    }
	}
}
?>     
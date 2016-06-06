<?php
$admin = true;
        require_once('../../assets/php/config.php');
        if(!$adminController->user->getLoginStatus()) $adminController->redirectTo('login/');
        $adminController->user->data = $adminController->user->getUserInfo();

        $lib_categories = $mpArticleAdmin->getImagesCategories();
        $status = true;
        if(isset($_POST['submit'])){
			$category = isset($_POST['library_category'] ) ? $_POST['library_category']  : false;
				
			if( !$category )  $status = array( 'error' => true, 'message' => 'Please Select A Category' ) ;  	
			else{

				$target_dir = $config['image_path_admin']."articles/";
				$target_file = $target_dir . basename( $_FILES["image-to-library"]["name"] );
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				// Check if image file is a actual image or fake image

			    $check = getimagesize($_FILES["image-to-library"]["tmp_name"]);
			    if($check === false) {
			        $status =  array( 'error' => true, 'message' => 'This File is not an Image');	
			        $uploadOk = 0;
			    }

			    // Check if file already exists
				if (file_exists($target_file)) {
				    $status =  array( 'error' => true, 'message' => 'Sorry, file already exists.' );
				    $uploadOk = 0;
				}

				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
				     $status = array( 'error' => true, 'message' => 'Sorry, your file was not uploaded.');
				// if everything is ok, try to upload file
				} else{
				    if (move_uploaded_file($_FILES["image-to-library"]["tmp_name"], $target_file)) {
				    	$data = array(
				    		'category' => $category,
				    		'img_name' => $_FILES["image-to-library"]["name"] 
				    	);
				    	$inserting = $mpArticleAdmin->insertImagesPerCategory($data);
				        $status =  array( 'error' => false, 'message' => 'The file '. basename( $_FILES["image-to-library"]["name"]). ' has been uploaded.' );
				    } else{
				         $status =  array( 'error' => true, 'message' => 'Sorry, there was an error uploading your file.');
				    }
				}
			}
        }

?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body id="library">
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<!-- SUB MENU ADMIN -->		
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div class="small-12">
				<h1>Manage Library</h1>
				
				<div class="small-12 columns no-padding margin-top upload-img-library-form">
					<form action="" method="post" enctype="multipart/form-data">
					   <span id="add-lib-image" class="margin-top margin-bottom uppercase"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Image</span>
					    <input type="file" name="image-to-library" id="image-to-library">
					    <select id="library_category" name="library_category" class="small-12 large-3 " required>
							<option value="0">Select Category</option>
							<option value="abstract">Abstract</option>
							<option value="animals_pets">Animals | Pets </option>
							<option value="people">People</option>
							<option value="food">Food | Dinning </option>
						</select>
					    <input class="button radius" type="submit" value="Upload Image" name="submit" />
					    <label class="uppercase <?php if($status['error'] === true ) echo ' error '; else echo ' success '?> ">
						<?php echo $status['message']; ?>
					</label>
					</form>
					
				</div>
			</div>
			
			

<section>
	<div>
		<div class="small-12 columns no-padding margin-top">
			<?php 
				if($lib_categories){
						foreach( $lib_categories as $img_category){  ?>
						<div class=" no-padding no-vertical-padding" data-info="<?php echo $img_category['seo_name']; ?>">
							<div class="lib_cat_desc">
								<h3 class="cat_section uppercase" data-info="<?php echo $img_category['seo_name']; ?>"><?php echo $img_category['name']; ?></h3>
							</div>
							<?php if(isset($img_category['seo_name'])){ ?>
							<div class="images-container">
								<?php  
									$data = [
										'category' => $img_category['seo_name']
									];
									$images = $mpArticleAdmin->getImagesPerCategory($data);
									if($images){
										foreach($images as $img ){?>
										<div class="small-4 large-1 columns padding-bottom"><img id="<?php echo $img['id'] ?>" src="<?php echo $config['this_admin_url'].'assets/img/articles/'.$img['img_name']?>" />
											<span id="remove-image"><i class="fa fa-times" aria-hidden="true"></i></span>
										</div>
										<?php }
									} ?>	
							</div>
							<?php } ?>
						</div>

					<?php }
				}
			?>
		</div>
	</div>
</section>
</div>
	</main>
</body>
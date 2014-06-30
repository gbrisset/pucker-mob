<?php
	if(!$adminController->user->checkPermission('user_permission_show_add_recipe')) $adminController->redirectTo('noaccess/');
	
	/*if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			switch(true){
				case isset($_FILES['article_post_tall_img']):
					$updateStatus = array_merge($mpArticleAdmin->uploadNewImage($_FILES, [
						'allowedExtensions' => 'png,jpg,jpeg,gif',
						'imgType' => 'article',
						'uploadDirectory' => $config['image_upload_dir'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/tall/',
						'articleId' => $article['article_id'],
						'imgData' => $_POST,
						'whereClause' => 'article_id = '.$article['article_id'],
						'desWidth' => 405,
						'desHeight' => 415
					]), ['arrayId' => 'article-tall-image-upload-form']);
				
					break;

			}
			$article = $adminController->getSingleArticle(array('seoTitle' => $uri[2]));
		}else $adminController->redirectTo('logout/');
	}*/
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			$updateStatus = $adminController->addArticle($_POST);
			$updateStatus['arrayId'] = 'article-add-form';
			if(isset($updateStatus['hasError']) && !$updateStatus['hasError']) $_POST = array();
		}else $adminController->redirectTo('logout/');
	}

	//Verify if is a content provider user
	$content_provider = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 3 || $adminController->user->data['user_type'] == 4){
		$content_provider = true;
		$contributorInfo = $mpArticle->getContributors(['contributorEmail' => $adminController->user->data['user_email']])['contributors'];

		$contributorInfo = $contributorInfo[0];
	}
	
		

?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
	<?php include_once($config['include_path_admin'].'header.php');?>

	<div id="main-cont">
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content">
			<section id="article-info">
				<header class="section-bar">
					<h2>Add New Recipe</h2>
				</header>

				<form  class="ajax-submit-form" id="article-add-form" name="article-add-form" action="<?php echo $config['this_admin_url']; ?>articles/newrecipe/" method="POST">
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

					<fieldset>
						<label for="article_title-s">Recipe Title<span>*</span> :</label>
						<input type="text" name="article_title-s" id="article_title-s" placeholder="ex: Chicken with Spinach and Zucchini Skillet" maxlength="50"  value="<?php if(isset($article['article_title'])) echo $article['article_title']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_title') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>Please provide a title for your recipe, 50 characters maximum</p>
							</div>
						</div>
					</fieldset>

					<?php if(!$content_provider){?>
					<fieldset>
						<label for="article_seo_title-s">Recipe SEO Title<span></span> :</label>
						<input type="text" name="article_seo_title-s" id="article_seo_title-s" placeholder="Recipe Seo-formatted Title." value="<?php if(isset($article['article_seo_title'])) echo $article['article_seo_title']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_seo_title') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>This is the recipe's title that will be used in URLs throughout the site.</p>
							</div>
						</div>
					</fieldset>
					<?php }?>

					<fieldset>
						<label for="article_desc-s">Recipe Description<span>*</span> :</label>
						<input type="text" name="article_desc-s" id="article_desc-s" placeholder="ex: In cold weather, there’s no better way to warm up than with a comforting bowl of soup. This hearty soup is loaded with ..." maxlength="150" value="<?php if(isset($article['article_desc'])) echo $article['article_desc']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_desc') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>Please provide a short description introducing your recipe, 150 characters maximum. This description will appear underneath the title of your recipe on the search results page.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_tags-s">Recipe Keywords :</label>
						<input type="text" name="article_tags-s" id="article_tags-s" placeholder="ex: Meatless, Gluten-free, Detox, Antioxidant, All-Natural, One Pot, Chicken" value="<?php if(isset($article['article_tags'])) echo $article['article_tags']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_tags') echo 'autofocus'; ?> />

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>Please enter keywords that will help people search for your recipe. Keywords should include terms that are relevant to your recipe like ingredients, categories and descriptive nouns.</p>
							</div>
						</div>
					</fieldset>
				

					<fieldset>
						<label for="article_yield-nf">Yield <span>*</span> :</label>
						<select name="article_yield-s" id="article_yield-s" class="recipe-select" required>
							<?php 
								for($i = 0; $i<= 50; $i++){
									//	for 0, empty the value="", so 'required' attribute can be used in the select element, display a '-'
									if ($i == 0){
										echo '<option value="">-</option>';
									} else {
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								}
							?>
						</select>

						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>Please indicate how many servings this recipe yields.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_prep_time-nf">Prep Time <span>*</span> :</label>
						<div class="prep-time-container">
							<select name="article_prep_time_hr-s" id="article_prep_time_hr-s" class="recipe-select">
								<?php for($i = 0; $i<= 10; $i++){
									//	for 0, set the value="0", this is NOT a required selection, also display a '-' 
									if ($i == 0){
										echo '<option value="'.$i.'">-</option>';
									} else {
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								}?>
							</select>
							<span>HRS</span>
						</div>
						<div class="prep-time-container">
							<select name="article_prep_time_min-s" id="article_prep_time_min-s" class="recipe-select" required>
								<?php for($i = 0; $i<= 59; $i++){
									//	for 0, empty the value="", so 'required' attribute can be used in the select element, display a '-'
									if ($i == 0){
										echo '<option value="">-</option>';
									} else {
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								}?>
							</select>
							<span>MIN</span>
						</div>
						
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>Please indicate how long it takes to prepare this recipe, not including cook time.</p>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<label for="article_cook_time-nf">Cook Time : </label>
						<div class="prep-time-container">
							<select name="article_cook_time_hr-s" id="article_cook_time_hr-s" class="recipe-select">
								<?php for($i = 0; $i<= 10; $i++){
									//	for 0, set the value="0", this is NOT a required selection (not all recipes have cook times), also display a '-' 
									if ($i == 0){
										echo '<option value="'.$i.'">-</option>';
									} else {
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								}?>
							</select>
							<span>HRS</span>
						</div>
						<div class="prep-time-container">
							<select name="article_cook_time_min-s" id="article_cook_time_min-s" class="recipe-select">
								<?php for($i = 0; $i<= 59; $i++){
									//	for 0, set the value="0", this is NOT a required selection (not all recipes have cook times), also display a '-' 
									if ($i == 0){
										echo '<option value="">-</option>';
									} else {
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
								}?>
							</select>
							<span>MIN</span>
						</div>
					
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>Please indicate how long it takes to cook this recipe, not including prep time.</p>
							</div>
						</div>
					</fieldset>

					<header class="section-bar">
						<h3>Add Ingredients</h3>
					</header>
					<fieldset class="ingredients-box" id="ingredients-1">
						<label for="article_ingredients_1-nf">Ingredients<span>*</span> :</label>
						<input type="text" placeholder="ex: 1/2 Cup Flour" class="article_ingredients-nf" id="article_ingredients-1-nf-1" name="article_ingredients-1-nf-1" >
						
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">
							<div class="tooltip-info">
								<p>Please input ingredients, one in each field. Does your recipe require a secondary ingredient set for a sauce, glaze or icing? If so, click here to enter another set of ingredients.</p>
							</div>
						</div>

						<div id="elements-box" data-info="article_ingredients-nf"  data-label="ingredients">
							<div class="input-elements"></div>
							<div class="add-element">
								<a href="" class="add-element-link" name = "add-element-link"><i class="icon-plus-sign"></i>Add Ingredient</a>
							</div>
						</div>
					
					</fieldset>
					
					<h3 class="long-label">Would you like to add another set of ingredients?</h3>
					<fieldset>
						<label></label>
						<input type="radio" name="more_ingredients" data-info="ingredients" id="more-ingredients-yes" value="1" />
						<label for="more-ingredients-yes" class="radio-label">Yes</label>
								
						<input type="radio" name="more_ingredients" id="more-ingredients-no" value="0" checked />
						<label for="more-ingredients-no" class="radio-label">No</label>

					</fieldset>
					
					<header class="section-bar">
						<h3>Add Instructions</h3>
					</header>
					<fieldset class="instructions-box" id="instructions-1">
						<label for="article_instructions-nf">Instructions<span>*</span> :</label>
						<input type="text" placeholder="ex: Heat olive oil in a large skillet over medium high heat." class="article_instructions-nf" id="article_instructions-1-nf-1" name="article_instructions-1-nf-1" >
						
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">
							<div class="tooltip-info">
								<p>Please input instructions, one in each field. Does your recipe require a secondary instruction set for a sauce, glaze or icing? If so, click here to enter another set of instructions.</p>
							</div>
						</div>

						<div id="elements-box" data-info="article_instructions-nf" data-label="instructions">
							<div class="input-elements"></div>
							<div class="add-element">
								<a href="" class="add-element-link" name = "add-element-link"><i class="icon-plus-sign"></i>Add Instructions</a>
							</div>
						</div>
					</fieldset>

					<h3 class="long-label">Would you like to add another set of instructions?</h3>
					<fieldset>
						<label></label>
						
						<input type="radio" name="more_instructions"  data-info="instructions" id="more-instructions-yes" value="1" />
						<label for="more-instructions-yes" class="radio-label">Yes</label>
								
						<input type="radio" name="more_instructions" id="more-instructions-no" value="0" checked />
						<label for="more-instructions-no" class="radio-label">No</label>
					</fieldset>

					<header class="section-bar">
						<h3>Comments &amp; Categories</h3>
					</header>
					<fieldset>
						<label for="additional-comments">Comments:</label>
						<textarea name="article_additional_comments-nf" id="article_additional_comments-nf" rows="10" placeholder="Please enter additional comments here." ></textarea>
						<div class="tooltip">
							<img src="<?php echo $config['image_url'].'articlesites/sharedimages/admin/'; ?>tooltip.png" alt="Tooltip Icon">

							<div class="tooltip-info">
								<p>Add addtional comments for this recipe</p>
							</div>
						</div>
					</fieldset>

					<?php
					if(!$content_provider){
						$allContributors = $adminController->getSiteObjectAll(array('queryString' => 'SELECT * FROM article_contributors ORDER BY contributor_name ASC'));
						if($allContributors && count($allContributors)){
					?>
						<fieldset>
							<label for="article_contributor">Article Contributor<span>*</span> :</label>
							<select name="article_contributor" id="article_contributor">
								<option value="-1">None</option>
								<?php
									foreach($allContributors as $contributorInfo){
										$option = '<option value="'.$contributorInfo['contributor_id'].'"';
										if(isset($contributorInfo['contributor_id']) && isset($_POST['article_contributor']) && $contributorInfo['contributor_id'] == $_POST['article_contributor']) $option .= ' selected="selected"';
										$option .= '>'.$contributorInfo['contributor_name'].'</option>';
										echo $option;
									}
								?>
							</select>
						</fieldset>
					<?php } 
				}else{ ?>
					<input type="hidden"  name="article_contributor" id="article_contributor" value="<?php echo $contributorInfo['contributor_id']?>" />
				<?php } ?>

				<?php
				if(!$content_provider){
					$allVideos = $adminController->getSiteObjectAll(array('queryString' => 'SELECT * FROM syndication_videos ORDER BY syn_video_title ASC'));
					if($allVideos && count($allVideos)){
				?>
						<fieldset>
							<label for="article_video">Related Video:</label>
							<select name="article_video" id="article_video">
								<option value="-1">None</option>
								<?php
									foreach($allVideos as $videoInfo){
										$option = '<option value="'.$videoInfo['syn_video_id'].'"';
										if(isset($_POST['article_video']) && $videoInfo['syn_video_id'] == $_POST['article_video']) $option .= ' selected="selected"';
										$option .= '>'.$videoInfo['syn_video_title'].'</option>';
										echo $option;
									}
								?>
							</select>
						</fieldset>
					<?php } 
				}?>

				<?php
					$allCategories = $MPNavigation->getAllCategoriesWithArticles();
					if($allCategories && count($allCategories)){
				?>
					<fieldset>
							<label class="checkbox-group-label-parent">Categories<span>*</span> :</label>
							<p class="p-message">Categorize your recipe choosing up to 5 categories. </p>
							<section class="checkbox-group-content">
							<?php
								foreach($allCategories as $category){ 
									if(!$category['cat_is_brand']){
									$checkbox = '<div class="checkbox-group">';
										$checkbox .= '<input type="checkbox" id="category-'.$category['cat_id'].'" name="article_categories[category-'.$category['cat_id'].']"';
										if(isset($_POST['article_categories']) && isset($_POST['article_categories']['category-'.$category['cat_id']])){
											$checkbox .= ' checked="checked"';
										}
										$checkbox .= ' />';
										$checkbox .= '<label class="checkbox-label" for="category-'.$category['cat_id'].'">'.$category['cat_name'].'</label>';
									$checkbox .= '</div>';
									
									echo $checkbox;
									}
								}
							?>
						</section>
						</fieldset>
				<?php } ?>

					<fieldset>
						<div class="btn-wrapper">
							<button type="submit" id="submit" name="submit">Save</button>
							<p class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-add-form') echo ($updateStatus['hasError'] == true) ? 'error' : 'success'; else echo 'success'; ?>" id="result">
								<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-add-form') echo $updateStatus['message']; else echo "Next Step: Add an Image"; ?>
							</p>
						</div>
					</fieldset>
				</form>
			</section>

			<!-- Image Sections -->
			<section id="article-inline-settings" style="display:none;">
					<header class="section-bar">
						<h2 class="left">Recipe Image</h2>
					</header>
					
					<fieldset id="add-an-image-fs">
							<div class="image-steps image-sec">
								<div id="image-container">
									<img src="http://images.simpledish.com/articlesites/sharedimages/recipe_default_image.jpg" alt="Default Image" />
									<span><a id="change-art-image" href=""><i class="icon-picture"></i>Change Photo</a></span>
								</div>
							</div>
							
							<div class="image-steps">
								<header class="section-bar">
									<h2>Add an Image to your recipe</h2>
								</header>
								<fieldset>
							    	<div class="file-upload-container">
								        <span>
								        	<button name="image-file-link" id="image-file-link" type="button"><i class="icon-plus-sign"></i>Add Image</i></button>
								        </span>
								    </div>
							        <div id="rules">
							        	<span>Make sure the image selected:</span>
							        	<ul>
							        	<li>Must be: .jpg, .jpeg, .gif, or .png type.</li>
		    							<li>Do not exceed a maximum size: 1 MB.</li>
		    							<li>Has a minimun dimensions of  405 x 415</li>
							        </div>
						        </fieldset>
						         <p id="error-img" class="error-img"></p>
						    </div>
					</fieldset>
					<div class="<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-wide-image-upload-form') echo ($updateStatus['hasError'] == true) ? 'error-img show-err' : 'success-img'; ?>" id="result">
						<?php if(isset($updateStatus) && $updateStatus['arrayId'] == 'article-wide-image-upload-form') echo $updateStatus['message']; ?>
					</div>
			</section>

			<section>
				<fieldset>
					<div>
						<div data-preview='' class="preview-art-container" ></div>
					</div>
					<form class="ajax-submit-form" id="article-review-form" name="article-review-form" action="<?php echo $config['this_admin_url']; ?>articles/newrecipe/" method="POST">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
				        <input type="hidden" id="a_i" name="a_i" value=""/>
				        <input type="hidden" id="article_status" name="article_status" value="2"/>
				        
					<div class="main-buttons">
						<p id="main-buttons-text" class="success" style="display:none;">What would you like to do next?</p>
						<button type="submit" id="submit" name="submit" class="review">Submit for Review</button>
						<button class="article-prev review" name="art-preview" id="art-preview" type="button">Preview Recipe</button>
						<!--<button type="button" id="edit-recipe" name="edit-recipe" class="review">Edit Recipe</button>-->
					</div>
				</form>
				</fieldset>
			</section>
			
		</div>
	</div>
	<div class="lightbox-shown" id="lightbox-cont2" style="display:none;">
		<div class="overlay"></div>
		<div id="lightbox-content" class="article-lightbox article-lightbox-img-uploader">
			
			<div id="lightbox-preview-cont">
			<section id="update-article-image">
				<div id="article-tall-image-upload" class="image-uploader">
					

					<form class="ajax-submit-image" id="article-tall-image-upload-form" name="article-tall-image-upload-form" action="" method="POST">
						<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
				        <input type="hidden" id="x1" name="x1" />
				        <input type="hidden" id="y1" name="y1" />
				        <input type="hidden" id="article-id" name="article-id" value="<?php echo $article['article_id']; ?>"/>

				       
				        <fieldset class="step2">
						   	<span>
						       	<p>Please select a crop region</p>
						    </span>
						    <span class="right preview-close">
								<p>CLOSE<i class="icon-remove-sign" id="preview-close"></i></p>
							</span>
					    </fieldset>  
					    
					    <fieldset class="image-info">  	
					        <img id="preview" alt="" src="" />
					    </fieldset>

					    <fieldset class="image-info">
					        <div class="info">
					        	<h2>Image Information:</h2>

					        	<label>Name:</label> <p id="filenametext" name="filenametext"></p>
					           	<label>Size:</label> <p id="filesizetext" name="filesizetext"></p>
					        	<label>Type:</label><p id="filetype" name="filetype"></p>
					        	<label>Dimension:</label><p id="filedim" name="filedim"></p>
					        
					        	<input type="hidden" id="filesize" name="filesize" />
								<input type="hidden" id="w" name="w" />
					            <input type="hidden" id="h" name="h" />
					            <input type="hidden" id="dimHeight" name="dimHeight" />
					            <input type="hidden" id="dimWidth" name="dimWidth" />
					        </div>
					 	</fieldset>
					    <div class="file-upload-container">
						        <input type="file" name="article_post_tall_img" id="article_post_tall_img" class="upload-img-file"/>
						</div>   
					    <fieldset class="save-button">
							<div class="btn-wrapper">
								<button type="submit" id="submit" name="submit" value="Save Image" class="ajax-submit-image">Save Image</button>
							</div>
						</fieldset>
					</form>
				
				</div>
			</section>
			</div>
		</div>
	</div>

	<?php include_once($config['include_path'].'footer.php');?>
	<div id='lightbox-cont'>
		<div class="overlay"></div>

		<div id="lightbox-content">
			<button type='button' id="preview-close" class="close">X</button>

			<div id="lightbox-preview-cont"></div>
		</div>
	</div>
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>
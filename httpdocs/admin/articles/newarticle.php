<?php
	if(!$adminController->user->checkPermission('user_permission_show_add_article')) $adminController->redirectTo('noaccess/');
	


	if (!empty($_FILES)) {
	     $ds          = DIRECTORY_SEPARATOR;  //1
	 
		$storeFolder = 'uploads';   //2
	    $tempFile = $_FILES['file']['tmp_name'];          //3             
	      
	    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
	     
	    $targetFile =  $targetPath. $_FILES['file']['name'];  //5
	 
	    move_uploaded_file($tempFile,$targetFile); //6
	     
	}
	
	if(isset($_POST['submit'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			
			$updateStatus = $adminController->addArticle($_POST);
			$updateStatus['arrayId'] = 'article-add-form';

			//if(isset($updateStatus['hasError']) && !$updateStatus['hasError']) $_POST = array();
		}else $adminController->redirectTo('logout/');
	}

	//Verify if is a content provider user
	$admin_user = false;
	if(isset($adminController->user->data['user_type']) && $adminController->user->data['user_type'] == 1 || $adminController->user->data['user_type'] == 2){
		$admin_user = true;	
	}

	$contributorInfo = $mpArticle->getContributors(['contributorEmail' => $adminController->user->data['user_email']])['contributors'];
	$contributorInfo = $contributorInfo[0];


	//var_dump($adminController->user->data);
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body>
	<?php include_once($config['include_path_admin'].'header.php');?>
	<div class="sub-menu row">
		<label class="small-3" id="sub-menu-button">MENU <i class="fa fa-caret-left"></i></label>
		<h1 class="left">New Article</h1>
	</div>

	<!-- WELCOME MESSAGE -->
	<section class="section-bar mobile-12 small-12 no-padding show-on-large-up  hide">
			<h1 class="left">New Article</h1>
			
	</section>
	
	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<!-- SUB MENU ADMIN -->		
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<section id="article-info">
				<section class="left  mobile-12 small-12">
				<form  id="article-add-form" name="article-add-form" action="<?php echo $config['this_admin_url']; ?>articles/newarticle/" method="POST" novalidate>
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >

					<div class="row buttons-container" style="padding-top: 0 !important;">
						<button type="submit" id="submit" name="submit" class="">SAVE DRAFT</button>
						<!--<button type="button" id="preview" name="preview" class="">PREVIEW</button>-->
						<?php if($admin_user){?>
							<!--<button type="button" id="publish" name="publish" class="">PUBLISH</button>-->
						<?php }?>
					</div>
					
					<!-- ARTICLE TITLE -->
					<div class="row">
					    <div class="columns">
					      	<input type="text" name="article_title-s" id="article_title-s" placeholder="Enter article title here"   value="<?php if(isset($_POST['article_title-s'])) echo $_POST['article_title-s']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_title') echo 'class="input-error"'; ?> />
						</div>
					</div>

					<!-- ARTICLE CATEGORY -->
					<?php
						$allCategories = $MPNavigation->getAllCategoriesWithArticles();
						if($allCategories && count($allCategories)){
					?>
					<div class="row">
					    <div class="columns">
					    	<div class="small-styled-select left">
								<select id="article_categories" name="article_categories" class="small-12 large-4 left" required>
									<option value="0">Select Category</option>
									<?php
									foreach($allCategories as $category){ ?>
									<option id="<?php echo 'category-'.$category['cat_id']; ?>" value="<?php echo $category['cat_id']; ?>"><?php echo $category['cat_name']; ?></option>
									<?php }?>
								</select>
							</div>
							<div id="category-description" class="small-12 large-8 label-wrapper right padding-left show-on-large-up">
								<label>Choose one category that best specifies the genre of your article.This is where your post will reside on the site.</label>
							</div>
						</div>
					</div>
					<?php }?>


					<?php if($admin_user){?>
					<div class="row">
					    <div class="columns">
					      <input type="text" name="article_seo_title-s" id="article_seo_title-s" placeholder="Enter SEO title" value="<?php if(isset($_POST['article_seo_title-s'])) echo $_POST['article_seo_title-s']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_seo_title') echo 'autofocus'; ?> />
					 	</div>
					</div>	
					<?php }?>

					<!-- KEYWORDS -->
					<div class="row">
					    <div class="columns">
					    	<div class="small-12 label-wrapper">
								<label class="padding-top">Help readers find your article! Enter up to 10 keywords that best describe your article, separated by commas.</label>
							</div>
					    	<input class="small-12" type="text" name="article_tags-s" id="article_tags-s" placeholder="Enter keywords" value="<?php if(isset($_POST['article_tags-s'])) echo $_POST['article_tags-s']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_tags') echo 'autofocus'; ?> />		
						</div>
					</div>	
					
					<!-- DESCRIPTION -->
					<div class="row">
					    <div class="columns">
					    	<input type="text" name="article_desc-s" id="article_desc-s" placeholder="Enter article description" maxlength="150"  value="<?php if(isset($_POST['article_desc-s'])) echo $_POST['article_desc-s']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_desc') echo 'autofocus'; ?> />
						</div>
					</div>	
					
					<!-- BODY -->
					<div class="row padding-bottom">
					    <div class="columns">
							<textarea  class="mceEditor" name="article_body-nf" id="article_body-nf" rows="15" required placeholder="Start writing article here." ><?php if(isset($_POST['article_body-nf'])) echo $_POST['article_body-nf']; ?></textarea>
						</div>
					</div>

					<!-- Article Type  -->
					<?php if($admin_user){?>
					<div class="row">
					    <div class="columns">
							<label class="small-12 large-3 left uppercase">Article Type: </label>
							
							<input type="radio" name="article_type-s" id="opinion" data-info="1"  value="1" checked />
							<label for="" class="radio-label">Opinion</label>
									
							<input type="radio" name="article_type-s" data-info="2" id="news" value="2"  />
							<label for="" class="radio-label">News</label>

							<input type="radio" name="article_type-s" data-info="0" id="staff" value="0"  />
							<label for="" class="radio-label">Staff</label>
						</div>
					</div>
					<?php }?>

					<!-- PAGE LIST -->
					<?php if($admin_user){?>
					<div class="row">
					    <div class="columns">
					    	<div class="small-styled-select">
							<select name="page_list_id-nf" id="page_list_id-nf" class="small-12 large-4 left">
								<option value="0">Select Page List</option>
								<?php			
									$page_lists = PageList::get();
									foreach($page_lists as $page_list){
										echo "<option value='".$page_list->page_list_id."'  >";
											echo $page_list->page_list_title;
										echo "</option>";
									}
								?>
							</select>
						</div>
						</div>
					</div>
					<?php }?>
					
					<!-- CONTRIBUTORS -->
					<?php if($admin_user){
						$allContributors = $adminController->getSiteObjectAll(array('queryString' => 'SELECT * FROM article_contributors ORDER BY contributor_name ASC'));
						if($allContributors && count($allContributors)){
					?>
					<div class="row">
					    <div class="columns">
					    	<div class="small-styled-select margin-top margin-bottom ">
							<select name="article_contributor" id="article_contributor" class="small-12 large-5 left">
								<option value="-1">Select Contributors</option>
								<?php
									foreach($allContributors as $contributorInfo){
										$option = '<option value="'.$contributorInfo['contributor_id'].'"';
										if($contributorInfo['contributor_id'] == $_POST['article_contributor']) $option .= ' selected="selected"';
										$option .= '>'.$contributorInfo['contributor_name'].'</option>';
										echo $option;
									}
								?>
							</select>
						</div>
						</div>
					</div>
					<?php } 
				}else{ ?>
					<input type="hidden"  name="article_contributor" id="article_contributor" value="<?php echo $contributorInfo['contributor_id']?>" />
				<?php } ?>

				<!-- HIDDEN ARTICLE TEMPLATE TYPE - SINGLE -->
				<input type="hidden" class="hidden" id="article_template_type-s" name="article_template_type-s" value="0" />

				<?php if($admin_user){?>
				<!-- IMAGE CREDITS -->
				<div class="row">
					<div class="columns">
				  		<input type="text" name="article_img_credits-s" id="article_img_credits-s" placeholder="Enter image credits"  value="<?php if(isset($_POST['article_img_credits-s'])) echo $_POST['article_img_credits-s']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_img_credits') echo 'autofocus'; ?> />
					</div>
				</div>

				<!-- COMMENTS -->
				<div class="row">
					<div class="columns">
					   	<input type="text" name="article_additional_comments-s" id="article_additional_comments-s" placeholder="Enter additional comments"  value="<?php if(isset($_POST['article_additional_comments-s'])) echo $_POST['article_additional_comments-s']; ?>" <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_additional_comments') echo 'autofocus'; ?> />
					</div>
				</div>

				<!-- DISCLAIMER -->
				<div class="row">
				    <div class="columns">
						<label class="small-12 large-3 left uppercase">Article Disclaimer: </label>
						
						<input type="radio" name="article_disclaimer-s" id="disclaimer-yes" data-info="1"  value="1"  />
						<label for="" class="radio-label">Yes</label>
								
						<input type="radio" name="article_disclaimer-s" data-info="2" id="disclaimer-no" value="0" checked />
						<label for="" class="radio-label">No</label>
					</div>
				</div>
				<?php }?>	

				<div class="row buttons-container">
						<button type="submit" id="submit" name="submit" class="">SAVE DRAFT</button>
				</div>

				</form>
				
				</section>
			</section>
		</div>
	</main>	

	<?php include_once($config['include_path_admin'].'footer.php');?>


	<?php 
		include_once($config['include_path_admin'].'showerrors.php');
	?>
	
	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>

</body>
</html>
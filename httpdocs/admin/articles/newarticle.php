<?php
	$admin = true;
	require_once('../../assets/php/config.php');

var_dump($_SESSION);exit();

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
		}else $adminController->redirectTo('logout/');
	}

	if(isset($_POST['review'])){
		if($adminController->checkCSRF($_POST)){  //CSRF token check!!!
			$updateStatus = $adminController->addArticle($_POST);
			$updateStatus['arrayId'] = 'article-add-form';
		}else $adminController->redirectTo('logout/');
	}

	//Article Status Base on Blogger Type.
	$default_status = 3;

	$contributorInfo = $mpArticle->getContributors(['contributorEmail' => $adminController->user->data['user_email']])['contributors'];
	$contributorInfo = $contributorInfo[0];

	//GET ALL ARTICLES 
	$allarticles = $mpArticle->getAllLiveArticlesPerContributor( $contributorInfo['contributor_id'] );
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<?php include_once($config['include_path_admin'].'head.php');?>

<body id="newarticle">
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		<!-- SUB MENU ADMIN -->		
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div class="small-12">
				<h1>Add New Article</h1>
			</div>
			
			<section id="article-info" class="small-12 columns">
				
				<?php include_once($config['include_path_admin'].'drop_image_new.php'); ?>	
				<form  id="article-add-form" class="margin-top" name="article-add-form" action="<?php echo $config['this_admin_url']; ?>articles/newarticle/" method="POST" novalidate>
					<input type="text" class="hidden" id="c_t" name="c_t" value="<?php echo $_SESSION['csrf']; ?>" >
					<input type="hidden" id="a_i" class="a_i" name="a_i" value="0" />

					<input type="hidden" id="u_i" name="u_i" value="<?php echo $adminController->user->data['user_id']; ?>" />
					<input type="hidden" id="u_type" name="u_type" value="<?php echo $adminController->user->data['user_type']; ?>" />
					<input type="hidden" id="article_status-s" name="article_status-s" value=" <?php echo $default_status; ?>" />
					
					<div class="small-12 xxlarge-8 columns  warning-banner show-for-large-up vertical-center">
					<h2 class="small-4 columns no-padding-left">WAIT</h2>
					<p class="small-8 columns">We recommend that you write and save your articles off-line first, and then copy and paste them here.</p>
					</div>


					<div class="small-12 xxlarge-8 columns margin-top">
						<!-- ARTICLE TITLE -->
						<div class="row ">
						    <div>
						      	<input type="text" name="article_title-s" id="article_title-s" placeholder="WRITE YOUR TITLE"   value="<?php if( isset($_POST['article_title-s'])) echo $_POST['article_title-s']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_title') echo 'class="input-error"'; ?> />
							</div>
						</div>

						<!-- SEO TITLE -->
						<?php if($admin_user){?>
						<div class="row">
						    <div>
								<label for="article_seo_title-s" class="small-3 columns no-padding seo-title">SEO URL:</label>
								  <input type="text" id="article_seo_title-s"  name="article_seo_title-s" aria-describedby="basic-addon3" value="<?php if( isset($_POST['article_seo_title-s'])) echo $_POST['article_seo_title-s']; ?>" class="form-control small-9 columns" >
							</div>
						</div>	
						<?php }else{ ?>
						<div class="row">
						    <div>
						      <input type="hidden"  name="article_seo_title-s" id="article_seo_title-s" placeholder="Enter SEO title" value="<?php if(isset($_POST['article_seo_title-s'])) echo $_POST['article_seo_title-s']; ?>" required <?php if(isset($updateStatus) && isset($updateStatus['field']) && $updateStatus['field'] == 'article_seo_title') echo 'autofocus'; ?> />
						 	</div>
						</div>	
						<?php } ?>

						<!-- BODY -->
						<div class="row margin-bottom margin-top" >
						    <div>
								<textarea  class=" editor " name="article_body-nf" id="article_editor"  required ><?php if( isset($_POST['article_body-nf'])) echo $_POST['article_body-nf']; ?></textarea>
							</div>
						</div>

						<!-- RELATED ARTICLES -->
						<?php include_once($config['include_path_admin'].'related_edit_articles.php'); ?>
					
					</div>

					<!-- RIGHT SIDE BAR -->
					<div class="small-12 xxlarge-4 right padding" id="right-new-article">
						<!-- KEYWORDS -->
						<div class="row">
						    <div>
						    	<textarea  class="" name="article_tags-nf" id="article_tags-s"  placeholder="Enter tags"  required ><?php if( isset($_POST['article_tags-nf'])) echo $_POST['article_tags-nf']; ?></textarea>
							</div>
						</div>	
						
						<!-- DESCRIPTION -->
						<div class="row">
						    <div>
						    	<textarea  class="" name="article_desc-s" id="article_desc-s"  required placeholder="Enter description"  maxlength="150"><?php if( isset($_POST['article_desc-s'])) echo $_POST['article_desc-s']; ?></textarea>
							</div>
						</div>	

						<!-- ARTICLE CATEGORY -->
						<?php
						if( $blogger || $starter_blogger ){?>
							<input type="hidden"  name="article_categories" id="article_categories" value="9" />
						<?php }else{
							$allCategories = $MPNavigation->getAllCategoriesWithArticles();
							if($allCategories && count($allCategories)){
							?>
							<div class="row">
							    <div>
									<select id="article_categories" name="article_categories" class="small-12" required>
											<option value="0">Category</option>
											<?php
											foreach($allCategories as $category){ 
											if( $category['cat_id'] == 9 && !$admin_user) continue; 
											$selected = '';
											if(isset($_POST['article_categories']) && $_POST['article_categories'] == $category['cat_id']){ 
												$selected = 'selected';
											} ?>
											<option id="<?php echo 'category-'.$category['cat_id']; ?>" value="<?php echo $category['cat_id']; ?>" <?php echo $selected; ?> > <?php echo $category['cat_name']; ?> </option>
										<?php }?>
									</select>
								</div>
							</div>
							<?php }
						}?>

						<!-- ARTICLE TYPE -->
						<input type="hidden" name="article_type-s" data-info="0" id="staff" value="0" />
					
						
						<!-- CONTRIBUTORS -->
						<?php if( $admin_user){ 
							$allContributors = $adminController->getSiteObjectAll(array('queryString' => 'SELECT * FROM article_contributors ORDER BY contributor_name ASC'));
							if($allContributors && count($allContributors)){
						?>
							<div class="row">
							    <div>
									<select name="article_contributor" id="article_contributor" class="small-12">
										<option value="-1">Contributors</option>
										<?php
											foreach($allContributors as $contributorInfo){
												$selected = '';
												if(isset($_POST['article_contributor']) && $_POST['article_contributor'] == $contributorInfo['contributor_id']){ 
													$selected = 'selected';
												}
												$option = '<option value="'.$contributorInfo['contributor_id'].'" '. $selected;
												$option .= '>'.$contributorInfo['contributor_name'].'</option>';
												echo $option;
											}
										?>
									</select>
								</div>
							</div>
							<?php } 
						}else{ ?>
							<input type="hidden"  name="article_contributor" id="article_contributor" value="<?php echo $contributorInfo['contributor_id']; ?>" />
						<?php }  ?>

						<!-- HIDDEN ARTICLE TEMPLATE TYPE - SINGLE -->
						<input type="hidden" class="hidden" id="article_template_type-s" name="article_template_type-s" value="0" />

						<?php if($admin_user){?>
						<!-- IMAGE CREDITS -->
						<div class="row">
							<div>
								<textarea  class="" name="article_img_credits-s" id="article_img_credits-s"  required placeholder="image credits"><?php if(isset($_POST['article_img_credits-s'])) echo $_POST['article_img_credits-s']; ?></textarea>
							</div>
						</div>

						<!-- IMAGE CREDITS URL-->
						<div class="row">
							<div>
								<textarea  class="" name="article_img_credits_url-s" id="article_img_credits_url-s"  placeholder="image credits URL"><?php if(isset($_POST['article_img_credits_url-s'])) echo $_POST['article_img_credits_url-s']; ?></textarea>
							</div>
						</div>

						<!-- COMMENTS -->
						<div class="row">
							<div>
							   	<textarea type="text" name="article_additional_comments-s" id="article_additional_comments-s" placeholder="comments" ><?php if(isset($_POST['article_additional_comments-s'])) echo $_POST['article_additional_comments-s']; ?></textarea>
							</div>
						</div>

						<!-- DISCLAIMER -->
						<div class="row">
						    <div>
							<label class="uppercase label-wrapper"> Disclaimer:
								
								<input type="radio" name="article_disclaimer-s" id="disclaimer-yes" data-info="1"  value="1"  />
								<label for="" class="radio-label">Yes</label>
										
								<input type="radio" name="article_disclaimer-s" data-info="2" id="disclaimer-no" value="0" checked />
								<label for="" class="radio-label">No</label>
							 </label>
							</div>
						</div>
						<?php }?>	

						<div class="row padding-top">
							<div class="small-12 large-6 columns no-padding show-for-large-up">
								<button type="button" id="preview" name="preview" class="radius preview-button small-12">PREVIEW</button>
							</div>
							<div class="small-12 large-6 columns">
								<button type="button" id="save-article" name="save-article" class="radius small-12" data-info="3">SAVE</button>
							</div>

						</div>

						<?php include_once($config['include_path_admin'].'agreement_edits.php');?>
						
						<?php //include_once($config['include_path_admin'].'formatting_tips.php');?>

					</div>
				</form>
			</section>
		</div>
	</main>	

<!-- INFO BADGE 
<div id="info-badge" class="footer-position bg-black hide-for-print show-for-small-only">
	<?php //include($config['include_path_admin'].'info-badge.php');?>
</div>-->

	<!-- ARTICLE PREV TEMPLATE -->
<?php include_once($config['include_path_admin'].'article_prev_template.php'); ?>

<?php //include_once($config['include_path_admin'].'articlelib.php');?>

<?php include_once($config['include_path_admin'].'showerrors_articles.php'); ?>

<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>



</body>
</html>
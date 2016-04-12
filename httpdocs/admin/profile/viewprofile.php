<?php
	$userInfo = $adminController->user->data;
	$contributorInfo = $mpArticle->getContributors(['contributorSEOName' => $uri[2] ])['contributors'];

	if(empty($contributorInfo)) $mpShared->get404();
	$contributorInfo = $contributorInfo[0];	

	//If the contributor exists and has an id, check to see if this user has permissions to edit this contributor...
	if (isset($contributorInfo['contributor_id'])){
		if ( !($adminController->user->checkUserCanEditOthers('contributor', $userInfo['contributor_email_address'])) ) $adminController->redirectTo('noaccess/');
	} else $mpShared->get404();

	//	If the user hasn't yet set an image, set $image = default_profile_image.png
	$image = (isset($contributorInfo['contributor_image']) && $contributorInfo['contributor_image'] != "") ? $contributorInfo['contributor_image'] : 'pm_avatars_1.png';
	
	//	If the name in the url string doesn't match the logged in user's username...
	//if ($userInfo['user_name'] != $uri[2]){
		//	No access
	//	$adminController->redirectTo('noaccess/');
	//}

	//	Set the paths to the image
	$contImageDir =  $config['image_upload_dir'].'articlesites/contributors_redesign/'.$image;
	$contImageUrl =  'http://images.puckermob.com/articlesites/contributors_redesign/'.$image; 
	$contImageExists = false;

	//	Verify if the usr has ever SELECTED an image
	if( isset($image) ){ $contImageExists = file_exists($contImageDir); }

	$contributor_id = $contributorInfo['contributor_id'];
	$contributor_seo_name = $contributorInfo['contributor_seo_name'];
	$article_list = $adminController->user->getContributorsArticleList( $contributor_id );

?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path_admin'].'head.php');?>
<body id="view-my-profile">

	<input type="hidden" value="<?php echo $contributor_id; ?>" id="contributor_id"/>
	
	<?php include_once($config['include_path_admin'].'header.php');?>

	<main id="main-cont" class="row panel sidebar-on-right" role="main">
		
		<!-- SUB MENU ADMIN -->		
		<?php include_once($config['include_path_admin'].'menu.php');?>
		
		<div id="content" class="columns small-9 large-11">
			<div class="small-12 columns padding-bottom ">
				<h1 class="columns small-12" >My Profile
					<div class="inline right show-for-large-up">
						<a href="<?php echo $config['this_url'].'admin/profile/edit/'.$contributor_seo_name; ?>" class="font-1-5x black ">SET UP</a>
						<i class="fa fa-circle"></i>
						<a href="<?php echo $config['this_url'].'admin/profile/user/'.$contributor_seo_name; ?>" class="font-1-5x main-color">VIEW PUBLIC</a>
					</div>
				</h1>
			</div>
			
			<div class="small-12 xxlarge-8 columns">	
				<div class="small-12 columns margin-bottom no-padding">
					<div class="small-12 columns no-padding">
						<div class="small-5 large-2 columns no-padding">
							<img id="img-profile" src="<?php echo $contImageUrl; ?>" alt="User Image" />
						</div>
						<div class="small-7 large-10 columns no-padding-right cont-info" style="    padding-top: 35px;">
							<div class="small-12 large-6 columns">
								<p style="margin-top: 11px;"><?php echo $contributorInfo['contributor_name']; ?></p>
								<p class="show-for-large-up"><?php echo $contributorInfo['contributor_location']; ?></p>
								<p class="show-for-large-up">Joined: <?php echo date('F d, Y', strtotime($contributorInfo['creation_date'])); ?></p>
							</div>
							<div class="small-12 large-6 columns show-for-large-up">
								<?php if($userInfo['contributor_facebook_link']){?>
									<p><a href="<?php echo $contributorInfo['contributor_facebook_link']; ?>" target="_blank"><i class="fa fa-facebook-square"></i>Follow on Facebook</a></p>
								<?php }?>

								<?php if($userInfo['contributor_twitter_handle']){?>
								<p><a href="http://www.twitter.com/<?php echo $contributorInfo['contributor_twitter_handle']; ?>" target="_blank"><i class="fa fa-twitter"></i>Follow on Twitter</a></p>
								<?php }?>

								<?php if($userInfo['contributor_blog_link']){?>
								<p><a href="<?php echo $contributorInfo['contributor_blog_link']; ?>" target="_blank"><i class="fa fa-desktop"></i>View my Blog/Site</a></p>
								<?php }?>
							</div>

							<div class="small-12 large-6 columns hide-for-large-up margin-top">
								<?php if($userInfo['contributor_facebook_link']){?>
								<p class="small-4 columns no-padding"><a href="<?php echo $contributorInfo['contributor_facebook_link']; ?>" target="_blank"><i style="font-size: 1.6rem;" class="fa fa-facebook-square"></i></a></p>
								<?php }?>

								<?php if($userInfo['contributor_twitter_handle']){?>
								<p class="small-4 columns no-padding" ><a href="http://www.twitter.com/<?php echo $contributorInfo['contributor_twitter_handle']; ?>" target="_blank"><i style="font-size: 1.6rem;" class="fa fa-twitter"></i></a></p>
								<?php }?>

								<?php if($userInfo['contributor_blog_link']){?>
								<p class="small-4 columns no-padding" ><a href="<?php echo $contributorInfo['contributor_blog_link']; ?>" target="_blank"><i style="font-size: 1.6rem;" class="fa fa-desktop"></i></a></p>
								<?php }?>
							</div>
						</div>
					</div>
				</div>

				<div class="small-12 columns no-padding margin-bottom margin-top">
					<h2 class="bold">ABOUT ME</h2>
					<p><?php echo $contributorInfo['contributor_bio']; ?></p>
				</div>

				<div class="small-12 columns no-padding margin-bottom margin-top">
					<h2 class="bold">MY ARTICLES</h2>
					<div class="small-12 columns no-padding">
					<?php if(isset($article_list) && $article_list ){?>
					<table>
						<?php foreach($article_list as $article){
							$article_url = $config['this_url'].'/'.$article['cat_dir_name'].'/'.$article['article_seo_title'];
						?>
						<tr id="article_<?php echo $article['article_id'];?>">
							<td width="170" class="show-for-large-up"><img src="http://images.puckermob.com/articlesites/puckermob/large/<?php echo $article['article_id'];?>_tall.jpg" alt="Article Image"/></td>
							<td ><a href="<?php echo $article_url; ?>" target="blanck"><?php echo $article['article_title'];?></a></td>
						</tr>
						<?php }?>
					</table>
					<?php }else{
						echo '<p>No Articles Found!</p>';
					} ?>
						
					</div>
				</div>
			</div>
			
			<!-- Right Side -->
			<div class="small-12 xxlarge-4 right padding rightside-padding show-for-large-up" >
				<?php include_once($config['include_path_admin'].'myprofile_sidebar.php'); ?>
			</div>
		</div>
	</main>
	<!-- INFO BADGE -->
	<div id="info-badge" class="footer-position bg-black hide-for-print show-for-small-only">
		<?php include($config['include_path_admin'].'info-badge.php');?>
	</div>

	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>
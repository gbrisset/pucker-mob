<?php
	$userInfo = $adminController->user->data;

	//	If the user hasn't yet set an image, set $image = default_profile_image.png
	$image = (isset($userInfo['contributor_image']) && $userInfo['contributor_image'] != "") ? $userInfo['contributor_image'] : 'pm_avatars_1.png';

	//If the contributor exists and has an id, check to see if this user has permissions to edit this contributor...
	if (isset($userInfo['contributor_id'])){
		if ( !($adminController->user->checkUserCanEditOthers('contributor', $userInfo['contributor_email_address'])) ) $adminController->redirectTo('noaccess/');
	} else $mpShared->get404();
	
	//	If the name in the url string doesn't match the logged in user's username...
	if ($userInfo['user_name'] != $uri[2]){
		//	No access
		$adminController->redirectTo('noaccess/');
	}

	//	Set the paths to the image
	$contImageDir =  $config['image_upload_dir'].'articlesites/contributors_redesign/'.$image;
	$contImageUrl =  'http://images.puckermob.com/articlesites/contributors_redesign/'.$image; 
	$contImageExists = false;

	//	Verify if the usr has ever SELECTED an image
	if(isset($image) ){
		$contImageExists = file_exists($contImageDir);
	}


//	$contributorInfo = $mpArticle->getContributors(['contributorSEOName' => 'kirsten-corley-', 'sortType' => 1]);

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
						<a href="<?php echo $config['this_url'].'admin/account/edit/'.$adminController->user->data['user_name']; ?>" class="font-1-5x black ">SET UP</a>
						<i class="fa fa-circle"></i>
						<a href="<?php echo $config['this_url'].'admin/account/user/'.$adminController->user->data['user_name']; ?>" class="font-1-5x main-color">VIEW PUBLIC</a>
					</div>
				</h1>
			</div>
			
			<div class="small-12 xxlarge-9 columns">	
				<div class="small-12 columns margin-bottom no-padding">
					<div class="small-12 columns no-padding">
						<div class="small-5 large-3 columns no-padding">
							<img id="img-profile" src="<?php echo $contImageUrl; ?>" alt="User Image" />
						</div>
						<div class="small-7 large-9 columns no-padding-right cont-info">
							<div class="small-12 large-6 columns">
								<p style="    margin-top: 11px;"><?php echo $userInfo['user_first_name']; ?></p>
								<p class="show-for-large-up"><?php echo $userInfo['contributor_location']; ?></p>
								<p class="show-for-large-up">JOINED: <?php echo date('F d, Y', strtotime($userInfo['user_creation_date'])); ?></p>
							</div>
							<div class="small-12 large-6 columns show-for-large-up">
								<p><a href=""><i class="fa fa-facebook-square"></i>FOLLOW ON FACEBOOK</a></p>
								<p><a href=""><i class="fa fa-twitter"></i>FOLLOW ON TWITTER</a></p>
								<p><a href=""><i class="fa fa-desktop"></i>VIEW MY BLOG/SITE</a></p>
							</div>

							<div class="small-12 large-6 columns hide-for-large-up margin-top">
								<p class="small-4 columns no-padding"><a href=""><i style="font-size: 1.6rem;" class="fa fa-facebook-square"></i></a></p>
								<p class="small-4 columns no-padding" ><a href=""><i style="font-size: 1.6rem;" class="fa fa-twitter"></i></a></p>
								<p class="small-4 columns no-padding" ><a href=""><i style="font-size: 1.6rem;" class="fa fa-desktop"></i></a></p>
							</div>
						</div>
					</div>
				</div>

				<div class="small-12 columns no-padding margin-bottom margin-top">
					<h2 class="bold">ABOUT ME</h2>
					<p><?php echo $userInfo['contributor_bio']; ?></p>
				</div>

				<div class="small-12 columns no-padding margin-bottom margin-top">
					<h2 class="bold">MY ARTICLES</h2>
					<div class="small-12 columns no-padding">
					<table>
						<tr>
							<td width="200" class="show-for-large-up"><img src="http://cdn.puckermob.com/articlesites/puckermob/large/12964_tall.jpg" alt="Article Image"/></td>
							<td ><a>To The Mother Who Doesn't Deserve Him, I Loved Him When You Walked Out</a></td>
						</tr>
						<tr>
							<td width="200" class="show-for-large-up"><img src="http://cdn.puckermob.com/articlesites/puckermob/large/12964_tall.jpg" alt="Article Image"/></td>
							<td ><a>To The Mother Who Doesn't Deserve Him, I Loved Him When You Walked Out</a></td>
						</tr>
						<tr>
							<td width="200" class="show-for-large-up"><img src="http://cdn.puckermob.com/articlesites/puckermob/large/12964_tall.jpg" alt="Article Image"/></td>
							<td ><a>To The Mother Who Doesn't Deserve Him, I Loved Him When You Walked Out</a></td>
						</tr>
					</table>
						
					</div>
				</div>
			</div>
			
			<!-- Right Side -->
			<div class="small-12 xxlarge-3 right padding rightside-padding show-for-large-up" >
				<?php include_once($config['include_path_admin'].'hottopics.php'); ?>
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
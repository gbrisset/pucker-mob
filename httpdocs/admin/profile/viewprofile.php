<?php
	$userInfo = $adminController->user->data;
	$contributorInfo = $mpArticle->getContributors(['contributorSEOName' => $uri[2] ])['contributors'];

	if(empty($contributorInfo)) $mpShared->get404();
	$contributorInfo = $contributorInfo[0];	

	//VERIFY IS USER CAN EDIT OTHER CONTRIBUTORS
	if(isset($contributorInfo['contributor_id']) && $contributorInfo['contributor_email_address'] != $userInfo['contributor_email_address'] ){
		if ( !($adminController->user->checkUserCanEditOthers('contributor', $userInfo['contributor_email_address'])) ) $adminController->redirectTo('noaccess/');
	}// else $mpShared->get404();
	

	//	If the name in the url string doesn't match the logged in user's username...
	//if ($userInfo['user_name'] != $uri[2]){
		//	No access
	//	$adminController->redirectTo('noaccess/');
	//}

	//	If the user hasn't yet set an image, set $image = default_profile_image.png
	$image = (isset($contributorInfo['contributor_image']) && $contributorInfo['contributor_image'] != "") ? $contributorInfo['contributor_image'] : 'pm_avatars_1.png';
	

	//	Set the paths to the image
	$contImageDir =  $config['image_upload_dir'].'articlesites/contributors_redesign/'.$image;
	$contImageUrl =  'http://images.puckermob.com/articlesites/contributors_redesign/'.$image; 
	$contImageExists = false;

	$contributor_id = $contributorInfo['contributor_id'];
	$contributor_seo_name = $contributorInfo['contributor_seo_name'];
	$article_list = $adminController->user->getContributorsArticleList( $contributor_id );


//**************************************************************************************
//**************************************************************************************
//**************************************************************************************
//**************************************************************************************

	//added by GB on 2017-07-27 -----------------------------------
	$arr_ids = [];
	foreach($article_list as $article){
		$arr_ids[] = $article['article_id'];
	}

	//Implode all the ids for each article on the current index page.
	$comma_separated = implode(", ", $arr_ids);

	//Get usa pageviews for each article on the list
	
	$usa_pageview_list = $mpArticle->getTotalUsPageviews( $comma_separated );
	if (is_array($usa_pageview_list[0]) ){
		$pageviews_list = [];
		if($usa_pageview_list){
			foreach($usa_pageview_list as $key=>$value){
				$pageviews_list[$value['article_id']] =$value['total_usa_pv'];
				
			}
		}
		
	}else{
		$pageviews_list[$usa_pageview_list['article_id']] =$usa_pageview_list['total_usa_pv'];

	}//end if (count($usa_pageview_list)>1 )

	//end of added by GB on 2017-07-27 -----------------------------------
echo "<!-- vardump ";
var_dump($pageviews_list);
echo "end vardump -->";

 // $ddd = new debug($pageviews_list,0); $ddd->show();// 0-Green; 1-Red; 2-Dark; 3-Yellow;

//**************************************************************************************
//**************************************************************************************
//**************************************************************************************
//**************************************************************************************
//**************************************************************************************

	//	Verify if the usr has ever SELECTED an image
	if( isset($image) ){ $contImageExists = file_exists($contImageDir); }

	

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
				<h1 class="columns small-12 no-padding" >My Profile
					<div class="inline right show-for-large-up">
					<?php
						if( $contributorInfo['contributor_email_address'] == $userInfo['contributor_email_address'] ||  $admin_user === true ){ ?>
						<a href="<?php echo $config['this_url'].'admin/profile/edit/'.$contributor_seo_name; ?>" class="font-1-5x black ">SET UP</a>
						
						<i class="fa fa-circle"></i>
						<a href="<?php echo $config['this_url'].'admin/profile/user/'.$contributor_seo_name; ?>" class="font-1-5x main-color">VIEW PUBLIC</a>
						<i class="fa fa-circle"></i>
						<a href="<?php echo $config['this_url'].'admin/earnings/'.$contributor_seo_name; ?>" class="font-1-5x">DASHBOARD</a>
						<i class="fa fa-circle"></i>
						<a href="<?php echo $config['this_url'].'admin/admatching?seo='.$contributor_seo_name; ?>" class="font-1-5x">AD MATCHING</a>
						<?php } ?>
					</div>
				</h1>
			</div>
			
			<div class="small-12 xxlarge-8 columns">	
				<div class="small-12 columns margin-bottom no-padding">
					<div class="small-12 columns no-padding">
						<div class="small-5 large-2 columns no-padding">
							<img id="img-profile" src="<?php echo $contImageUrl; ?>" alt="User Image" />
						</div>
						<div class="small-7 large-10 columns no-padding-right cont-info valign-middle" style="">
							<div class="small-12 large-6 columns">
								<p style="margin-top: 11px;"><?php echo $contributorInfo['contributor_name']; ?></p>
								<p class=""><?php echo $contributorInfo['contributor_location']; ?></p>
								<p class="">Joined: <?php echo date('F d, Y', strtotime($contributorInfo['creation_date'])); ?></p>
							</div>
							<div class="small-12 large-6 columns ">
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
					<table class="small-12">
						<?php foreach($article_list as $article){
							$article_url = '';
							if( $contributorInfo['contributor_email_address'] == $userInfo['contributor_email_address'] ||  $admin_user === true ){

								$article_url = $config['this_admin_url'].'articles/edit/'.$article['article_seo_title'];
							}
						?>
						<tr id="article_<?php echo $article['article_id'];?>">
							<td width="160" class="show-for-large-up">
								<img src="http://images.puckermob.com/articlesites/puckermob/large/<?php echo $article['article_id'];?>_tall.jpg" alt="Article Image"/>
							</td>
							<td class="no-padding-right">
								<a href="<?php echo $article_url; ?>" ><?php echo $article['article_title'];?></a>
							</td>
							<td class="no-padding-right">
								<?php echo $pageviews_list[$article['article_id']]; ?>
						<div style="font-size: smaller;">	Pageviews</div>
							</td>
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
	<!-- INFO BADGE 
	<div id="info-badge" class="footer-position bg-black hide-for-print show-for-small-only">
		<?php //include($config['include_path_admin'].'info-badge.php');?>
	</div>-->

	<?php include_once($config['include_path_admin'].'bottomscripts.php'); ?>
</body>
</html>
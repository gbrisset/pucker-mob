
<?php
$isHomepage = false;
$isArticle = true;
 //ISSUE WITH ANNA ARTICLE
$current_url = isset($_SERVER['SCRIPT_URI']) ? $_SERVER['SCRIPT_URI'] : '';
if($current_url == "http://www.puckermob.com/relationships/19-things-you-forget-to-thank-your-soulmate-wifey-for"){
	header('Location: http://www.puckermob.com/relationships/19-things-you-forget-to-thank-your-soulmate-wifey-for-');
	die;
}
if($current_url == "http://www.puckermob.com/fun/21-things-only-antsy-people-do"){
	header('Location: http://www.puckermob.com/fun/21-things-only-antsy-people-do-');
	die;
}
if($current_url == "http://www.puckermob.com/lifestyle/what-all-smokers-know-7-reasons-why-pot-is-better-than-alcohol"){
	header('Location: http://www.puckermob.com/lifestyle/what-all-smokers-know-7-reasons-why-pot-is-better-than-alcohol-');
	die;
}
//END ISSUE WITH ANNA ARTICLE

// Initialize variables
$article_body = $article_link = $article_title = $article_category = $article_disclaimer = $article_img_credits =  $article_img_credits = $article_notes = $linkToContributor = $read_more_pct = '';
$article_id =0;
//$second_image ='';
$contributor_id = 0;
$contributor_name = '';
$categoryInfo = array( "cat_id" => "6",  "cat_name"=> "Lifestyle", "cat_dir_name"=> "lifestyle",
 "cat_desc" => "",  "cat_tags" => "");

//CATEGORY INFO
foreach($MPNavigation->categories as $category){

	if( isset($category['cat_dir_name'])  && !(isset($uri[2])) && ($category['cat_dir_name'] == $uri[0])  ){
		$categoryInfo = $category;
		$articleTitle = explode('&', preg_replace('/[?]/', '&', $uri[1]))[0];
		$hasParent = false;
	} else if(isset($category['cat_dir_name']) && (isset($uri[2])) && ($category['cat_dir_name'] == $uri[1]) ){
		$categoryInfo = $category;
		$articleTitle = explode('&', preg_replace('/[?]/', '&', $uri[2]))[0];
		$hasParent = true;
	}
}

//CHECK IF BELONG TO A CATEGORY ELSE RETURN 404 PAGE
if(!is_null($categoryInfo)){
	
	//ARTICLE INFO 
	$articleInfo = $mpArticle->getSingleArticleInfo(['articleSEOTitle' => $articleTitle]);
	
	//CHECK IF ARTICLES IN REGISTER UNDER THAT CATEGORY
	$verifyInCat = $mpArticle->verifyArticleInCategory( $articleInfo['article_id'], $categoryInfo['cat_id']);
	
	if(isset($articleInfo) &&  $articleInfo && $verifyInCat ){
		$articleInfoObj = $articleInfo;

		//PAGE NAME
		$pageName = $articleInfoObj['article_title'];
		
		//ARTICLE ADS SETTINGS
		$article_ads = $mpArticleAdmin->getArticleAds($articleInfoObj);

		//RELATE ARTICLES LIST 
		$relatedArticles = $mpArticle->getArticlesList([ 'limit'=> 6,  'pageId' => $categoryInfo['cat_id'], 'omit' => $articleInfo['article_id']]);
		$pagesArray['url'] = $config['this_url'].$categoryInfo['cat_dir_name'];
		
		//if (isset($articleInfoObj) && $articleInfoObj ){
		//ARTICLE INFO
		$date = date("M d, Y", strtotime($articleInfoObj['date_updated']));
		$article_title = $articleInfoObj['article_title'];;
		$article_id = isset($articleInfoObj) ? $articleInfoObj['article_id'] : 0 ;
		$article_body = $articleInfoObj['article_body'];
		$article_desc = $articleInfoObj['article_desc'];
		$article_img_credits = $articleInfoObj['article_img_credits'];
		$article_img_credits_url = $articleInfoObj['article_img_credits_url'];
		$article_notes = $articleInfoObj['article_additional_comments'];
		$article_disclaimer = $articleInfoObj['article_disclaimer'];
		$read_more_pct = $articleInfoObj['article_read_more_pct'];
		$article_link = $config['this_url'].$categoryInfo['cat_dir_name'].'/'.$articleInfoObj['article_seo_title'];


		//DATE UPDATED 
		if(!isset($articleInfoObj['date_updated']) || $articleInfoObj['date_updated'] == "0000-00-00 00:00:00") $date = date("M d, Y", strtotime($articleInfoObj['creation_date']));
		else $date = date("M d, Y", strtotime($articleInfoObj['date_updated']));

		//CATEGORY INFO
		$article_category = $category['cat_name'];
		$category_id = $category['cat_id'];
		$article_category_dir = $category['cat_dir_name'];
		
		//CONTRIBUTOR INFO
		if(isset($articleInfoObj['contributor_name']) && $articleInfoObj['contributor_name']) 
			$contributor_name = $articleInfoObj['contributor_name'];
		if(isset($articleInfoObj['contributor_id']) && $articleInfoObj['contributor_id']) 
			$contributor_id = $articleInfoObj['contributor_id'];
		$linkToContributor = $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name'];
		$name = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_name"])));
		$seo_name = $articleInfoObj['contributor_seo_name'];

		///RELATED ARTICLES LIST 
		$related_articles = $mpArticle->getRelatedToArticle( $article_id );
		//}

	}else $mpShared->get404();
	
}else $mpShared->get404();


?>
<!-- *******************************************MOBILE******************************************* -->
<?php if ( $detect->isMobile() ) {  ?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<!-- HEAD -->
<?php include_once($config['include_path'].'head.php');?>

<!-- BODY -->
<body id="article" class="mobile">
<?php 
	


		 switch ($article_id) {
	 	

			// case 10855: //	to-the-person-who-loves-me-next	
			// case 18283: //	a-letter-to-the-girl-who-hasnt-been-herself-in-awh...	
			// case 23464: //	ill-always-be-in-your-corner	
			// case 28002: //	to-the-girl-who-thinks-he-wont-regret-losing-you	
			case 29816: //	how-to-heal-your-broken-heart-based-on-your-zodiac	
			// case 33890: //	im-not-afraid-to-fight-with-you-because-i-would-fi...	
			// // DO NOTHING 
		 	
			break;
			
		 	default:
				echo $smf_adManager->display_tags("mbl_overlay_top", $article_id);
				
		 }//end switch ($article_id)

 ?>

	<!-- HEADER MENU -->
	<?php include_once($config['include_path'].'header.php');?>

	<!-- ADD UNIT BELOW HEADER -->
	<?php //include_once($config['include_path'].'header_ad.php');?>

	<style>
		#nav-bar{ box-shadow: none;} 
		#articlelist-wrapper{ padding-top:0 !important;}
	</style>

	<!-- MAIN CONTENT -->
	<main id="main" class="row panel sidebar-on-right" role="main" style="">
		<section id="puc-articles" class="sidebar-right small-12   translate-fix sidebar-main-left medium-index">
			<!-- ARTICLE CONTENT -->
			<?php include_once($config['template_path'].'single_page_article.php'); ?>
				
			<!-- COMMENTS BOX -->
			<?php include_once($config['include_path'].'disqus.php'); ?>
			<hr>
			
		</section>
		
		<!-- 10  MOST RECENT ARTICLES ADDED -->
		<section class="clear second-section low-index">
			<?php //include_once( $config['include_path'].'most_recent_internal_articles.php'); ?>
		</section>
	</main>
	
	

		<!-- FACEBOOK FUNCTIONS -->
		<?php include_once('admin/fb/fbfunctions.php'); ?>

		<!-- MOBILE MORE TAB -->
		<?php switch ($article_id) {
				//Loreal test - DELETE AFTER AUGUST 31 2017
				case 5338: // why-wearing-makeup-isnt-false-advertising
				case 7378: // 20-things-only-girls-who-love-makeup-understand
				// Do Nothing
				break;
				
			 	default:
			 include_once($config['include_path'].'mobiletapsection.php');
		 }//end switch ($article_id) ?>		


		<!-- SCRIPTS -->
		<?php include_once($config['include_path'].'bottomscripts.php');?>

		<!-- FACEBOOK COMMENTS BOX -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	
</body>
</html>
<!-- *******************************************END MOBILE***************************************** -->

<!--  *******************************************DESKTOP******************************************* -->
<?php }else{ ?>
<!DOCTYPE html>
<html class="no-js" lang="en"  xmlns:fb="http://ogp.me/ns/fb#"> 

<!-- HEAD -->
<?php include_once($config['include_path'].'head.php');?>

<!-- BODY -->
<body id="article">
	<!-- UNDERTONE -->
	<?php

	
					 switch ($article_id) {
				 	

						// case 10855: //	to-the-person-who-loves-me-next	
						// case 18283: //	a-letter-to-the-girl-who-hasnt-been-herself-in-awh...	
						// case 23464: //	ill-always-be-in-your-corner	
						// case 28002: //	to-the-girl-who-thinks-he-wont-regret-losing-you	
						case 29816: //	how-to-heal-your-broken-heart-based-on-your-zodiac	
						// case 33890: //	im-not-afraid-to-fight-with-you-because-i-would-fi...	
						// // DO NOTHING 
					 	
						break;
						
					 	default:
					 			echo $smf_adManager->display_tags("dsk_overlay_top", $article_id);
							
					 }//end switch ($article_id)



	 ?>

	<!-- HEADER MENU -->
	<?php include_once($config['include_path'].'new_header.php'); ?>

	<!-- HEADER AD BELOW MENU -->
	<?php include_once($config['include_path'].'header_ad.php'); ?>

	<!-- ARTICLE INFO TOP -->
		<div class="puc-articles-top" style="background:#fff !important;">
			<div class="puc-articles-top-inner small-12 padding">
				<div class="columns small-12 large-9 no-padding sidebar-right left-div">
					<!-- TITLE -->
					<h1 style="margin-bottom: 0.5rem; color: #222 !important;" class=""><?php echo $article_title; ?></h1>
					
					<!-- AUTHOR INFO -->
					<div class="small-12">
						<p class="author" style="color: #222 !important;"> 
							<a href = "<?php echo $config['this_url'].'contributors/'.$seo_name; ?>" style="color:#222 !important;"><?php echo 'By '.$name; ?></a>
						</p>
					</div>
				</div>
				<!-- SOCIAL MEDIA -->
				<div class="columns small-12 large-9 no-padding sidebar-right left-div">
					<!-- SOCIAL MEDIA CONTENT -->
					<div id="article-content-2" class="clear">
						<div class="social-media-container   small-12 columns no-padding social_sticky clear " style="padding-bottom: 2px;">
							<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
		    					<a class="a2a_button_facebook small-6  columns" style="background: #3b5998;">
		    						<label class="label-social-button-2-mobile" style="padding:9px 0 3px 0;">
		    							<i class="fa fa-facebook" style="margin-right: 10px; font-size: 1.8rem;" ></i></label>
		    					</a>
		    					<a class="a2a_button_pinterest small-2 columns" style="background: #cb2027;">
		    						<label class="label-social-button-2-mobile" style="padding: 6px; top: 2px;">
		    							<i class="fa fa-pinterest" aria-hidden="true" style="font-size: 1.8rem; margin: 0;"></i>
									</label>
								</a>
								<a class="a2a_button_twitter small-2  columns" style="background: #00aced;">
									<label class="label-social-button-2-mobile" style="padding: 6px; top: 2px;">
		    							<i class="fa fa-twitter" aria-hidden="true" style="font-size: 1.8rem; margin: 0;"></i>
									</label>
								</a>
								<a class="a2a_dd small-2 columns" style="background: #003782;" href="https://www.addtoany.com/share">
									<label class="label-social-button-2-mobile" style="padding: 6px; top: 2px;">
		    							<i class="fa fa-plus" aria-hidden="true" style="font-size: 1.8rem; margin: 0;"></i>
									</label>
								</a>
								<script src="//static.addtoany.com/menu/page.js" async></script>
							</div>
						</div>
					</div>
					
					<!-- IMAGE -->
					<div id="article-image" class="small-12 clear">

					 <?php


			     
					 switch ($article_id) {
				 	

						// case 10855: //	to-the-person-who-loves-me-next	
						// case 18283: //	a-letter-to-the-girl-who-hasnt-been-herself-in-awh...	
						// case 23464: //	ill-always-be-in-your-corner	
						// case 28002: //	to-the-girl-who-thinks-he-wont-regret-losing-you	
						case 29816: //	how-to-heal-your-broken-heart-based-on-your-zodiac	
						// case 33890: //	im-not-afraid-to-fight-with-you-because-i-would-fi...	
						
					 	
							include($config['include_path'] . 'ads/tout_glade_ad_video.php');
							break;
						
					 	default:
							echo $smf_adManager->display_tags("dsk_image", $article_id, $article_title); //passing title is optional, only needed for img ad slots
							
					 }//end switch ($article_id)




					 

						// OLD CODE PLAYING VIDEOS WHEN VIDEO IS ASSOCIATED WITH THE ARTICLE

						// if( !empty($articleInfoObj['article_video_script']) ){ 
						//  	if(get_magic_quotes_gpc()) echo stripslashes($articleInfoObj['article_video_script']);
						// 				else echo $articleInfoObj['article_video_script'];
						// }else { ?>
						<!-- 
						<img src="<?php //echo 'http://images.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php // echo $article_title; ?> Image"> 
						-->
						<?php // } // end if( !empty($articleInfoObj ...?>
					

					</div>
				</div>
				
				<!-- RIGHT SIDE SECTION -->
				<div class="columns small-3 no-padding-right right-div">
					<aside id="aside-top" class="fixed-width-sidebar column no-padding hide-for-print">

							<?php 


								echo $smf_adManager->display_tags("dsk_sidebar_0", $article_id);
								echo $smf_adManager->display_tags("dsk_sidebar_1", $article_id);

							?>

					  
					</aside>
				</div>
			</div>
				
		</div>

	<!-- MAIN CONTENT -->
	<main id="main" class="row panel sidebar-on-right" role="main">

		<section id="puc-articles" class="cool sidebar-right  small-12 medium-12 large-11 columns translate-fix" style=" max-width: 752px; height:auto; ">

			<!-- ARTICLE CONTENT -->
			<?php include_once($config['template_path'].'single_page_article.php'); ?>

			<!-- LIKE US ON FB --> 
			<div class="columns no-padding hide-for-print like-us-fb clear" style="margin-bottom: 2rem;">
				<p class="columns small-2">Join the Mob!
					<div class="columns small-9" >
						<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPuckerMob%2F1492027101033794&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=25&amp;appId=1473110846264937" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:25px; width: 100%;" allowTransparency="true"></iframe>	
					</div>	 
				</p>
			</div>	 
			
			<!-- more  PM ARTICLES -->
			<?php //include_once( $config['include_path'].'similararticles.php'); ?>
		</section>

		<!-- RIGHT SIDE BAR -->
		<?php include_once($config['include_path'].'rightsidebar.php');?>

	</main>
	<!-- FACEBOOK FUNCTIONS -->
	<?php include_once('admin/fb/fbfunctions.php'); ?>

	<!-- SCRITPS -->
	<?php include_once($config['include_path'].'bottomscripts.php'); ?>

	<!-- MODAL BOX POPUP -->
	<?php include_once($config['include_path'].'login_register_popup.php');  ?>
	<div id="openModal" class="modalDialogFollow">
		<div id="popup-content" class="follow-msg-content">
			<a href="#close" title="Close" class="close">X</a>
			<div class="small-12" id="follow-box">
				<header>PUCKERMOB</header>
				<section>
					<h1>Your are following this author!</h1>
					<p id="follow-msg" class="follow-msg" ></p>
				</section>
			</div>
		</div>
	</div>

	<!-- FACEBOOK COMMENTS BOX -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

</body>
</html>
<?php } ?>
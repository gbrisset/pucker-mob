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
$categoryInfo = array( "cat_id" => "6",  "cat_name"=> "Lifestyle", "cat_dir_name"=> "lifestyle",
 "cat_desc" => "",  "cat_tags" => "");
foreach($MPNavigation->categories as $category){

	if( isset($category['cat_dir_name'])  && !(isset($uri[2])) && ($category['cat_dir_name'] == $uri[0])  ){
		$categoryInfo = $category;
		$articleTitle = explode('&', preg_replace('/[?]/', '&', $uri[1]))[0];
		$hasParent = false;
	//	break;
	} else if(isset($category['cat_dir_name']) && (isset($uri[2])) && ($category['cat_dir_name'] == $uri[1]) ){
		$categoryInfo = $category;
		$articleTitle = explode('&', preg_replace('/[?]/', '&', $uri[2]))[0];
		$hasParent = true;
		//break;
	}
}

if(!is_null($categoryInfo)){
	$articleInfo = $mpArticle->getSingleArticleInfo(['articleSEOTitle' => $articleTitle]);
	$article_link = '';
	
	//CHECK IF ARTICLES IN REGISTER UNDER THAT CATEGORY
	$verifyInCat = $mpArticle->verifyArticleInCategory( $articleInfo['article_id'], $categoryInfo['cat_id']);
	
	if(isset($articleInfo) &&  $articleInfo && $verifyInCat ){
		$articleInfoObj = $articleInfo;

		$pageName = $articleInfoObj['article_title'];
		//get Article ADS info
		$article_ads = $mpArticleAdmin->getArticleAds($articleInfoObj);

		if($articleInfoObj['article_id'] == "4349"){
			$pageName = strtoupper($articleInfoObj['article_title']).' | Sponsored by Smarties Candies';
		}
		$relatedArticles = $mpArticle->getArticlesList([ 'limit'=> 6,  'pageId' => $categoryInfo['cat_id'], 'omit' => $articleInfo['article_id']]);
		
		$pagesArray['url'] = $config['this_url'].$categoryInfo['cat_dir_name'];
		$article_link = $config['this_url'].$categoryInfo['cat_dir_name'].'/'.$articleInfoObj['article_seo_title'];
	}else {
		$mpShared->get404();
	}
}else {
	$mpShared->get404();
}

?>
<?php if ( $detect->isMobile() ) { 
	$style = '';
	$article_id = '';
	if(isset($articleInfoObj)) $article_id = $articleInfoObj['article_id'];
?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<?php include_once($config['include_path'].'head.php');?>

<?php if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){ ?>
<body id="articleslide" class="mobile">
	<?php }else{ ?>
	<body id="article" class="mobile">
		<?php } ?>
		
		
		<?php include_once($config['include_path'].'header.php');?>
		<?php include_once($config['include_path'].'header_ad.php');?>

		
		
		<style>#nav-bar{ box-shadow: none;} #articlelist-wrapper{ padding-top:0 !important;} .evolve-media{margin-bottom: 5px; margin-top: 5px;  }</style>

		<main id="main" class="row panel sidebar-on-right" role="main" style="">
			<section id="puc-articles" class="sidebar-right small-12   translate-fix sidebar-main-left medium-index">
				
				
				<input type="hidden" value="<?php echo $article_id; ?>" id="article_id"/>
				
				<!-- ARTICLE CONTENT -->
				<?php 
				if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){
					include_once($config['template_path'].'multi_page_article.php');
				} else {
					include_once($config['template_path'].'single_page_article.php');
				}
				?>
				
			
			<?php if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){	?>
			<hr>
			<?php include_once($config['include_path'].'similararticles.php');?>
			<?php } ?>	
			
			<?php if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){	?>
			<!-- COMMENTS BOX -->
			<?php include_once($config['include_path'].'disqus.php'); ?>
			<hr>
			<?php }?>
		
		</section>
		
		<?php if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] == 0){	?>
		
		<section class="clear second-section low-index">
			<!-- 10  MOST RECENT ARTICLES ADDED -->
			<?php include_once( $config['include_path'].'most_recent_internal_articles.php'); ?>
		</section>
		<?php }?>
	</main>
		<!-- UNDERTONE -->
	<?php if(  $articleInfoObj['article_id'] != 16562  &&  $articleInfoObj['article_id'] != 17425 &&  $articleInfoObj['article_id']!= 14479 &&  $articleInfoObj['article_id']!= 14576 && $articleInfoObj['article_id'] !=  15109 && $articleInfoObj['article_id'] != 15271  && $articleInfoObj['article_id'] != 15284  && $articleInfoObj['article_id'] != 15488 && $articleInfoObj['article_id'] != 17286  ){?>
			<?php if($articleInfoObj['article_id'] == 5813 ){?>
				<!-- PROPELLER TAG 
				<script src="//go.mobstitialtag.com/notice.php?p=724477&interstitial=1"></script>-->
				<!-- /10394362/paz_724477 -->
				<div id='div-gpt-ad-1470928349713-0'>
				<script>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1470928349713-0'); });
				</script>
				</div>

			<?php }else{?>
			<!--/73970039/UT_SS_FP 
			<div id='div-gpt-ad-1461622964696-3'>
				<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1461622964696-3'); });
				</script>
			</div>-->

			<!-- /73970039/UT_SS_FP Screen Shift Full Page -->
			<!-- /73970039/UT_SS_FP -->
			<div id='div-gpt-ad-1470934220433-0' style='height:1px; width:1px;'>
			<script>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1470934220433-0'); });
			</script>
			</div>

				<!-- /73970039/UT_SS_Knox 
			<div id='div-gpt-ad-1467926983040-0' style='height:1px; width:1px;'>
				<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1467926983040-0'); });
				</script>
			</div>-->
			<?php }?>
			
		<?php } ?>
	<?php include_once('admin/fb/fbfunctions.php'); ?>
	<?php include_once($config['include_path'].'mobiletapsection.php'); ?>


	<!-- ADS TO LOAD -->
	<?php include_once($config['include_path'].'ads_to_load.php'); ?>
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

<?php } else { ?>
<!DOCTYPE html>
<html class="no-js" lang="en"  xmlns:fb="http://ogp.me/ns/fb#"> 
<?php include_once($config['include_path'].'head.php');?>

<?php if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){ ?>
<body id="articleslide">
	<?php }else{ ?>
	<body id="article">
	<?php } ?>

		<!-- UNDERTONE -->
	<?php if(  $articleInfoObj['article_id'] != 16562  &&  $articleInfoObj['article_id'] != 17425 &&  $articleInfoObj['article_id']!= 14479 &&  $articleInfoObj['article_id']!= 14576 && $articleInfoObj['article_id'] !=  15109 && $articleInfoObj['article_id'] != 15271  && $articleInfoObj['article_id'] != 15284  && $articleInfoObj['article_id'] != 15488 && $articleInfoObj['article_id'] != 17286  ){?>
			<!-- /73970039/UT_SS_FP
			<div id='div-gpt-ad-1461622964696-3'>
				<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1461622964696-3'); });
				</script>
			</div> -->

			<!-- /73970039/UT_SS_FP Screen Shift Full Page -->
			<!-- /73970039/UT_SS_FP -->
			<div id='div-gpt-ad-1470934220433-0' style='height:1px; width:1px;'>
			<script>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1470934220433-0'); });
			</script>
			</div>

			
			<!-- /73970039/SS_FP_US 
			<div id='div-gpt-ad-1469818259945-0' style='height:1px; width:1px;'>
				<script>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1469818259945-0'); });
				</script>
			</div>-->

		<?php } ?>

		<!--<div id="ros_adoop"></div>-->
		<?php include_once($config['include_path'].'new_header.php');?>
		<?php include_once($config['include_path'].'header_ad.php');?>

	<main id="main" class="row panel sidebar-on-right" role="main">

	<?php if(!$detect->isMobile()){?>
	<section id="puc-articles" class="cool sidebar-right  small-12 medium-12 large-11 columns translate-fix sidebar-main-left" style="min-height:none !important; height:auto; ">

		<?php }else{ ?>	
		<section id="puc-articles" class="cool sidebar-right  small-12 medium-12 large-11 columns translate-fix sidebar-main-left" style="z-index:999; min-height:none !important; height:auto;">
			<?php } ?>
			<input type="hidden" value="<?php echo $articleInfoObj['article_id']; ?>" id="article_id"/>
			<?php 
			if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){
				include_once($config['template_path'].'multi_page_article.php');
			} else {
				include_once($config['template_path'].'single_page_article.php'); 
			} ?>

			
			<!-- Setting the Poll -->			
			<?php if(strlen($articleInfoObj['article_poll_id']) > 0){ ?>
			<script src="http://assets-polarb-com.a.ssl.fastly.net/assets/polar-embedded.js" async="true" data-publisher="Sequel" data-poll-id="<?php echo $articleInfoObj['article_poll_id']; ?>"></script>
			<?php }?>

			<!-- Like us on FB --> 
			<?php if(!$detect->isMobile()){?>
			<?php if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] == 0){?>
			
			<div class="columns no-padding hide-for-print like-us-fb clear" style="margin-bottom: 2rem;">
				<p class="columns small-2">Join the Mob!
					<div class="columns small-9" >
						<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPuckerMob%2F1492027101033794&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=25&amp;appId=1473110846264937" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:25px; width: 100%;" allowTransparency="true"></iframe>	
					</div>	 
				</p>
			</div>	 
			
			
			<?php }
		}?>
		<?php if( $article_id != 16562 &&   $article_id != 17425 && $article_id != 17286 && $article_id != 14479 && $article_id != 14576  && $article_id != 15109   && $article_id != 15271 && $article_id != 15284  && $article_id != 15488 ){?>
		<!-- ADBLADE-->
		<div class="columns small-12 margin-top">
			<ins class="adbladeads" data-cid="21331-3493314697" data-host="web.adblade.com" data-tag-type="4" style="display:none"></ins>
			<script async src="http://web.adblade.com/js/ads/async/show.js" type="text/javascript"></script>
		</div>

		<?php }?>
		
		<!-- Also In PM -->
		<?php include_once( $config['include_path'].'similararticles.php'); ?>

		
	</section>
	<?php include_once($config['include_path'].'rightsidebar.php');?>

</main>

<?php 
include_once('admin/fb/fbfunctions.php'); 
include_once($config['include_path'].'bottomscripts.php');
?>

<!-- MODAL BOX POPUP -->
<?php
include_once($config['include_path'].'login_register_popup.php'); 

?>

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
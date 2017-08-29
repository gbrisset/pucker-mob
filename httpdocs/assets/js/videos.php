<?php
$categoryInfo = null;
$isVideoPage = true;

foreach($MPNavigation->categories as $category){
	if( isset($category['cat_dir_name'])&& !(isset($uri[1])) && isset($uri[0]) && ($category['cat_dir_name'] == $uri[0])  ){
		$categoryInfo = $category;
		$hasParent = false;
		break;
	} else if(isset($category['cat_dir_name'])&& isset($uri[1]) && ($category['cat_dir_name'] == $uri[1]) ){
		$categoryInfo = $category;
		$hasParent = true;
		break;
	}
}

if(!is_null($categoryInfo)){ 
	$cat_name = $categoryInfo['cat_dir_name'];
	$pageName = $categoryInfo['cat_name'].' | '.$mpArticle->data['article_page_name'];
	$parentCategorySEOName = ($categoryInfo['parent_dir_name']);
	$relatedArticles = $mpArticle->getMostRecentByCatId(['pageId' => $categoryInfo['cat_id']]);
	
}else $mpShared->get404(); 

if( isset($cat_name) ){
          $video = false;
          $hottopicsClass = $entClass = $wellnessClass = " ";
          switch($cat_name){
            case "hot-topics":
              $video = "<script type='text/javascript' id='f0081fd6ddcfb249ab5aaea4032394ab'>try{ var s=document.createElement('script'); s.type='text/javascript'; s.src='http://www.mefeedia.com/newestentry/mf3.0.1.php?playerID=f0081fd6ddcfb249ab5aaea4032394ab'; document.body.appendChild(s);}catch(e){}</script>";
              $hottopicsClass="active";
              break;

            case "entertainment":
              $video = "<script type='text/javascript' id='25b39db626155ff5ab05d87c49c0afbe'>try{ var s=document.createElement('script'); s.type='text/javascript'; s.src='http://www.mefeedia.com/newestentry/mf3.0.1.php?playerID=25b39db626155ff5ab05d87c49c0afbe'; document.body.appendChild(s);}catch(e){}</script>";
              $entClass="active";	
              break;

            case "wellness":
              $video = "<script type='text/javascript' id='6643792e9b546760d0c9e19ead7fc3b4'>try{ var s=document.createElement('script'); s.type='text/javascript'; s.src='http://www.mefeedia.com/newestentry/mf3.0.1.php?playerID=6643792e9b546760d0c9e19ead7fc3b4'; document.body.appendChild(s);}catch(e){}</script>";
              $wellnessClass = "active";
              break;

            default: 
              $video = false;
              break;
          }
       } ?>




	<!DOCTYPE html>
	<html class="no-js" lang="en">
	<?php include_once($config['include_path'].'head.php');?>
	<body id="videos">
		<?php include_once($config['include_path'].'header.php');?>
		<?php include_once($config['include_path'].'header_ad.php');?>
		<section id="" class="fullsize-section row panel shadow-on-large-up translate-fix">
			<h1><?php echo $categoryInfo['cat_name']; ?> Videos</h1>
		</section>
		<?php if($video){?>
		<section id="" class="fullsize-section row panel shadow-on-large-up translate-fix">
			<dl class="sub-nav">
			  <dt>Categories:</dt>
			  <dd class="<?php echo $hottopicsClass; ?>"><a href="<?php echo $config['this_url'].'videos/hot-topics'; ?>">Hot Topics</a></dd>
			  <dd class="<?php echo $entClass; ?>" ><a href="<?php echo $config['this_url'].'videos/entertainment'; ?>">Entertainment</a></dd>
			  <dd class="<?php echo $wellnessClass; ?>" ><a href="<?php echo $config['this_url'].'videos/wellness'; ?>">Wellness</a></dd>
			</dl>
			<hr style="margin-top: -0.3rem;">
			<?php echo $video; ?>
		</section>
		<?php } ?>
		<main id="main" class="row panel sidebar-on-right" role="main">
			<section id="puc-articles" class="sidebar-right shadow-on-large-up small-12 medium-12 large-11 columns translate-fix sidebar-main-left">
					<section class="small-12 column padding-bottom padding-top">
					  <div id="atfleft-ad" class="ad-unit ad300 show-on-large-up left"></div>
					  <div id="atfright-ad" class="ad-unit ad300 show-on-large-up right"></div>
					</section>
					<hr>
					<!-- Like us on FB --> 
					<div class="row hide-for-print like-us-fb">
						<p class="columns small-2">Join the Mob!
							<div class="columns small-9" >
								<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPuckerMob%2F1492027101033794&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=25&amp;appId=1473110846264937" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:25px; width: 100%;" allowTransparency="true"></iframe>	
							</div>	 
						</p>
					</div>	 
					
					<?php include_once($config['include_path'].'similararticles.php');?>
					
					<div id="medianet-ad" class="ad-unit hide-for-print padding-right show-for-xxlarge-only"></div>
					<hr>
					<?php include_once($config['include_path'].'fromourpartners.php'); ?>
			</section>
			<?php include_once($config['include_path'].'rightsidebar.php');?>
		</main>
		<?php include_once($config['include_path'].'footer.php');?>
		<?php include_once($config['include_path'].'bottomscripts.php');?>
		
	</body>
	</html>

<?php
$categoryInfo = null;
$isArticle = true;
$articleInfoObj = array();
foreach($MPNavigation->categories as $category){
	if( isset($category['cat_dir_name'])  && !(isset($uri[2])) && ($category['cat_dir_name'] == $uri[0])  ){
			// uri[2] not set, cat has no parent
		$categoryInfo = $category;
		$articleTitle = explode('&', preg_replace('/[?]/', '&', $uri[1]))[0];
		$hasParent = false;
		break;
	} else if(isset($category['cat_dir_name']) && (isset($uri[2])) && ($category['cat_dir_name'] == $uri[1]) ){
			// uri[2] set! cat has parent!
		$categoryInfo = $category;
		$articleTitle = explode('&', preg_replace('/[?]/', '&', $uri[2]))[0];
		$hasParent = true;
		break;
	}
}

if(!is_null($categoryInfo)){
	$articleInfo = $mpArticle->getArticles(['articleSEOTitle' => $articleTitle]);

	if(isset($articleInfo['articles']) &&  $articleInfo['articles']){
		$articleInfoObj = $articleInfo['articles'][0];
		$pageName = $articleInfoObj['article_title'].' | '.$mpArticle->data['article_page_name'];
		$relatedArticles = $mpArticle->getArticles(['count' => 18, 'pageId' => $categoryInfo['cat_id'], 'omit' => $articleInfo['ids']]);
		$articleImages = $mpArticle->getArticlesImages($articleInfoObj['article_id']);
	}else {
		$mpShared->get404();
	}
}else {
	$mpShared->get404();
}
if (isset($hasParent) && $hasParent){
	$parentCategorySEOName = $categoryInfo['parent_dir_name'];
	$parentCategoryVisibleName = $categoryInfo['parent_name'];
	$article_link = $config['this_url'].$parentCategorySEOName.'/'.$categoryInfo['cat_dir_name'].'/'.$articleInfoObj['article_seo_title'];
	$pagesArray['url'] = $config['this_url'].$parentCategorySEOName.'/'.$categoryInfo['cat_dir_name'];
} else {
	$pagesArray['url'] = $config['this_url'].$categoryInfo['cat_dir_name'];
	$article_link = $config['this_url'].$categoryInfo['cat_dir_name'].'/'.$articleInfoObj['article_seo_title'];
}
?>
<?php if ( $detect->isMobile() ) { ?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<?php if(isset($articleInfoObj['article_template_type']) && $articleInfoObj['article_template_type'] == 1){ ?>
<body id="recipe" class="mobile">
	<?php }else{ ?>
	<body id="article" class="mobile">
		<?php } ?>

		<?php include_once($config['include_path'].'header.php');?>
		<?php include_once($config['include_path'].'header_ad.php'); ?>
		<main id="main" class="row panel sidebar-on-right shadow-on-large-up" role="main">
			<section id="puc-articles" class="sidebar-right shadow-on-large-up small-12 columns translate-fix sidebar-main-left">
					<input type="hidden" value="<?php echo $articleInfoObj['article_id']; ?>" id="article_id"/>
			<?php 
			if(isset($articleInfoObj['article_template_type']) && $articleInfoObj['article_template_type'] == 1){
				include_once($config['template_path'].'recipe.php');
			}else{
				if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){
					include_once($config['template_path'].'multi_page_article.php');
				} else {
					include_once($config['template_path'].'single_page_article.php');
				}

			}
			?>
			<!-- CONTENT.AD --> 
			<div id="contentad21632"></div>
			<script type="text/javascript">
			(function() {
				var params =
				{
					id: "2373268a-f985-4ab3-9e1e-45708d50a8cb",
					d:  "c2ltcGxlZGlzaC5jb20=",
					wid: "21632",
					cb: (new Date()).getTime()
				};

				var qs="";
				for(var key in params){qs+=key+"="+params[key]+"&"}
					qs=qs.substring(0,qs.length-1);
				var s = document.createElement("script");
				s.type= 'text/javascript';
				s.src = "http://api.content.ad/Scripts/widget.aspx?" + qs;
				s.async = true;
				document.getElementById("contentad21632").appendChild(s);
			})();
			</script>

			<!-- Prev & Next Articles -->
			<?php include_once($config['include_path'].'prevnextarticles.php'); ?>
			
			<hr>
			<?php include_once($config['include_path'].'similararticles.php');?>
			
			<?php include_once($config['include_path'].'abouttheauthor.php'); ?>
			
			<?php include_once($config['include_path'].'disqus.php'); ?>
		</section>
		</main>
		<?php include_once($config['include_path'].'footer.php');?>
		<?php include_once($config['include_path'].'bottomscripts.php');?>
		<!-- Go to www.addthis.com/dashboard to customize your tools -->
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c4498040efc634" ></script>

	</body>
	</html>
	<?php } else { ?>
	<!DOCTYPE html>
	<html class="no-js" lang="en"  xmlns:fb="http://ogp.me/ns/fb#"> 
	<?php include_once($config['include_path'].'head.php');?>
	<body id="article">
	
		
		<?php include_once($config['include_path'].'header.php');?>
		<?php include_once($config['include_path'].'header_ad.php');?>
		<main id="main" class="row panel sidebar-on-right" role="main">
			<section id="puc-articles" class="sidebar-right shadow-on-large-up small-12 medium-12 large-11 columns translate-fix sidebar-main-left" style="z-index:999;">
					<input type="hidden" value="<?php echo $articleInfoObj['article_id']; ?>" id="article_id"/>
				<?php 
				if(isset($articleInfoObj['page_list_id']) && $articleInfoObj['page_list_id'] != 0){
					include_once($config['template_path'].'multi_page_article.php');

				} else {
					include_once($config['template_path'].'single_page_article.php');
				} ?>
				<hr>

				<!-- Setting the Pod -->			
				<?php 
				if(strlen($articleInfoObj['article_poll_id']) > 0){ ?>
					<script src="http://assets-polarb-com.a.ssl.fastly.net/assets/polar-embedded.js" async="true" data-publisher="Sequel" data-poll-id="<?php echo $articleInfoObj['article_poll_id']; ?>"></script>
					<hr>
				<?php }?>
				
				
				
				<!-- Like us on FB --> 
				<div class="row hide-for-print like-us-fb">
					<p class="columns small-2">Join the Mob!
						<div class="columns small-9" >
							<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FPuckerMob%2F1492027101033794&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=25&amp;appId=1473110846264937" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:25px; width: 100%;" allowTransparency="true"></iframe>	
						</div>	 
					</p>
				</div>	 
				<hr>

				<!-- Prev & Next Articles -->
				<?php include_once($config['include_path'].'prevnextarticles.php'); ?>

				
				<!-- LIFT AD -->
				<div id="lift-ad">
					<script src="http://ib.3lift.com/ttj?inv_code=puckermob_article_sub"></script>
				</div>

				<?php include_once($config['include_path'].'abouttheauthor.php'); ?>
				<hr>

				<!-- Media Net -->
				<div id="medianet-ad" class="ad-unit hide-for-print padding-right show-for-xxlarge-only"></div>

				<?php include_once($config['include_path'].'similararticles.php');?>
				<hr>
				<?php include_once($config['include_path'].'aroundtheweb.php'); ?>
				<hr>
				<?php include_once($config['include_path'].'disqus.php'); ?>

			</section>
			<?php include_once($config['include_path'].'rightsidebar.php');?>
		</main>
		<!-- Gum Gum -->
		<?php if($articleInfoObj['article_id'] != 3978 ){?>
		<script>ggv2id='64bad626';</script>
		<?php }?>

		<?php include_once($config['include_path'].'footer.php');?>
		<?php include_once($config['include_path'].'bottomscripts.php');?>
		<!-- Go to www.addthis.com/dashboard to customize your tools -->
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c4498040efc634"></script>

	

	</body>
	</html>
	<?php } ?>
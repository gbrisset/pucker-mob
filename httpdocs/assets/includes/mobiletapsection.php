<?php 
	//MOST POPULAR
	$article_id = isset($articleInfoObj['article_id']) ? $articleInfoObj['article_id'] : false;
	$featured_articles = $mpArticle->getFeaturedArticles();

?>
<style>
	nav.menu{ background: #78ad6c; }
	nav.slide-menu-left:after{background: #78ad6c;}
	iframe{ display:inline-block; z-index:1000000000 !important;}
	/*div#mobile-instream-branovate-ad.row.ad-unit.hide-for-print.padding-top.no-padding{ 
		position:relative;
		z-index:777777777;
		height:260px; 
	}
	#tap-section ins.adsbygoogle{
		position:relative;
		top:-250px;
		height: 250px;
	}*/

</style>
<div class="small-12" id="slide-menu-left-div">
	<nav class="menu slide-menu-left small-12" id="tap-section" >
		<h2 class="uppercase featured-title">Featured Articles</h2>
		<div class="content-wrapper columns no-padding small-12">
		<?php 
				if($featured_articles){
					$index = 0;
					foreach($featured_articles as $farticle){
						$article_title = $farticle['article_title'];
						$article_seo_title = $farticle['article_seo_title'];
						$article_id = $farticle['article_id'];
						$article_desc = $farticle['article_desc'];
						$name = $farticle['contributor_name'];
						$seo_name = $farticle['contributor_seo_name'];
						$category = $farticle['cat_dir_name'];
						$link_article = $config['this_url'].$category.'/'.$article_seo_title;
						$index++;

					?>
					<div class="columns small-12 padding-top featured-wrapper-div">
					
					<div id="article-featured-<?php echo $article_id; ?>" class="columns small-12 no-padding remove-border">
						<div id="article-summary" class="small-12 column ">
							
							<!-- TITLE -->
							<h1 style="font-size: 1.55rem;"><?php echo $article_title; ?></h1>
							
							<div class="small-12 padding-bottom">
								<?php if(!empty($article_desc) ){?><p class="description" style="margin-bottom:0;"><?php echo $article_desc; ?></p><?php }?>
							</div>

							<!-- Article Image -->
							<div class="clear margin-bottom" style="background: black;     margin-bottom: 5px !important;">
								<div id="article-image " class=" no-padding tinted-image " style="opacity: 0.5;">
									<a href="<?php echo $link_article; ?>">
										<img src="<?php echo 'http://images.puckermob.com/articlesites/puckermob/large/'.$article_id.'_tall.jpg'; ?>" alt="<?php echo $article_title; ?> Image">
									</a>
								</div>
								<span class="span-middle-label-img"><a href="<?php echo $link_article; ?>">Click to read full article</a></span>

							</div>
							
						</div>
							<div id = "mobile-instream-branovate-ad" class="row ad-unit hide-for-print padding-top no-padding" style="margin-bottom: 10px !important; z-index:1000000000 !important	">
								<!--<div style="height: 250px;background:transparent; z-index:6666666666666; position:relative;"></div>-->
								<?php


									 switch ($index) {
									 	case 1: 
											include($config['include_path'] . 'ads/amazon_1.php');
									 		break;
									 	case 2: 
											include($config['include_path'] . 'ads/amazon_2.php');
									 		break;
									 	case 3: 
											include($config['include_path'] . 'ads/amazon_3.php');
									 		break;
									 	case 4: 
											// include($config['include_path'] . 'ads/amazon_4.php');//this unit has been moved to End of Article - 2017-04-04
									 		break;
									 }//end switch ($article_id)

								?>
							</div>
					</div>
					</div>
					<?php }
				}else{
					echo '<p>No Featured article available.</p>';
				}
			?>
		
		</div>
	</nav>
 	<button class="nav-toggler toggle-slide-left rotate " style="background: #78ad6c;">MORE</button>
</div>
<!-- Featured Article -->
<?php 
$articleIndex = 0;
$bigImageCounter =  0;
$smallImageCounter = 0;
$quantity = 24;
$omitThis = 0;
$cat_id = $mpArticle->data['cat_id'];

$featuredArticle = false;//$mpArticle->getFeaturedArticle( $cat_id );
if( $featuredArticle && $featuredArticle['article_status'] == 1){
	$articleIndex++;
	$quantity = 25;
	$omitThis =  $featuredArticle['article_id'];

	include_once($config['include_path'].'featured_article.php');
if(isset($has_sponsored) && $has_sponsored){ /*DO NOTHING*/ }
	else{ ?>
	<!-- ShareT -->
	<div id="shareT-ad" style="margin-bottom: 0.5rem;" class="columns mobile-12 small-12 medium-12 large-12 xlarge-12 no-padding padding-bottom">
		<div data-str-native-key="6898172d" style="display: none;"></div>
		<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
	</div>
	<hr class="padding-top">
	<?php }
}

//$articlesList = $mpArticle->getArticles(['count' => $quantity, 'omit' => [ $omitThis ]]);
//$articlesList = $mpArticle->getArticlesList(['limit' => $quantity, 'omit' => $omitThis ]);
/* Article List */
	// If is HomePage Get new article List
if( $cat_id == 1){
	$articlesList = $mpArticle->getMobileArticleList(['limit' => '10', 'offset'=>'0', 'omit' => $omitThis, 'withMobLogs'=> true ]);
}else{
	$articlesList = $mpArticle->getMobileArticleList(['limit' => '10', 'offset'=>'0', 'omit' => $omitThis , 'pageId' => $cat_id, 'withMobLogs'=> false ] );
}

$totalArticles = count($articlesList );

foreach ($articlesList as $articles){

	$linkToArticle = $config['this_url'].$articles['cat_dir_name'].'/'.$articles["article_seo_title"];
	$linkToACategory = $config['this_url'].$articles['cat_dir_name'];
	$date = date("M d, Y", strtotime($articles['date_updated']));
	$linkToImage = $config['image_url'].'articlesites/puckermob/large/'.$articles['article_id'].'_tall.jpg';
	$linkToContributor = $config['this_url'].'contributors/'.$articles['contributor_seo_name'];
	$cat_name = $articles['cat_dir_name'];
	
	//IGNORE MOBLOG ARTICLES
	if( !isset($category_page) && $cat_name === "moblog" && $articles['article_featured_hp'] != 1) continue;

	if( $articleIndex % 7 == 0 ) { 
		$articleIndex++;
		$bigImageCounter++; 
		?>
		<div class="columns mobile-12 small-12 medium-12 large-12 xlarge-12 no-padding" id="<?php echo 'article-'.$articleIndex;?>">
			<a class="mobile-12 tablet-12 small-12 medium-12 large-12 xlarge-12 prefetch" href="<?php echo $linkToArticle; ?>">
				<img src="<?php echo $linkToImage; ?>" alt='<?php echo $articles['article_title']?>'>
			</a>
			<div class="mobile-12 small-12 medium-12 large-12 xlarge-12 padding-top padding-top-tablet padding-bottom-tablet">
				<p class="left uppercase " >
					<!--<span class="span-category <?php //echo $articles['cat_dir_name']?>"><a href="<?php echo $linkToACategory; ?>" ><?php //echo $articles['cat_name']?></a></span>-->
					<span class="span-date hide-on-tablet"><?php echo $date; ?></span>
				</p>
				<p class="right uppercase hide-on-tablet">
					<span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $articles['contributor_name']; ?></a></span>
				</p>
				<a class="left clear-left" href="<?php echo $linkToArticle; ?>">
					<h1 class="h1-large-article"><?php echo $articles['article_title']?></h1>
				</a>
			</div>
		</div>
		<?php if( $articleIndex < $totalArticles )?> <hr class="padding-top">
		
		<?php //if($bigImageCounter == 1){?>
		<?php //}?>

		<?php  } else{
			
			$clearLeft='no-padding-right'; 
			if( $smallImageCounter == 0 || $smallImageCounter % 2 == 0) $clearLeft = 'clear-left no-padding-left';
			$smallImageCounter++;
			$articleIndex++; 
			$linkToImage .= '?ggnoads';

			?>
			<div class="articles columns mobile-12 tablet-6 small-12 medium-6 large-6 xlarge-6 <?php echo $clearLeft; ?> ggnoads" id="<?php echo 'article-'.$articleIndex;?>">
				<a class="mobile-12 small-12 medium-12 large-12 xlarge-12 prefetch padding-bottom-tablet" href="<?php echo $linkToArticle; ?>">
					<img src="<?php echo $linkToImage; ?>" alt='<?php echo $articles['article_title']?>'>
				</a>
				<div class="mobile-12 small-12 medium-12 large-12 xlarge-12 padding-top padding-top-tablet padding-bottom-tablet">
					<p class="uppercase small-7 left small-font padding-top-tablet">
						<!--<span class="span-category <?php //echo $articles['cat_dir_name']?> padding-bottom-tablet"><a href="<?php //echo $linkToACategory; ?>" ><?php //echo $articles['cat_name']?></a></span>-->
						<span class="span-date hide-on-tablet"><?php echo $date; ?></span>
					</p>
					<p class="right uppercase small-5 align-right small-font hide-on-tablet ">
						<span class="span-author ">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $articles['contributor_name']; ?></a></span>
					</p>
					<a class="left clear-left padding-top-tablet" href="<?php echo $linkToArticle; ?>">
						<h1 class="h1-small-article"><?php echo $articles['article_title']?></h1>
					</a>
				</div>
			</div>
			<?php 
			if( $smallImageCounter % 2 == 0  && $articleIndex < $totalArticles) echo '<hr class="padding-top">';
		} ?> 
	</div>

	<?php } ?>
	<style>
	.str-adunit.hosted-video.str-collapsed, .str-adunit.clickout.str-collapsed{border:none !important;}
	</style>

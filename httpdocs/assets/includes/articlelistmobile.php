
<div class = "row half-padding">
	<?php 

	$articleIndex = 0;
	$quantity = 24;
	$omitThis = 0;
	$cat_id = $mpArticle->data['cat_id'];
	if(isset($categoryInfo) &&  $categoryInfo){
		$cat_id = $categoryInfo['cat_id'];
	}

	$featuredArticle = $mpArticle->getFeaturedArticle( $cat_id );
	if( $featuredArticle && $featuredArticle['article_status'] == 1){
		$articleIndex++;
		$quantity = 25;
		$omitThis =  $featuredArticle['article_id'];
		include_once($config['include_path'].'featured_article.php');
	}

	// If is HomePage Get new article List
	if( $cat_id == 1){
		$articlesList = $mpArticle->getArticles(['count' => $quantity, 'omit' => [ $omitThis ]]);
	}
	

	foreach ($articlesList['articles'] as $articles){

		$linkToArticle = $config['this_url'].$articles['cat_dir_name'].'/'.$articles["article_seo_title"];
		$linkToACategory = $config['this_url'].$articles['cat_dir_name'];
		$date = date("M d, Y", strtotime($articles['creation_date']));
		$linkToImage = $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$articles['article_id'].'_tall.jpg';
		$linkToContributor = $config['this_url'].'contributors/'.$articles['contributor_seo_name'];

		$articleIndex++;
		?>

		<!-- SHARETHROUGH HOMEPAGE Mobile Placement -->
		<?php if( $articleIndex == 2 ){ ?>
		<div class="columns mobile-12 no-padding">
			<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
			<div data-str-native-key="c2887a0b" style="display: none;"></div>
		</div>
			<?php } ?>

		<div class="columns mobile-12 no-padding" id="<?php echo 'article-'.$articleIndex;?>">
			<a class="mobile-12 no-padding" href="<?php echo $linkToArticle; ?>">
				<img src="<?php echo $linkToImage; ?>" alt='<?php echo $articles['article_title']?>'>
			</a>
			<div class="mobile-12 no-padding-mobile">
				<p class="mobile-12 no-padding uppercase" >
					<span class="span-category <?php echo $articles['cat_dir_name']?>"><a href="<?php echo $linkToACategory; ?>" ><?php echo $articles['cat_name']?></a></span>
				</p>
				<a class="left clear-left" href="<?php echo $linkToArticle; ?>">
					<h1 class="no-margin-mobile"><?php echo $articles['article_title']?></h1>
				</a>
			</div>
		</div>
		<hr>
		
	

		<?php if( $articleIndex == 4 ){ ?>
		<div class="columns mobile-12 no-padding">
			<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
			<div data-str-native-key="98e3b5d6" style="display: none;"></div>
		</div>
		
		<?php } 

		if( $articleIndex % 7 == 0 ) { ?>
		<!-- 3LIFT -->
		
			<div id="lift-ad">
				<script src="http://ib.3lift.com/ttj?inv_code=puckermob_mobile_feed"></script> 
			</div>
		<?php }
	}
?>

</div>
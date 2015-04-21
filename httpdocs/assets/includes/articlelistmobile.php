
<div class = "row no-padding padding-top">
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
		$quantity = 24;
		$omitThis =  $featuredArticle['article_id'];
		include_once($config['include_path'].'featured_article.php');
	}

	// If is HomePage Get new article List
	if( $cat_id == 1){
		$articlesList = $mpArticle->getArticles(['count' => $quantity, 'omit' => [ $omitThis ]]);
	}
	
	foreach ($articlesList['articles'] as $articles){
//$config['this_url']
		$linkToArticle = 'http://www.puckermob.com/'.$articles['cat_dir_name'].'/'.$articles["article_seo_title"];
		$date = date("M d, Y", strtotime($articles['date_updated']));
		$article_id = $articles['article_id'];
		$linkToImage = 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$articles['article_id'].'_tall.jpg';//$config['image_url'].'articlesites/puckermob/large/'.$articles['article_id'].'_tall.jpg';
		$totalShares = isset( $shares_arr[$article_id] ) ? $shares_arr[$article_id] : 1 ;

		//$sharesValue = ( $totalShares > 0 ) ? $mpHelpers->bd_nice_number($totalShares) : 0 ;
		
		//$linkToContributor = $config['this_url'].'contributors/'.$articles['contributor_seo_name'];
		$cat_name = $articles['cat_dir_name'];
		//$linkToACategory = $config['this_url'].$articles['cat_dir_name'];
		
		//IGNORE MOBLOG ARTICLES
		if( !isset($category_page) && $cat_name === "moblog") continue;

		$articleIndex++; ?>

		<!-- SHARETHROUGH HOMEPAGE Mobile Placement -->
		<?php if( $articleIndex == 2 ){ ?>
			<div class="columns mobile-12 no-padding">
				<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
				<div data-str-native-key="c2887a0b" style="display: none;"></div>
			</div>
		<?php } ?>

		<div class="columns small-12 second-popular-articles-cont article-id" id="<?php echo 'article-'.$articleIndex; ?>" data-info-url="<?php echo $linkToArticle; ?>">
			<div class="row imageContainer" id="<?php echo 'article-'.$articleIndex; ?>">
				<div class="small-12 columns imageCenterer">
					<a  class="" href="<?php echo $linkToArticle; ?>" >
						<img src="<?php echo $linkToImage; ?>" alt="<?php echo  $articles['article_title']; ?>" />
					</a>
				</div>
			</div>				
			<div class="small-12 columns second-popular-article-title">
				<h2 class="left small-12 padding-top">
					<a  class="" href="<?php echo $linkToArticle; ?>" >
					<?php echo $articles['article_title']; ?>
				    </a>
				</h2>
			</div>
			<div class="second-article-date small-12 clear">
				<label class="small-6" ><?php echo $date; ?></label>
				<label class="small-6 span-shares-holder"></label>
			</div>
		</div>
		
		
		<?php if( $articleIndex == 4 ){ ?>
		<div class="columns mobile-12 no-padding">
			<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
			<div data-str-native-key="98e3b5d6" style="display: none;"></div>
		</div>
		
		<?php } 

		//if( $articleIndex % 7 == 0 ) { ?>
		<!-- 3LIFT 
		
			<div id="lift-ad">
				<script src="http://ib.3lift.com/ttj?inv_code=puckermob_mobile_feed"></script> 
			</div> -->
		<?php //}
	}
?>

</div>
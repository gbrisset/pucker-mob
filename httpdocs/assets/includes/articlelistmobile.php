
<div class = "row no-padding padding-top" id="articlelist-wrapper">
	<?php 

	$articleIndex = 0;
	$quantity = 30;
	$omitThis = 0;
	$cat_id = $mpArticle->data['cat_id'];
	if(isset($categoryInfo) &&  $categoryInfo){
		$cat_id = $categoryInfo['cat_id'];
	}

	// If is HomePage Get new article List
	/*if( $cat_id == 1){
		$articlesList = $mpArticle->getArticlesListView(['limit' => '30', 'offset'=>'0', 'omit' => $omitThis, 'user_type'=> '1, 6, 7, 8' ]);
	}else{
		$articlesList = $mpArticle->getArticlesListView(['limit' => '30', 'offset'=>'0', 'omit' => $omitThis , 'pageId' => $cat_id ] );
	}*/

	if(isset($articlesList) && $articlesList){
	
	foreach ($articlesList as $articles){

		$linkToArticle = 'http://www.puckermob.com/'.$articles['cat_dir_name'].'/'.$articles["article_seo_title"];
		$date = date("M d, Y", strtotime($articles['date_updated']));
		$article_id = $articles['article_id'];
		$linkToImage = 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$articles['article_id'].'_tall.jpg';//$config['image_url'].'articlesites/puckermob/large/'.$articles['article_id'].'_tall.jpg';
		$cat_name = $articles['cat_dir_name'];
	
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
				<label class="small-6 left" ><?php echo $date; ?></label>
				<label class="small-6 span-shares-holder"></label>
			</div>
		</div>
		
		<?php if( $articleIndex == 4 ){ ?>
		<div class="columns mobile-12 no-padding">
			<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
			<div data-str-native-key="98e3b5d6" style="display: none;"></div>
		</div>
		
		<?php } 
	}
	}
?>
<div id="article-list" class="small-12 clear margin-top"></div>
</div>
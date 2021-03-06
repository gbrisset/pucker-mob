<?php 
$articleIndex = 0;
$bigImageCounter =  1;
$smallImageCounter = 0;

if (empty($_GET['per_page'])) {
	$quantity = 46;
} else {
	$quantity = $_GET['per_page'];
}


if (empty($_GET['page'])) {
	$page = 0;
} else {
	$page = $_GET['page'];
}
$has_sponsored = 0;
$omitThis = 0;
$offset = $quantity * $page;
$cat_id = $mpArticle->data['cat_id'];

$featuredArticle = false;
/*if( $featuredArticle && $featuredArticle['article_status'] == 1){
	$articleIndex++;
	$omitThis =  $featuredArticle['article_id'];

	//FEATURED ARTICLE
	//include_once($config['include_path'].'featured_article.php');

	if(isset($has_sponsored) && $has_sponsored){ 
	else{ if( $page == 0 ){?>
		<!-- ShareT -->
		<div id="shareT-ad" style="margin-bottom: 0.5rem;" class="columns mobile-12 small-12 medium-12 large-12 xlarge-12 no-padding padding-bottom">
			<div data-str-native-key="6898172d" style="display: none;"></div>
			<script type="text/javascript" src="//native.sharethrough.com/assets/str-dfp.js"></script>
		</div>
		<hr class="padding-top">
	<?php }}
}*/



/* Article List */
$totalArticles = count($articlesList);
if(isset($articlesList) && $articlesList){
	foreach ($articlesList as $articles){

	$linkToArticle = $config['this_url'].$articles['cat_dir_name'].'/'.$articles["article_seo_title"];
	$linkToACategory = $config['this_url'].$articles['cat_dir_name'];
	$date = date("M d, Y", strtotime($articles['date_updated']));
	$linkToImage = 'http://images.puckermob.com/articlesites/puckermob/large/'.$articles['article_id'].'_tall.jpg';
	$linkToContributor = $config['this_url'].'contributors/'.$articles['contributor_seo_name'];
	$cat_name = $articles['cat_dir_name'];
	$contributorName = $articles['contributor_name'];
	$articleTitle = $articles['article_title'];
	
	//IGNORE MOBLOG ARTICLES
	//if( !isset($category_page) && $cat_name === "moblog" && $articles['article_featured_hp'] != 1) continue;

	if( $articleIndex % 7 == 0 ) { 
		$articleIndex++; $bigImageCounter++; 

	 ?>
		<div class="columns mobile-12 small-12 medium-12 large-12 xlarge-12 no-padding" id="<?php echo 'article-'.$articleIndex;?>">
			<a class="mobile-5 small-5 medium-5 large-12 xlarge-12 " href="<?php echo $linkToArticle; ?>">
				<img src="<?php echo $linkToImage; ?>" alt='<?php echo $articleTitle; ?>'>
			</a>
			<div class="mobile-12 small-12 medium-12 large-12 xlarge-12 mobile-vertical-center padding-top">
				<p class="left uppercase" >
					<span class="span-date"><?php echo $date; ?></span>
				</p>
				<p class="right uppercase">
					<span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $contributorName; ?></a></span>
				</p>
				<a class="left clear-left" href="<?php echo $linkToArticle; ?>">
					<h3 class="h1-large-article"><?php echo $articleTitle?></h3>
				</a>
			</div>
		</div>
		<?php 
		if( $articleIndex < $totalArticles ) echo '<hr class="padding-top">'; 
	}else{
		$clearLeft='no-padding-right'; 
		if( $smallImageCounter == 0 || $smallImageCounter % 2 == 0) $clearLeft = 'clear-left no-padding-left';
		$smallImageCounter++;
		$articleIndex++; 
		
		?>	
		<div class="articles columns mobile-12 small-12 medium-6 large-6 xlarge-6 <?php echo $clearLeft; ?>" id="<?php echo 'article-'.$articleIndex;?>">
			<a class="mobile-5 small-5 medium-12 large-12 xlarge-12 " href="<?php echo $linkToArticle; ?>">
				<img src="<?php echo $linkToImage; ?>" alt='<?php echo $articleTitle?>'>
			</a>
			<div class="mobile-12 small-12 medium-12 large-12 xlarge-12 mobile-vertical-center padding-top">
				<p class="uppercase small-7 left small-font">
					<span class="span-date"><?php echo $date; ?></span>
				</p>
				<p class="right uppercase small-5 align-right small-font">
					<span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $contributorName ?></a></span>
				</p>
				<a class="left clear-left" href="<?php echo $linkToArticle; ?>">
					<h3 class="h1-small-article"><?php echo $articleTitle?></h3>
				</a>
			</div>
		</div>
		<?php 
			if( $smallImageCounter % 2 == 0  && $articleIndex < $totalArticles) echo '<hr class="padding-top">';
		} ?> 

<?php } ?>

<?php } ?>

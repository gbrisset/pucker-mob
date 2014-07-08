

<?php 
$articlesList = $mpArticle->getArticles(['count' => 24]);

$articleIndex = 0;
foreach ($articlesList['articles'] as $articles){

	$linkToArticle = $config['this_url'].$articles['cat_dir_name'].'/'.$articles["article_seo_title"];
	$linkToACategory = $config['this_url'].$articles['cat_dir_name'];
	$date = date("M d, Y", strtotime($articles['creation_date']));
	$linkToImage = $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$articles['article_id'].'_tall.jpg';
	$linkToContributor = $config['this_url'].'contributors/'.$articles['contributor_seo_name'];

	//$linkToImage = 'http://images.puckermob.com/articlesites/puckermob/list/Closet--intro.jpg';
	?>
	<!--<article class="row" id="<?php echo 'article-'.$articleIndex;?>">-->
		<?php if ( $detect->isMobile() ) {  $articleIndex++;?>
		<div class="columns mobile-12 small-12 medium-12 large-12 xlarge-12" id="<?php echo 'article-'.$articleIndex;?>">
			<a class="mobile-5 small-5 medium-5 large-5 xlarge-5 half-padding-right left" href="<?php echo $linkToArticle; ?>">
				<img src="<?php echo $linkToImage; ?>" alt='<?php echo $articles['article_title']?>'>
			</a>
			<div class="mobile-7 small-7 medium-7 large-7 xlarge-7 half-padding-left mobile-vertical-center vertical-align-center">
				<p class="vertical-center">
					<span class="span-category"><?php echo $articles['cat_name']?></span>
					<small><?php echo $date; ?></small>
				</p>
				<a href="<?php echo $linkToArticle; ?>">
					<h5><?php echo $articles['article_title']?></h5>
				</a>
				<p><small>By <a href="<?php echo $linkToContributor; ?>" ><?php echo $articles['contributor_name']; ?></a></small></p>
			</div>
		</div>
		<?php }else{?>
		
		<?php if($articleIndex == 0 || ($articleIndex % 7 == 0) ) { $articleIndex++; ?>
		<div class="columns mobile-12 small-12 medium-12 large-12 xlarge-12 no-padding" id="<?php echo 'article-'.$articleIndex;?>">
			<a class="mobile-5 small-5 medium-5 large-12 xlarge-12" href="<?php echo $linkToArticle; ?>">
				<img src="<?php echo $linkToImage; ?>" alt='<?php echo $articles['article_title']?>'>
			</a>
			<div class="mobile-7 small-7 medium-7 large-12 xlarge-12 mobile-vertical-center padding-top">
				<p class="left uppercase" >
					<span class="span-category"><a href="<?php echo $linkToACategory; ?>" ><?php echo $articles['cat_name']?></a></span>
					<span class="span-date"><?php echo $date; ?></span>
				</p>
				<p class="right uppercase">
					<span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $articles['contributor_name']; ?></a></span>
				</p>
				<a class="left clear-left" href="<?php echo $linkToArticle; ?>">
					<h1 class="h1-large-article"><?php echo $articles['article_title']?></h1>
				</a>
			</div>
		</div>
		<hr class="padding-top">
		<?php }else{

		$clearLeft='no-padding-right'; 
		if($articleIndex  == 0 || $articleIndex  == 1  || $articleIndex  == 3 || $articleIndex  == 5 || $articleIndex  == 7 || $articleIndex  == 8 || $articleIndex  == 10 || $articleIndex  == 12 || $articleIndex  == 14 || $articleIndex  == 15 || $articleIndex  == 17 || $articleIndex  == 19 || $articleIndex  == 22 ) $clearLeft = 'clear-left no-padding-left';
		$articleIndex++; 
		
		 ?>
		<div class="articles columns mobile-12 small-12 medium-6 large-6 xlarge-6 <?php echo $clearLeft; ?>" id="<?php echo 'article-'.$articleIndex;?>">
			<a class="mobile-5 small-5 medium-12 large-12 xlarge-12" href="<?php echo $linkToArticle; ?>">
				<img src="<?php echo $linkToImage; ?>" alt='<?php echo $articles['article_title']?>'>
			</a>
			<div class="mobile-7 small-7 medium-12 large-12 xlarge-12 mobile-vertical-center padding-top">
				<p class="uppercase small-7 left small-font">
					<span class="span-category"><a href="<?php echo $linkToACategory; ?>" ><?php echo $articles['cat_name']?></a></span>
					<span class="span-date"><?php echo $date; ?></span>
				</p>
				<p class="right uppercase small-5 align-right small-font">
					<span class="span-author">By <a href="<?php echo $linkToContributor; ?>" ><?php echo $articles['contributor_name']; ?></a></span>
				</p>
				<a class="left clear-left" href="<?php echo $linkToArticle; ?>">
					<h1 class="h1-small-article"><?php echo $articles['article_title']?></h1>
				</a>
			</div>
		</div>
		<?php 
			if($articleIndex  == 3 ||  $articleIndex  == 5 || $articleIndex  == 7 || $articleIndex  == 8 || $articleIndex  == 10 || $articleIndex  == 12 || $articleIndex  == 14 || $articleIndex  == 15 || $articleIndex  == 17 || $articleIndex  == 19 || $articleIndex  == 21) echo '<hr class="padding-top">';
	} ?> 
	</div>
	<?php }?>
</div>
</div>
<!--</article>
<hr />-->
<?php } ?>

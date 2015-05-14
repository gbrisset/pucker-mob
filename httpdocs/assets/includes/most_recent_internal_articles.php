<?php 

if( isset( $articleInfoObj ) && isset( $articleInfoObj['article_id']) && $articleInfoObj['article_id']){
	$recentArticles = $mpArticle->getLast10Articles( $articleInfoObj['article_id'] );
}

if( isset($recentArticles) && $recentArticles ){ ?>
	<section id="second-popular-articles" class="columns small-12 no-padding">
		<h3 class="column small-12 margin-top">NEW ON PUCKERMOB</h3>
	<?php 
		$articleNumber = 0;
		$articleTotalNumber = 0;
		foreach($recentArticles as $article){
			$articleTotalNumber++;
		}

		foreach($recentArticles as $article){	
			$articleUrl = 'http://www.puckermob.com/'.$article['cat_dir_name'].'/'.$article['article_seo_title'];
			$imgurl = 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$article['article_id'].'_tall.jpg';	
			$articletitle = $article['article_title'];	
			$date = date("M d, Y", strtotime($article['date_updated']));
			$articleNumber++;
			$mostReadArticle = '';
		?>
		
		<div class="columns small-11 second-popular-articles-cont article-id" id="<?php echo 'article-'.$articleNumber; ?>"  data-info-url="<?php echo $articleUrl; ?>" >
			<div class="row imageContainer" id="<?php echo 'article-'.$articleNumber; ?>">
				<div class="small-12 columns imageCenterer">
					<a  class="" href="<?php echo $articleUrl; ?>" >
						<img src="<?php echo $imgurl; ?>" alt="<?php echo $articletitle; ?>" />
					</a>
				</div>
			</div>				
			<div class="small-12 columns second-popular-article-title">
				<h2 class="left small-12 padding-top">
					<a  class="" href="<?php echo $articleUrl; ?>" >
					<?php echo $mpHelpers->truncate($articletitle, 80); ?>
				    </a>
				</h2>
			</div>
			<div class="second-article-date small-12 clear">
				<label class="small-6" ><?php echo $date; ?></label>
				<label class="small-6 span-shares-holder"></label>
			</div>
		</div>
		
		<?php if($articleNumber == 2 ){ 
		 if(!$promotedArticle){ ?>
		  <!-- NATIVO 2ND AD -->
			<div class="columns small-11 nativo-ad">
				<div class="nativo"></div> 
			</div>
		<?php } 
		 }
					
		} ?>
	</section>
<?php } ?>
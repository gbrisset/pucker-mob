<aside id="left-aside" class="fixed-width-sidebar column no-padding hide-for-print show-on-large-up">
<?php 
	//MOBLOGS ARTICLES
	if(isset($articleInfoObj) ){
		$moblog_articles = $mpArticle->getMoBlogsArticles( $articleInfoObj['article_id'] );
	}else{
		$moblog_articles = $mpArticle->getMoBlogsArticles( );
	}
?>
<div class="div-left-cont">
	<h3>THE MOB</h3>
	<?php foreach( $moblog_articles as $article ){
		$article_url = $config['this_url'].'moblog/'.$article['article_seo_title'];
	?>
	<div class="left-side-img-content">
		<a class="tooltips" href="<?php echo $article_url; ?>" >
			<img src="http://cdn.puckermob.com/articlesites/puckermob/large/<?php echo $article['article_id']; ?>_tall.jpg" alt="<?php echo $article['article_title']; ?>" style="width:80px; height:43px;" />
			<span><?php echo $article['article_title']; ?></span>
		</a>
	</div>
<?php } ?>
	</div>
</aside>
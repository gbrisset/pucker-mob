<?php
$padding = " no-padding ";
if($detect->isMobile()) $padding = " no-padding "; ?>

<?php if(isset($relatedArticles) && $relatedArticles){ ?>
<section id="similar-results" class="columns small-12 hide-for-print sidebar-right <?php echo $padding; ?>">
<hr class="show-for-xxlarge-only hr-hidden">
		<h2>Also in <span><?php echo $category['cat_name']; ?>:</span></h2>
	<div class="row half-padding-left half-padding-right">
		<?php
			$relatedArticleIndex = 0;
			foreach($relatedArticles['articles'] as $article){$relatedArticleIndex++; if($relatedArticleIndex < 7) { ?>
	
			<div class="small-6 medium-4 large-6 xlarge-4 columns half-padding<?php if($relatedArticleIndex === 3 || $relatedArticleIndex === 6) echo ' hide-for-small hide-for-large'; ?>">
			<a href="<?php echo $pagesArray['url'].'/'.$article['article_seo_title']; ?>"><img src="<?php echo $config['image_url'].'articlesites/'.$mpArticle->data['article_page_assets_directory'].'/large/'.$article['article_id'].'_tall.jpg'; ?>" alt="<?php echo $article['article_title']; ?>" /></a>
			<a href="<?php echo $pagesArray['url'].'/'.$article['article_seo_title']; ?>"><h5><?php echo $mpHelpers->truncate($article['article_title'], 50); ?></h5></a>
				
			</div>
			<?php if($relatedArticleIndex === 3) echo '</div><div class="row half-padding-left half-padding-right">'; ?>
			<?php }}?>
		</div>
</section>
<?php } ?>
<?php
$padding = " half-padding ";
$paddingTop = " ";
if($detect->isMobile()) $paddingTop = " padding-top bottom-border"; ?>

<?php if(isset($relatedArticles) && $relatedArticles){ ?>
<section id="similar-results" class="columns small-12 hide-for-print sidebar-right <?php echo $padding; ?>">
<hr class="show-for-xxlarge-only hr-hidden">
	<h2>Also in <span><?php echo $category['cat_name']; ?>:</span></h2>
	<div class="row half-padding-left half-padding-right">
		<?php
			$relatedArticleIndex = 0;
			foreach($relatedArticles as $article){$relatedArticleIndex++; if($relatedArticleIndex < 7) { ?>
	
			<div id="similar-article-<?php echo $relatedArticleIndex; ?>"class="mobile-12 small-12 medium-6 large-6 xlarge-4 columns half-padding<?php if($relatedArticleIndex === 3 || $relatedArticleIndex === 6) echo ' hide-for-small hide-for-large'; ?> <?php echo $paddingTop; ?>">
			<a href="<?php echo 'http://www.puckermob.com/'.$category['cat_dir_name'].'/'.$article['article_seo_title']; ?>"><img src="<?php echo 'http://cdn.puckermob.com/articlesites/puckermob/large/'.$article['article_id'].'_tall.jpg'; ?>" alt="<?php echo $article['article_title']; ?>" /></a>
			<a href="<?php echo 'http://www.puckermob.com/'.$category['cat_dir_name'].'/'.$article['article_seo_title']; ?>"><h5><?php echo $article['article_title']; ?></h5></a>
				
			</div>
			<?php if($relatedArticleIndex === 3) echo '</div><div class="row half-padding-left half-padding-right">'; ?>
			<?php }}?>
		</div>
</section>
<?php } ?>
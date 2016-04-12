<?php 
$articles_list  = $adminController->user->getTop5ArticlesByPageviews(5, $contributor_id);

if($articles_list){
?>
<div class="small-12 columns show-for-large-up no-padding">
	<div class="small-12 columns radius hottopics">
		<h3 class="margin-top bold">YOUR TOP 5 ARTICLES</h3>
		<div class="">
			<ol>
				<?php foreach($articles_list as $articles){ ?>
				<li id="article_<?php echo $articles['article_id']; ?>" class="padding-bottom">
					<label>
						<a href="http://www.puckermob.com/<?php echo $articles['cat_dir_name'].'/'.$articles['article_seo_title']; ?>"><?php echo $articles['article_title']; ?></a>
					</label>
				</li>
				<?php } ?>
			</ol>
		</div>
	</div>
</div>
<?php } ?>
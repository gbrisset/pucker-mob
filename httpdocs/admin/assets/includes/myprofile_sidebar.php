	<?php

		$contributor_id = isset($contributorInfo['contributor_id']) ? $contributorInfo['contributor_id'] : 0;

		//$contributor_id = $userInfo['contributor_id'];

		$last_posted_date = $adminController->user->getLastPostedArticle($contributor_id);

		$post_this_month = $adminController->user->articlesPublisThisMonth($contributor_id);

		$most_popular_articles = $adminController->user->mostPopularPost($contributor_id);
		//var_dump( $contributor_id, $last_posted_date, $post_this_month,  $most_popular_article ); die;

	?>

	<div class="small-12 columns radius right-side-box no-margin-top">
		<h3 class="margin-top bold">LAST POSTED:</h3>
		<div class="">
			<label><?php echo date('F d, Y',strtotime($last_posted_date['creation_date']));?></label>
		</div>
	</div>

	<div class="small-12 columns radius right-side-box margin-top">
		<h3 class="margin-top bold">POSTS THIS MONTH:<span style="margin-left: 10px;"><?php echo $post_this_month['total']; ?></span></h3>
	</div>

	<div class="small-12 columns radius right-side-box margin-top">
		<h3 class="margin-top bold">MOST POPULAR POST:</h3>
		<div class="">
			<?php if($most_popular_articles){
				foreach( $most_popular_articles as $most_popular_article ){
			?>
				<label id="article_id_<?php echo $most_popular_article['article_id']; ?>"><a href="http://www.puckermob.com/<?php echo $most_popular_article['cat_dir_name'].'/'.$most_popular_article['article_seo_title']; ?>" target="_blank"><?php echo $most_popular_article['article_title']?></a></label>
			<?php } 
			}else{ ?>
					<label>NONE</label>
				<?php } ?>
		</div>
	</div>
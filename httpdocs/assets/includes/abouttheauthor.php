<section id="about-the-author" class="columns small-12 hide-for-print sidebar-right">
	<div id="about-the-author-bg" class="columns small-12">
	<div class="row">
	<div class="small-12 columns">
	<h4>About the Author: <a href = "<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>"><?php echo $articleInfoObj["contributor_name"]; ?></a></h4>
	</div>
	</div>
	<?php 
		$bio = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_bio"])));
		$name = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_name"])));
	?>
<a href="<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>">
		<img src="<?php echo $config['image_url'].'articlesites/contributors_redesign/'.$articleInfoObj['contributor_image'];?>" alt="<?php echo $articleInfoObj['contributor_name']; ?> Image" class="shadow author-image" />
	</a>
	<p><?php echo $mpHelpers->truncate(trim(strip_tags($articleInfoObj['contributor_bio'])), 250); ?> <a href="<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>" >MORE</a></p> 
	<div id="author-links" class="columns small-12">
				<?php if(isset($articleInfoObj['contributor_facebook_link']) && strlen($articleInfoObj['contributor_facebook_link'])){ ?>
					<a href="<?php echo $articleInfoObj['contributor_facebook_link']; ?>" class="button small facebook" target="_blank"><i class="fa fa-facebook"></i>Facebook</a>
				<?php } ?>
				<?php if(isset($articleInfoObj['contributor_twitter_handle']) && strlen($articleInfoObj['contributor_twitter_handle'])){ ?>
					<a href="http://www.twitter.com/<?php echo $articleInfoObj['contributor_twitter_handle']; ?>" class="button small twitter" target="_blank"><i class="fa fa-twitter"></i>Twitter</a>
				<?php } ?>
				<?php if(isset($articleInfoObj['contributor_blog_link']) && strlen($articleInfoObj['contributor_blog_link'])){ ?>
					<a href="<?php echo $articleInfoObj['contributor_blog_link']; ?>" class="button small" target="_blank">
						<i class="fa fa-external-link"></i><?php echo explode(' ', $articleInfoObj['contributor_name'])[0]; ?>'s Website
					</a>
				<?php } ?>
		<a class="button small" href="<?php echo $config['this_url'].'contributors';?>"><i class="fa fa-users"></i>More Contributors</a>
	</div>
	</div>
</section>
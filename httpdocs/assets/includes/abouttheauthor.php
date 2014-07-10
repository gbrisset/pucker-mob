<?php
$class = " column small-12 hide-for-print sidebar-right  no-padding ";
if($detect->isMobile()) $class = " column small-12 hide-for-print sidebar-right no-padding "; ?>

<section id="about-the-author" class="<?php echo $class; ?>">
	<div id="about-the-author-bg" class="columns small-12">
		<?php 
		$bio = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_bio"])));
		$name = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_name"])));
		?>
		<a href="<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>">
			<img src="<?php echo $config['image_url'].'articlesites/contributors_redesign/'.$articleInfoObj['contributor_image'];?>" alt="<?php echo $articleInfoObj['contributor_name']; ?> Image" class="author-image" />
		</a>
		<h4>Written By <a href = "<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>"><?php echo $articleInfoObj["contributor_name"]; ?></a></h4>
		<p><?php echo $mpHelpers->truncate(trim(strip_tags($articleInfoObj['contributor_bio'])), 200); ?> <a href="<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>" >MORE</a></p> 
			<?php if(isset($articleInfoObj['contributor_facebook_link']) && strlen($articleInfoObj['contributor_facebook_link'])){ ?>
			<a href="<?php echo $articleInfoObj['contributor_facebook_link']; ?>" class="social-link" target="_blank">Facebook</a>
			<?php } ?>
			<?php if(isset($articleInfoObj['contributor_twitter_handle']) && strlen($articleInfoObj['contributor_twitter_handle'])){ ?>
			<a href="http://www.twitter.com/<?php echo $articleInfoObj['contributor_twitter_handle']; ?>" class="social-link" target="_blank">Twitter</a>
			<?php } ?>
			<?php if(isset($articleInfoObj['contributor_blog_link']) && strlen($articleInfoObj['contributor_blog_link'])){ ?>
			<a href="<?php echo $articleInfoObj['contributor_blog_link']; ?>" class="social-link" target="_blank">Visit 
				<?php echo explode(' ', $articleInfoObj['contributor_name'])[0]; ?>'s Website
			</a>
			<?php } ?>
		
		
	</div>
</section>
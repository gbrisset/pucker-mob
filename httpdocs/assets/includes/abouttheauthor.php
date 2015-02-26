
<?php
$class = " column small-12 hide-for-print sidebar-right  no-padding ";
if($detect->isMobile()) $class = " column small-12 hide-for-print sidebar-right no-padding "; ?>

<!--<section id="about-the-author" class="<?php echo $class; ?>">
	<div id="about-the-author-bg" class="columns small-12">
		<?php 
		$bio = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_bio"])));
		$name = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_name"])));
		?>
		<a href="<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>">
			<img src="<?php echo $config['image_url'].'articlesites/contributors_redesign/'.$articleInfoObj['contributor_image'];?>" alt="<?php echo $articleInfoObj['contributor_name']; ?> Image" class="author-image" />
		</a>
		<h4>Written By <a href = "<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>"><?php echo $articleInfoObj["contributor_name"]; ?></a></h4>
		
		<?php if(!$detect->isMobile()){ ?>
		<p>
			<?php echo $mpHelpers->truncate(trim(strip_tags($articleInfoObj['contributor_bio'])), 200); 
		}?> 
			<a href="<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>" >MORE</a>
		</p> 
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
			<?php } 
		?>
		
		
	</div>
</section>-->
<?php 
	$bio = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_bio"])));
	$name = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_name"])));
?>
<?php if($detect->isMobile() ){?>
	<section id="about-the-author" class="columns small-12 hide-for-print half-padding">
<?php }else{?>
	<section id="about-the-author" class="columns small-12 hide-for-print no-padding">
<?php }?>
	<div id="about-the-author-bg" class="columns small-10 no-padding margin-top margin-bottom">
		<div class="columns no-padding small-2" style="min-width: 70px; margin-right: 1rem;">
			<a href="<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>">
				<img src="<?php echo 'http://images.puckermob.com/articlesites/contributors_redesign/1103_contributor.png';//$config['image_url'].'articlesites/contributors_redesign/'.$articleInfoObj['contributor_image'];?>" alt="<?php echo $articleInfoObj['contributor_name']; ?> Image" class="author-image" />
			</a>
		</div>
		<div class="author-info columns no-padding">
			<h4>BY: <a href = "<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>"><?php echo $articleInfoObj["contributor_name"]; ?></a></h4>
			<p class="author-on-mobile-small"><?php echo $mpHelpers->truncate(trim(strip_tags($articleInfoObj['contributor_bio'])), 25); ?> <a href="<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>" >MORE</a></p> 
			<p class="author-on-medium-up"><?php echo $mpHelpers->truncate(trim(strip_tags($articleInfoObj['contributor_bio'])), 50); ?> <a href="<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>" >MORE</a></p> 
			<div id="author-links">
						<?php if(isset($articleInfoObj['contributor_facebook_link']) && strlen($articleInfoObj['contributor_facebook_link'])){ ?>
							<a href="<?php echo $articleInfoObj['contributor_facebook_link']; ?>" class="button small facebook" target="_blank"><i class="fa fa-facebook"></i>Facebook</a>
						<?php } ?>
						<?php if(isset($articleInfoObj['contributor_twitter_handle']) && strlen($articleInfoObj['contributor_twitter_handle'])){ ?>
							<a href="http://www.twitter.com/<?php echo $articleInfoObj['contributor_twitter_handle']; ?>" class="button small twitter" target="_blank"><i class="fa fa-twitter"></i>Twitter</a>
						<?php } ?>
						<?php if(isset($articleInfoObj['contributor_blog_link']) && strlen($articleInfoObj['contributor_blog_link'])){ ?>
							<a href="<?php echo $articleInfoObj['contributor_blog_link']; ?>" class="button small hide-on-small-and-mobile" target="_blank">
								<i class="fa fa-external-link"></i><?php echo explode(' ', $articleInfoObj['contributor_name'])[0]; ?>'s Website
							</a>
						<?php } ?>

				<a class="button small more-contributors hide-on-small-and-mobile" href="<?php echo $config['this_url'].'contributors';?>"><i class="fa fa-users"></i>More Contributors</a>
			</div>
		</div>
	</div>
	<div id="follow-the-author-bg" class="columns small-2 no-padding margin-top margin-bottom">
		<a class="follow-author" id="follow-author" href="">Follow this author</a>
	</div>
</section>

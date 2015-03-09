
<?php
$class = " column small-12 hide-for-print sidebar-right  no-padding ";
if($detect->isMobile()) $class = " column small-12 hide-for-print sidebar-right no-padding "; ?>

<?php 
	$bio = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_bio"])));
	$name = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_name"])));
	$ss_user_id=0;
	$ss_user_email = '';
	$userInfo =  $adminController->user->getUserInfo();
	if(!isset($userInfo) || !$userInfo) $userInfo = $follow->getReaderInfo();
	if(isset($_SESSION) && isset($_SESSION['user_id'])) $ss_user_id = $_SESSION['user_id'];

	if($userInfo) $ss_user_email = $userInfo['user_email'];

	$following_this_author = $follow->isFollowingThisAuthor($userInfo['user_email'], $contributor_id);

	//var_dump($adminController->user->getUserInfo());
	
?>
<div class="row">
<?php if($detect->isMobile() ){?>
	<section id="about-the-author" class="small-12 hide-for-print padding">
		<div id="about-the-author-bg" class="columns small-10 no-padding margin-top">
		<div class="columns no-padding small-2" style="min-width: 70px; margin-right: 0rem;">
<?php }else{?>
	<section id="about-the-author" class="columns small-12 hide-for-print">
		<div id="about-the-author-bg" class="columns small-10 no-padding">
		<div class="columns no-padding small-2" style="min-width: 70px; margin-right: 1rem;">
<?php }?>
	
			<a href="<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>">
				<img src="<?php echo 'http://images.puckermob.com/articlesites/contributors_redesign/'.$articleInfoObj['contributor_image'];?>" alt="<?php echo $articleInfoObj['contributor_name']; ?> Image" class="author-image" style="max-height: 91px;"/>
			</a>
		</div>
		<div class="author-info columns no-padding">
			<input type="hidden" id="ss_user_id" value="<?php echo $ss_user_id; ?>" />
			<input type="hidden" id="ss_user_email" value="<?php echo $ss_user_email; ?>" />
			<input type="hidden" id="ss_author_id" value="<?php echo $articleInfoObj['contributor_id']?>" />
			<h4>BY: <a href = "<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>"><?php echo $articleInfoObj["contributor_name"]; ?></a></h4>
			<!--<p class="author-on-mobile-small hide-on-small-and-mobile"><?php //echo $mpHelpers->truncate(trim(strip_tags($articleInfoObj['contributor_bio'])), 40); ?> <a href="<?php //echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>" >MORE</a></p>--> 
			<p class="author-on-medium-up"><?php echo $mpHelpers->truncate(trim(strip_tags($articleInfoObj['contributor_bio'])), 50); ?> <a href="<?php echo $config['this_url'].'contributors/'.$articleInfoObj['contributor_seo_name']; ?>" >MORE</a></p> 
			<div id="author-links">
						<?php if(isset($articleInfoObj['contributor_facebook_link']) && strlen($articleInfoObj['contributor_facebook_link'])){ ?>
							<a href="<?php echo $articleInfoObj['contributor_facebook_link']; ?>" class="button small facebook" target="_blank"><i class="fa fa-facebook"></i>Facebook</a>
						<?php } ?>
						<?php if(isset($articleInfoObj['contributor_twitter_handle']) && strlen($articleInfoObj['contributor_twitter_handle'])){ ?>
							<!--<a href="http://www.twitter.com/<?php echo $articleInfoObj['contributor_twitter_handle']; ?>" class="button small twitter" target="_blank"><i class="fa fa-twitter"></i>Twitter</a>-->
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
	<div id="follow-the-author-bg" class="columns small-2 no-padding author-on-medium-up">
		<?php if( $following_this_author ){?>
			<label class="follow-author" ><i class="fa fa-check"></i>Author Followed</label>
		<?php }else{?>
			<a class="follow-author" id="follow-author" >Follow this author</a>
		<?php }?>
	</div>
	<!--<div class="small-12 columns author-on-medium-up">
		<p id="author-action-message"></p>
	</div>-->
	</section>
</div>


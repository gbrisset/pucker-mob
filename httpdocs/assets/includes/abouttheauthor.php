
<?php 
$class = " column small-12 hide-for-print sidebar-right  no-padding ";
if($detect->isMobile()) $class = " column small-12 hide-for-print sidebar-right no-padding "; ?>

<?php 
	$bio = $name = $seo_name = '' ;
	$image_name = 'pm_avatars_1.png';

	if(isset($articleInfoObj)){
		$bio = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_bio"])));
		$name = htmlspecialchars(trim(strip_tags($articleInfoObj["contributor_name"])));
		$seo_name = $articleInfoObj['contributor_seo_name'];
		if( !empty($articleInfoObj['contributor_image']) ) $image_name = $articleInfoObj['contributor_image'];
	}
	$ss_user_id=0;
	$ss_user_email = '';
	$ss_author_id = 0;
	$userInfo =  $adminController->user->getUserInfo();
	if(!isset($userInfo) || !$userInfo) $userInfo = $follow->getReaderInfo();
	if(isset($_SESSION) && isset($_SESSION['user_id'])) $ss_user_id = $_SESSION['user_id'];

	if(isset($articleInfoObj)) $ss_user_id = $articleInfoObj['contributor_id'];
	if($userInfo) $ss_user_email = $userInfo['user_email'];

	$following_this_author = $follow->isFollowingThisAuthor($userInfo['user_email'], $contributor_id);	
?>
<div class="row clear">
	<?php if($detect->isMobile() ){?>
		<section id="about-the-author" class="small-12 hide-for-print padding">
			<div id="about-the-author-bg" class="columns small-10 no-padding margin-top">
				<!--<div class="columns no-padding small-4">
					<a href="<?php echo $config['this_url'].'contributors/'.$seo_name; ?>">
						<img src="<?php echo 'http://cdn.puckermob.com/articlesites/contributors_redesign/'.$image_name;?>" alt="<?php echo $name; ?> Image" class="author-image right" style="max-height: 90px; "/>
					</a>
				</div>-->
				<div class="author-info columns no-padding small-12" style="margin: 0;">
					<input type="hidden" id="ss_user_id" value="<?php echo $ss_user_id; ?>" />
					<input type="hidden" id="ss_user_email" value="<?php echo $ss_user_email; ?>" />
					<input type="hidden" id="ss_author_id" value="<?php echo $ss_user_id; ?>" />
					<h4 small-12 columns>BY: <a href = "<?php echo $config['this_url'].'contributors/'.$seo_name; ?>"><?php echo $name; ?></a></h4>
				</div>
			</div>
		</section>
	<?php }else{?>
		<section id="about-the-author" class="columns small-12 hide-for-print">
			<div id="about-the-author-bg" class="columns small-10 no-padding">
				<div class="columns no-padding small-2" style="min-width: 70px; margin-right: 1rem;">
					<a href="<?php echo $config['this_url'].'contributors/'.$seo_name; ?>">
						<img src="<?php echo 'http://cdn.puckermob.com/articlesites/contributors_redesign/'.$image_name;?>" alt="<?php echo $name; ?> Image" class="author-image right" style="max-height: 90px; "/>
					</a>
				</div>
				<div class="author-info columns no-padding small-7">
					<input type="hidden" id="ss_user_id" value="<?php echo $ss_user_id; ?>" />
					<input type="hidden" id="ss_user_email" value="<?php echo $ss_user_email; ?>" />
					<input type="hidden" id="ss_author_id" value="<?php echo $ss_user_id; ?>" />
					<h4>BY: <a href = "<?php echo $config['this_url'].'contributors/'.$seo_name; ?>"><?php echo $name; ?></a></h4>
					<?php if(!$detect->isMobile()){?>
						<p class="author-on-medium-up"><?php echo $mpHelpers->truncate(trim(strip_tags($bio)), 50); ?> <a href="<?php echo $config['this_url'].'contributors/'.$seo_name; ?>" >MORE</a></p> 
							<div id="author-links">
								<?php if(isset($articleInfoObj['contributor_facebook_link']) && strlen($articleInfoObj['contributor_facebook_link'])){ ?>
									<a href="<?php echo $articleInfoObj['contributor_facebook_link']; ?>" class="button small facebook" target="_blank"><i class="fa fa-facebook"></i>Facebook</a>
								<?php } ?>
								<?php if(isset($articleInfoObj['contributor_twitter_handle']) && strlen($articleInfoObj['contributor_twitter_handle'])){ ?>
								<?php } ?>
								<?php if(isset($articleInfoObj['contributor_blog_link']) && strlen($articleInfoObj['contributor_blog_link'])){ ?>
									<a href="<?php echo $articleInfoObj['contributor_blog_link']; ?>" class="button small hide-on-small-and-mobile" target="_blank">
										<i class="fa fa-external-link"></i><?php echo explode(' ', $name)[0]; ?>'s Website
									</a>
								<?php } ?>

								<a class="button small more-contributors hide-on-small-and-mobile" href="<?php echo $config['this_url'].'contributors';?>"><i class="fa fa-users"></i>More Contributors</a>
							</div>
					<?php } ?>
			
				</div>
			</div>
			<div id="follow-the-author-bg" class="columns small-2 no-padding author-on-medium-up">
				<?php if( $following_this_author ){?>
					<label class="follow-author" ><i class="fa fa-check"></i>Author Followed</label>
				<?php }else{?>
					<a class="follow-author" id="follow-author" >Follow this author</a>
				<?php }?>
			</div>
		</section>
	<?php }?>		
</div>


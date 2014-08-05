<?php
	require_once('assets/php/config.php');
	require_once('assets/php/newsletter.php');
	
	$email_to = $mpArticle->data['article_page_advertise_contact_email'];
	require_once('assets/php/contactform.php');
	
	$pageName = $mpArticle->data['article_page_name'];
	$omits = [];
	//$mostReadArticles = $mpArticle->getArticles(['count' => 4, 'sortType' => 2]);
	$promotedArticles = $mpArticle->getArticles(['count' => 4, 'featured' => true]);
	$featuredContributor = $mpArticle->getContributors(['featured' => true]);
	// $relatedPods = $mpShared->getCategoryPods(['count' => 12, 'categoryId' => $mpArticle->data['cat_id']]);

	$featuredArticle = $mpArticle->getFeatured(['featureType' => 2, 'articleCount' => 1, 'pageId' => 1]);
	if(is_array($featuredArticle) && isset($featuredArticle['ids'])) $omits = array_merge($omits, $featuredArticle['ids']);
	
	$recentArticles = $mpArticle->getArticles(['count' =>8, 'omit' => $omits]);
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php include_once($config['include_path'].'head.php');?>
<body>
	<?php include_once($config['include_path'].'header.php');?>

	<?php include_once($config['include_path'].'sidebarsearch.php'); ?>

	<?php //include_once($config['include_path'].'superbanner.php'); ?>
	
	<section id="maint-cont" role="content" class="advertise-cont">
		
		<section class="top-content">
			<div class="left-content">
			
			<section id="misc-page-heading">
				<h1>Advertise with us</h1>
			</section>
			
			<section id="advertise-with-us-cont">
				<p>
					We offer a full range of video, display and content opportunities for our marketing partners, and will work to tailor a plan optimized for your specific campaign goals.
				</p>
				<div class="body-desc">
					<p>Download our <a href="<?php echo $config['this_url'].'assets/pdfs/'.$mpArticle->data['article_page_sell_sheet']?>" target="_blank">media kit</a> for additional detail.</p>
				</div>
			</section>
			
			<section id="contact-us-cont">
				<p>Contact us below for pricing information and all other inquiries:</p>
				<form id="adv-contact-form" name="adv-contact-form" action="" method="POST">
					<fieldset>
						<label for="name">Your Name <span>*</span>:</label>
						<input type="text" id="name" name="name" value="" placeholder="Please enter your name here." required />
					</fieldset>
					
					<fieldset>
						<label for="name">Company Name <span></span>:</label>
						<input type="text" id="companyname" name="companyname" value="" placeholder="Please enter the company name here." />
					</fieldset>
	
					<fieldset>
						<label for="email">E-mail <span>*</span>:</label>
						<input type="email" id="email" name="email" value="" placeholder="Please enter your email address here." required />
					</fieldset>
					
					<fieldset>
						<label for="phonenumber">Phone Number <span></span>:</label>
						<input type="text" id="phonenumber" name="phonenumber" value="" placeholder="Please enter your phone number here." />
					</fieldset>
					
					<fieldset>
						<label for="message">Message <span>*</span>:</label>
						<textarea name="message" id="message" rows="10" placeholder="Please enter your message here." required ></textarea>
					</fieldset>
	
					<fieldset>
						<button type="submit" id="contactsubmit" name="contactsubmit">Send</button>
						<div id="div-result">
							<p id="result" <?php if(isset($formStatus)) echo ($formStatus) ? 'class="success"' : 'class="error"'; ?>><?php if(isset($formStatusMsg)) echo $formStatusMsg; ?></p>						
						</div>
					</fieldset>
				</form>
			</section>
		</div>
			<div class="right-content">	
				<?php include_once($config['include_path'].'rightsidebar.php');?>
			</div>
	</section>

	<section class="bottom-content">
		<div class="left-content">
		</div>
		<div class="right-content">
			<section id="featured-article-ph" data-set="featured-article-append-around"></section>
			<section id="featured-ask-ph" data-set="featured-ask-append-around"></section>
			<section id="recipe-box-ph" data-set="recipe-box-append-around"></section>	
			<section id="sidebar-most-viewed-ph" data-set="most-viewed-append-around"></section>
		</div>
	</section>
</section>	
	<?php include_once($config['include_path'].'superbannerbottom.php'); ?>
	
	<?php include_once($config['include_path'].'footer.php');?>
	
	<?php include_once($config['include_path'].'bottomscripts.php');?>
</body>
</html>
<?php
	require_once('../assets/php/config.php');
	$email_to = $mpArticle->data['article_page_contact_email'];
	require_once('../assets/php/contactform.php');
	$pageName = $mpArticle->data['article_page_name'];
	$omits = [];
	$featuredContributor = $mpArticle->getContributors(['featured' => true]);
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

	<main id="main" class="row panel sidebar-on-right" role="main">
	<section id="puc-articles" class="sidebar-right shadow-on-large-up small-11 columns translate-fix sidebar-main-left">
		
		<section class="top-content">
			<div class="left-content">
			
				<section id="misc-page-heading">
					<h1>Write for <?php echo $mpArticle->data['article_page_visible_name']; ?></h1>
				</section>
				
				<section id="write-for-us-cont">
					<h2>
						We're always on the look-out for new contributors to join our growing network.  If you're a passionate, creative voice looking to gain exposure, we’d love to hear from you!
					</h2>
					<div class="body-desc"></div>
				</section>
				
				<section id="look-cont">
					<h2>What we look for:</h2>
					<div class="body-desc">
						
							<p>
								<strong>Length:</strong>
								There are no hard and fast rules, but most posts are between 500-1000 words. Recipes and other list-form posts should include at least a 100-word introductory paragraph.</p>
							<p>
								<strong>Positioning:</strong>
								A generally helpful, positive tone is encouraged, but don’t be afraid to take a stand on issues and let your voice shine.  The most popular pieces tend to blend detailed information 
								with actionable advice on trending topics, e.g. “Top 10 DIY Yoga Poses for the Beginner”, “Is Buying Organic Really Worth It?,” etc.
							</p>
							<p>
								<strong>Your background:</strong>
								Our contributors vary from PhDs with published academic works to at-home parents with amazing family recipes and inspirational stories.  We welcome all levels of professional writing experience, 
								but content should be based on at least one of the following: 1) first-hand experience, 2) professional expertise, 3) cited second-party information in interview form, 4) credible (and cited) third-party sources.
							</p>
							<p>
								<strong>Originality:</strong>
								Your material must be original and not published elsewhere on the web.
							</p>
					</div>		
				</section>
				
				<section id="guidelines-tips-cont">
					<h2>What we generally turn down:</h2>
					<div class="body-desc">
						<p>
							Content written primarily for search engine optimization (SEO) efforts (e.g. keyword stuffing, irrelevant outbound links, etc.).  In lieu of monetary consideration, we do allow contributors to include one 
							link per article to a personal blog / website as well as a brief bio as part of a dedicated contributor page; however, these should be complimentary and not the sole or primary emphasis of the content.
						</p>
						<p>
							‘Advertorial’ pieces or content written primarily for the promotion of a third-party business or product.
						</p>
					</div>		
				</section>
				
				<section id="contact-us-cont">
					<h2>Interested?  Submit your info on the contact form below, and we’ll be in touch!</h2>
					<p></p>
					<form id="contact-form" name="contact-form" action="" method="POST">
						<fieldset>
							<label for="name">Your Name <span>*</span>:</label>
							<input type="text" id="name" name="name" value="" placeholder="Please enter your name here." required />
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
			</section>
		</section>
<?php include_once($config['include_path'].'rightsidebar.php');?>
	</main>
	<?php include_once($config['include_path'].'footer.php');?>
	
	<?php include_once($config['include_path'].'bottomscripts.php');?>
</body>
</html>

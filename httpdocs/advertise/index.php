<?php
	require_once('../assets/php/config.php');
	$email_to = $mpArticle->data['article_page_advertise_contact_email'];
	require_once('../assets/php/contactform.php');
	$pageName = $mpArticle->data['article_page_name'];
	
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<?php include_once($config['include_path'].'head.php');?>
<body id="advertise">
<?php include_once($config['include_path'].'header.php');?>
<?php include_once($config['include_path'].'header_ad.php'); ?>

<main id="main" class="row panel sidebar-on-right" role="main">
		<section id="puc-articles" class="sidebar-right  mobile-12 small-12 medium-12 large-11 columns translate-fix sidebar-main-left">
<section class="small-12 columns sidebar-right">
				<h1>Advertise with Us</h1>
			
				<p>
					We offer a full range of video, display and content opportunities for our marketing partners, and will work to tailor a plan optimized for your specific campaign goals.
				</p>
					<p>Download our <a href="<?php echo $config['this_url'].'assets/pdfs/'.$mpArticle->data['article_page_sell_sheet']?>" target="_blank">media kit</a> for additional detail.</p>
				<p>Contact us below for pricing information and all other inquiries:</p>
				<form id="adv-contact-form" name="adv-contact-form" action="" method="POST">
					<fieldset>
						<label for="name">Your Name
						<input type="text" id="name" name="name" value="" placeholder="Please enter your name here." required />
						</label>
						<label for="companyname">Company Name
						<input type="text" id="companyname" name="companyname" value="" placeholder="Please enter the company name here." />
						</label>
						<label for="email">E-mail
						<input type="email" id="email" name="email" value="" placeholder="Please enter your email address here." required />
						</label>
						<label for="phonenumber">Phone Number
						<input type="text" id="phonenumber" name="phonenumber" value="" placeholder="Please enter your phone number here." />
						</label>
						<label for="message">Message
						<textarea name="message" id="message" rows="10" placeholder="Please enter your message here." required ></textarea>
						</label>
						<button type="submit" id="contactsubmit" name="contactsubmit">Send</button>
						<div id="div-result">
							<p id="result" <?php if(isset($formStatus)) echo ($formStatus) ? 'class="success"' : 'class="error"'; ?>><?php if(isset($formStatusMsg)) echo $formStatusMsg; ?></p>						
						</div>
					</fieldset>
				</form>
</section>

<?php if (!$detect->isMobile()) { ?>
				<div id="medianet-ad" class="ad-unit hide-for-print padding-right show-for-xxlarge-only"></div>
				<?php include_once($config['include_path'].'fromourpartners.php'); ?>
				<?php include_once($config['include_path'].'aroundtheweb.php'); 
			}?>
</section>
<?php 
	if ( !$detect->isMobile() ) { 
		include_once($config['include_path'].'rightsidebar.php');
	 }
	 ?>
</main>
<?php include_once($config['include_path'].'footer.php');?>
<?php include_once($config['include_path'].'bottomscripts.php');?>
</body>
</html>